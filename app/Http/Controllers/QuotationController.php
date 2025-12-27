<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuotationRequest;
use App\Models\Inquiry;
use App\Repositories\Quotation\IQuotation;
use App\Repositories\QuotationRepositoryInterface;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    protected $quotationRepository;

    public function __construct(IQuotation $quotationRepository)
    {
        $this->quotationRepository = $quotationRepository;
    }

    public function index()
    {
        $user = auth()->user();
        $quotations = $this->quotationRepository->index($user->id);

        return view('quotes.index', compact('quotations'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $quotation = $this->quotationRepository->show($user->id, $id);
        
        return view('quotes.show', compact('quotation'));
    }

    public function store(QuotationRequest $request)
    {
        $validated = $request->validated();
        $quotation = $this->quotationRepository->store($validated);
        return response()->json($quotation, 201);
    }

    public function updateStatus(Request $request, $quotationId, $lineItemId)
    {
        $status = $request->input('status');

        $result = $this->quotationRepository->updateStatus($quotationId, $lineItemId, $status);

        if ($result) {
            return response()->json(['message' => 'Status updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to update status'], 500);
        }
    }

    public function downloadQuote(Request $request)
    {
        $inquiryId = $request->input('inquiry_id');

        $inquiry = Inquiry::findOrFail($inquiryId);

         // Get the PDF content
        $pdfContent = $this->quotationRepository->sendQuoteEmail($inquiry);

        // Ensure PDF content is not empty
        if (empty($pdfContent)) {
            return response()->json(['error' => 'PDF content is empty.'], 500);
        }

        // Return the PDF content as a downloadable file
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="quote.pdf"');
    }
}