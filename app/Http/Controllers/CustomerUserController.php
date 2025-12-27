<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerUserRequest;
use App\Models\Country;
use App\Models\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class CustomerUserController extends Controller
{
    public function index(){
        return view('customer-login');
    }

    public function setting(){
        $countries = Country::all();

        return view('settings.setting', compact('countries'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            CustomerUser::where('id', auth()->user()->id)->update(['user_img' => 'uploads/' . $imageName]);

            return response()->json(['status' => 'success', 'message' => 'Image uploaded successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'No image provided.'], 400);
    }

    public function updateProfile(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required|numeric',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id',
            'postal_code' => 'required|string',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Update user profile using the CustomerUser model
        CustomerUser::where('id', $user->id)->update([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'country_id' => $request->input('country_id'),
            'city_id' => $request->input('city_id'),
            'state_id' => $request->input('state_id'),
            'postal_code' => $request->input('postal_code'),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Profile updated successfully']);
    }
    
    public function resetPassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Check if the provided current password matches the user's current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Current password is incorrect']);
        }

        // Update user password
        CustomerUser::where('id', $user->id)->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Password reset successfully']);
    }

    public function login(CustomerUserRequest $request){
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('customer.dashboard');
        } else {
            return redirect('customer-login')->withErrors(['error' => 'Invalid login credentials']);
        }
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('customer-login');
    }

}
