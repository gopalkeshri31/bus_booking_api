<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Seat;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate incoming request data (e.g., user_id, bus_id, seat_number, etc.)
        // $validatedData = $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'bus_id' => 'required|exists:buses,id',
        //     'seat_number' => 'required',
        //     // Add more validation rules as needed
        // ]);

        // Check if the seat is available for booking (you'll need to implement this logic)
        $isSeatAvailable = $this->checkSeatAvailability($request->bus_id, $request->seat_number);

        if (!$isSeatAvailable) {
            return response()->json(['message' => 'Seat is already booked'], 400);
        }

        // Create a booking
        $booking = Booking::create([
            'user_id' => $request->user_id,
            'bus_id' => $request->bus_id,
            'seat_number' => $request->seat_number,
            'booking_date' => now(),
            // Add more fields as needed
        ]);

        // Update seat status to 'booked'
        $this->updateSeatStatus($request->bus_id, $request->seat_number);

        return response()->json(['message' => 'Booking created successfully', 'booking' => $booking], 201);
    }

    public function index(Request $request)
    {
        // Retrieve bookings for a specific user
        $userId = $request->user()->id; // Assuming you're using authentication middleware
        $bookings = Booking::where('user_id', $userId)->get();

        return response()->json(['bookings' => $bookings], 200);
    }

    public function destroy($id)
    {
        // Find the booking
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Cancel the booking and update seat status to 'available'
        $this->cancelBooking($booking->bus_id, $booking->seat_number);

        $booking->delete();

        return response()->json(['message' => 'Booking canceled successfully'], 200);
    }

    // Additional methods for seat availability check, seat status update, etc.

    private function checkSeatAvailability($busId, $seatNumber)
    {
        // Retrieve the seat for the specified bus and seat number
        $seat = Seat::where('bus_id', $busId)
            ->where('seat_number', $seatNumber)
            ->first();

        if (!$seat) {
            // Seat doesn't exist for the given bus
            return false;
        }

        // Check if the seat is already booked
        if ($seat->is_booked) {
            // Seat is already booked
            return false;
        }

        // Seat is available for booking
        return true;
        // Implement logic to check if the seat is available for booking
        // This might involve checking the 'seats' table for the bus
        // and verifying if the seat number is not already booked
        // Return true if available, false otherwise
    }

    private function updateSeatStatus($busId, $seatNumber)
    {
        // Retrieve the seat for the specified bus and seat number
        $seat = Seat::where('bus_id', $busId)
            ->where('seat_number', $seatNumber)
            ->first();

        if ($seat) {
            // Update the seat status to 'booked'
            $seat->update(['is_booked' => true]);
        }
        // Optionally, you can handle cases where the seat doesn't exist
        // or take additional actions based on your application logic
        // Implement logic to update the seat status to 'booked'
        // Set the 'is_booked' field to true for the specified seat on the bus
    }

    private function cancelBooking($busId, $seatNumber)
    {
        // Retrieve the seat for the specified bus and seat number
        $seat = Seat::where('bus_id', $busId)
            ->where('seat_number', $seatNumber)
            ->first();

        if ($seat) {
        // Update the seat status to 'available' when a booking is canceled
            $seat->update(['is_booked' => false]);
        }
        // Optionally, handle cases where the seat doesn't exist
        // or take additional actions based on your application logic
        // Implement logic to cancel a booking
        // Update the seat status to 'available' when a booking is canceled
    }
}
