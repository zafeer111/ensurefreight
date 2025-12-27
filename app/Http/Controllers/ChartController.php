<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function getChart(Request $request)
    {
        // Retrieve data based on the selected month and the authenticated user's ID
        $inquiries = Inquiry::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                            ->where('customer_user_id', auth()->user()->id)
                            ->groupBy('month')
                            ->get();

        return response()->json($inquiries);
    }
}