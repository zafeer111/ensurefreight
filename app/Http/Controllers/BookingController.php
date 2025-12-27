<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\AirlineAddress;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Quotation;
use App\Repositories\Bol\IBol;
use App\Repositories\Booking\IBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Knp\Snappy\Pdf;
use Illuminate\Support\Facades\View;

class BookingController extends Controller
{
    protected $bookingRepository;
    protected $bolRepository;

    public function __construct(IBooking $bookingRepository, IBol $bolRepository)
    {
        $this->middleware('auth.check');
        $this->bookingRepository = $bookingRepository;
        $this->bolRepository = $bolRepository;
    }

    public function index()
    {
        $user = auth()->user();
        $bookings = $this->bookingRepository->getUserBookings($user->id);

        return view('bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $booking = $this->bookingRepository->findUserBooking($user->id, $id);

        return view('bookings.show', compact('booking'));
    }

    public function create($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        return view('bookings.create', compact('booking'));
    }

    public function store(BookingRequest $request)
    {
        try {
            $bookingData = $request->validated();
            $booking = $this->bookingRepository->createBooking($bookingData);

            return response()->json(['message' => 'Booking created successfully', 'booking_id' => $booking->id], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create booking', 'error' => $e->getMessage()], 500);
        }
    }

    public function generateBOLPDF(Request $request)
    {
        try {
            $booking_id = $request->input('booking_id');

            $booking = Booking::findOrFail($booking_id);
    
            $quotation = Quotation::findOrFail($booking->quotation_id);
    
            $inquiry = $quotation->inquiry;

            // Retrieve the carrier ID from the booking
            $carrier_id = $booking->carrier_id;

            // Find the airline address record based on the carrier ID
            $airline_address = AirlineAddress::where('carrier_id', $carrier_id)->first();

            $bol = $request->only([
                'booking_id',
                'customer_order_no',
                'packages',
                'quantity_number',
                'select_type',
                'nmfc_no',
                'class',
                'currency',
                'amount',
                'fob',
                'trailer_loaded_shipper',
                'trailer_loaded_driver',
                'freight_counted_shipper',
                'freight_counted_driver_pallets',
                'freight_counted_driver_pieces',
            ]);
    
            $additionalInformation = [
                'customer_order_no' => $bol['customer_order_no'],
                'packages' => $bol['packages'],
                'quantity_number' => $bol['quantity_number'],
                'select_type' => $bol['select_type'],
                'nmfc_no' => $bol['nmfc_no'],
                'class' => $bol['class'],
                'currency' => strtoupper($bol['currency']),
                'amount' => $bol['amount'],
                'fob' => $bol['fob'],
                'trailer_loaded_shipper' => $bol['trailer_loaded_shipper'],
                'trailer_loaded_driver' => $bol['trailer_loaded_driver'],
                'freight_counted_shipper' => $bol['freight_counted_shipper'],
                'freight_counted_driver_pallets' => $bol['freight_counted_driver_pallets'],
                'freight_counted_driver_pieces' => $bol['freight_counted_driver_pieces'],
            ];
    
            $bol['additional_information'] = json_encode($additionalInformation);
    
            $data = [
                'booking' => $booking,
                'inquiry' => $inquiry,
                'quotation' => $quotation,
                'bol' => $bol,
                'airline_address' => $airline_address,
            ];

            $html = View::make('bol', $data)->render();

            $outputFilename = 'bol.pdf';

            // Check if the file already exists
            if (file_exists($outputFilename)) {
                // Delete the existing file
                unlink($outputFilename);
            }

            // Generate PDF from HTML
            $pdf = new Pdf('"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"');

            $pdf->generateFromHtml($html, $outputFilename);

            // Store the PDF file in the public/pdf directory
            $pdfPath = 'pdf/' . $outputFilename;
            Storage::disk('public')->put($pdfPath, file_get_contents($outputFilename));

            // Store BOL data using the repository
            $this->bolRepository->create($bol);

            return response()->download($outputFilename);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['message' => 'Failed to generate PDF', 'error' => $e->getMessage()], 500);
        }
    }
}