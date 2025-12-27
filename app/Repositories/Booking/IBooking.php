<?php

namespace App\Repositories\Booking;

interface IBooking
{
    public function getUserBookings($userId);
    public function findUserBooking($userId, $bookingId);
    public function createBooking($data);
}