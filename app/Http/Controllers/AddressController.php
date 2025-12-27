<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve addresses associated with the user
        $addresses = Addresses::where('customer_user_id', $user->id)->get();

        return view('addresses.index', compact('addresses'));
    }

    public function show($id)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        $addresses = Addresses::where('customer_user_id', $user->id)
                        ->where('id', $id)
                        ->first();

        return view('addresses.show', compact('addresses'));
    }

    public function create()
    {
        $countries = Country::all();
        $address = new Addresses();

        return view('addresses.create', compact('countries', 'address'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate the request data (you can customize validation rules based on your requirements)
        $request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
            'contact_name' => 'required',
        ]);

        // Create a new address record
        $newAddress = Addresses::create([
            'country_id' => $request->input('country_id'),
            'state_id' => $request->input('state_id'),
            'city_id' => $request->input('city_id'),
            'postal_code' => $request->input('postal_code'),
            'address' => $request->input('address'),
            'contact_name' => $request->input('contact_name'),
            'contact_email' => $request->input('contact_email'),
            'phone_number' => $request->input('phone_number'),
            'customer_user_id' => $user->id,
        ]);
        $address = Addresses::find($newAddress->id);

        // You can return any response based on your needs (e.g., JSON response)
        return response()->json(['message' => 'Address saved successfully', 'address' => $address]);
    }

    public function edit($id)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the address for the given user and id
        $address = Addresses::where('customer_user_id', $user->id)
                        ->where('id', $id)
                        ->first();
        $countries = Country::all();

            return view('addresses.edit', compact('address', 'countries'));

    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Validate the request data (you can customize validation rules based on your requirements)
        $request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
            'contact_name' => 'required',
        ]);

        // Retrieve the address for the given user and id
        $addresses = Addresses::where('customer_user_id', $user->id)
                        ->where('id', $id)
                        ->first();

            // Update the address record
            $addresses->update([
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'city_id' => $request->input('city_id'),
                'postal_code' => $request->input('postal_code'),
                'address' => $request->input('address'),
                'contact_name' => $request->input('contact_name'),
                'contact_email' => $request->input('contact_email'),
                'phone_number' => $request->input('phone_number'),
            ]);


            return response()->json(['message' => 'Address updated successfully']);
    }

    public function destroy($id)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the address for the given user and id
        $address = Addresses::where('customer_user_id', $user->id)
                        ->where('id', $id)
                        ->first();

        // Check if the address was found
        if ($address) {
            // Delete the address record
            $address->delete();

            return response()->json(['message' => 'Address deleted successfully']);
        } else {
            // Handle the case where no address is found
        return response()->json(['error' => 'Address not found'], 404);
        }
    }

    public function getNames(Request $request)
    {
        $country = Country::find($request->input('country_id'));
        $state = State::find($request->input('state_id'));
        $city = City::find($request->input('city_id'));

        return response()->json([
            'country' => $country->name ?? '',
            'state'   => $state->name ?? '',
            'city'    => $city->name ?? '',
        ]);
    }
}
