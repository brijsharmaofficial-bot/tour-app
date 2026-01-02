<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Get user profile
    public function show($id)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return response()->json([
                    "status" => "error",
                    "message" => "User not found"
                ], 404);
            }

            // Calculate additional fields without storing them
            $totalBookings = $user->bookings()->count();
            $completedBookings = $user->bookings()->where('status', 'completed')->count();
            $upcomingBookings = $user->bookings()->whereIn('status', ['pending', 'confirmed', 'assigned'])->count();
            
            // Calculate total spent
            $totalSpent = $user->bookings()
                ->where('payment_status', 'paid')
                ->sum('total_estimated_fare');

            // Return user data
            return response()->json([
                "status" => "success",
                "user" => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'status' => $user->status,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    
                    // Calculated fields (not in database)
                    'total_bookings' => $totalBookings,
                    'completed_bookings' => $completedBookings,
                    'upcoming_bookings' => $upcomingBookings,
                    'total_spent' => (float) $totalSpent,
                    'member_since' => $user->created_at->format('M Y'),
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching user: ' . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to fetch user details"
            ], 500);
        }
    }

    // Update user profile
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return response()->json([
                    "status" => "error",
                    "message" => "User not found"
                ], 404);
            }

            // Validate request - only allow fields that exist in your table
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'phone' => 'sometimes|string|max:20',
                'current_password' => 'sometimes|required_with:new_password',
                'new_password' => 'sometimes|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Validation failed",
                    "errors" => $validator->errors()
                ], 422);
            }

            // Update only existing fields
            $updateData = [];
            
            if ($request->has('name')) {
                $updateData['name'] = $request->name;
            }
            
            if ($request->has('email')) {
                $updateData['email'] = $request->email;
            }
            
            if ($request->has('phone')) {
                $updateData['phone'] = $request->phone;
            }
            
            // Handle password change
            if ($request->has('current_password') && $request->has('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        "status" => "error",
                        "message" => "Current password is incorrect"
                    ], 400);
                }
                
                $updateData['password'] = Hash::make($request->new_password);
            }

            $user->update($updateData);

            return response()->json([
                "status" => "success",
                "message" => "Profile updated successfully",
                "user" => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to update profile"
            ], 500);
        }
    }

    // Get user bookings with calculated stats
    public function getUserBookings($userId)
    {
        try {
            $user = User::find($userId);
            
            if (!$user) {
                return response()->json([
                    "status" => "error",
                    "message" => "User not found"
                ], 404);
            }

            // Get bookings with relationships
            $bookings = Booking::with([
                'cab:id,cab_name,cab_type,image,capacity,registration_no',
                'fromCity:id,name,state',
                'toCity:id,name,state',
                'package:id,hours,kms,price_per_km,extra_price_per_km,da,toll_tax,gst,airport_min_km',
                'vendor:id,name,phone'
            ])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

            // Calculate stats without storing them
            $totalBookings = $bookings->count();
            $completedBookings = $bookings->where('status', 'completed')->count();
            $upcomingBookings = $bookings->whereIn('status', ['pending', 'confirmed', 'assigned'])->count();
            $cancelledBookings = $bookings->where('status', 'cancelled')->count();
            $totalPaid = $bookings->sum(function($booking) {
                if ($booking->payment_status === 'paid') {
                    return $booking->total_estimated_fare;
                } elseif ($booking->payment_status === 'partial') {
                    return $booking->advanced_amount ?? 0;
                }
                return 0;
            });
            
            $totalRemaining = $bookings->sum(function($booking) {
                if ($booking->payment_status === 'paid') {
                    return 0;
                } elseif ($booking->payment_status === 'partial') {
                    return $booking->total_estimated_fare - ($booking->advanced_amount ?? 0);
                }
                return $booking->total_estimated_fare;
            });

            return response()->json([
                "status" => "success",
                "bookings" => $bookings,
                "stats" => [
                    "total_bookings" => $totalBookings,
                    "completed_bookings" => $completedBookings,
                    "upcoming_bookings" => $upcomingBookings,
                    "cancelledBookings"  => $cancelledBookings,
                    "total_paid" => $totalPaid,
                    "total_remaining" => $totalRemaining
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching user bookings: ' . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to fetch bookings"
            ], 500);
        }
    }

    // Get current authenticated user
    public function getCurrentUser(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    "status" => "error",
                    "message" => "User not authenticated"
                ], 401);
            }

            // Calculate stats on the fly
            $totalBookings = $user->bookings()->count();
            $completedBookings = $user->bookings()->where('status', 'completed')->count();
            $totalSpent = $user->bookings()->where('payment_status', 'paid')->sum('total_estimated_fare');

            return response()->json([
                "status" => "success",
                "user" => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'status' => $user->status,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    
                    // Calculated fields
                    'total_bookings' => $totalBookings,
                    'completed_bookings' => $completedBookings,
                    'total_spent' => (float) $totalSpent,
                    'member_since' => $user->created_at->format('M Y'),
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error getting current user: ' . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to get user information"
            ], 500);
        }
    }
}