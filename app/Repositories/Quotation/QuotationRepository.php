<?php

namespace App\Repositories\Quotation;

use App\Jobs\ProcessQuotation;
use App\Models\Quotation;
use App\Models\QuotationLineItem;
use App\Repositories\Quotation\IQuotation;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;

class QuotationRepository implements IQuotation
{
    public function index($userId)
    {
        return Quotation::where('customer_user_id', $userId)->get();
    }

    public function show($userId, $id)
    {
        return Quotation::where('customer_user_id', $userId)->findOrFail($id);
    }

    public function store(array $data)
    {
        $quotation = new Quotation([
            'inquiry_id' => $data['inquiry_id'],
            'reference_no_id' => $data['reference_no_id'],
            'customer_user_id' => Auth::user()->id,
            'from' => $data['from'],
            'to' => $data['to'],
            'weight' => $data['weight'],
            'pickup_carrier_name' => $data['pickup_carrier_name'],
            'profit' => $data['profit'],
            'pickup_charge' => $data['pickup_charge'],
            'bonded_charge' => $data['bonded_charge'],
            'cargo_type' => $data['cargo_type'],
            'status' => $data['quotation_status'],
        ]);

        $quotation->save();

        $quotationLineItems = [];

        foreach ($data['carriers'] as $carrierData) {
            $quotationLineItem = new QuotationLineItem([
                'carrier_id' => $carrierData['carrier_id'],
                'tariff_rate' => $carrierData['tariff_rate'],
                'surcharge' => $carrierData['surcharge'],
                'airable_charge' => $carrierData['airable_charge'],
                'custom_charge' => $carrierData['custom_charge'],
                'rate_per_kg' => $carrierData['rate_per_kg'],
                'zero_profit_rate' => $carrierData['zero_profit_rate'],
                'total_rate' => $carrierData['total_rate'],
                'status' => $carrierData['quotation_line_items_status'],
            ]);
            $quotation->quotationLineItems()->save($quotationLineItem);
                
            $quotationLineItems[] = $quotationLineItem;
        }
            $quotation->quotation_line_items = $quotationLineItems;

            ProcessQuotation::dispatch($quotation->toArray());

        return $quotation;
    }

    public function updateStatus($quotationId, $lineItemId, $status)
    {
        $quotation = Quotation::findOrFail($quotationId);
        $lineItem = QuotationLineItem::findOrFail($lineItemId);

        switch ($status) {
            case 1:
                $quotation->status = $status;
                $lineItem->status = $status;
                break;
            case 2:
                $quotation->status = $status;
                $lineItem->status = $status;
                break;
        }

        $quotation->save();
        $lineItem->save();

        return $quotation;
    }

    public function sendQuoteEmail($inquiry)
    {
        // Generate PDF content
        $pdfContent = $this->generatePdf('mail.quote-mail', compact('inquiry'));

        return $pdfContent;
    }

    protected function generatePdf($view, $data)
    {
      // Render the Blade view to HTML
      $html = view($view, $data)->render();

      $dompdf = new Dompdf();
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      return $dompdf->output();
    }
}