<?php

namespace App\Repositories\Booking;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingRepository implements IBooking
{
    public function getUserBookings($userId)
    {
        return Booking::where('customer_user_id', $userId)->get();
    }

    public function findUserBooking($userId, $bookingId)
    {
        return Booking::where('customer_user_id', $userId)->findOrFail($bookingId);
    }

    public function createBooking($data)
    {
        try {
            $booking = new Booking([
                'quotation_id' => $data['quotation_id'],
                'customer_user_id' => Auth::user()->id,
                'reference_no_id' => $data['reference_no_id'],
                'carrier_id' => $data['carrier_id'],
                'status' => $data['status'],
                'tariff_rate' => $data['tariff_rate'],
                'surcharge' => $data['surcharge'],
                'airable_charge' => $data['airable_charge'],
                'custom_charge' => $data['custom_charge'],
                'rate_per_kg' => $data['rate_per_kg'],
                'total_rate' => $data['total_rate'],
            ]);

            $booking->save();

            return $booking;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
