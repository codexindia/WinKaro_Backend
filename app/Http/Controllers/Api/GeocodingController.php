<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller; // Add this line

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GeocodingController extends Controller
{
    public function geocode(Request $request)
    {
        $latitude = $request->input('lat');
        $longitude = $request->input('lng');
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $response = Http::withOptions(['verify' => false])->get(
            "https://maps.googleapis.com/maps/api/geocode/json",
            [
                'latlng' => "{$latitude},{$longitude}",
                'key' => $apiKey
            ]
        );

        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {
            $address = $data['results'][0]['formatted_address'];
            $pincode = $this->extractPincode($data['results'][0]['address_components']);

            return response()->json([
                'address' => $address,
                'pincode' => $pincode,
                //'data' => $data
            ]);
        } else {
            return response()->json(['error' => $data], 400);
        }
    }

    private function extractPincode($addressComponents)
    {
        foreach ($addressComponents as $component) {
            if (in_array('postal_code', $component['types'])) {
                return $component['long_name'];
            }
        }
        return null; // Return null if no postal code is found
    }
    public function getPincode(Request $request)
    {
        $latitude = $request->input('lat');
        $longitude = $request->input('lng');
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $response = Http::withOptions(['verify' => false])->get(
            "https://maps.googleapis.com/maps/api/geocode/json",
            [
                'latlng' => "{$latitude},{$longitude}",
                'key' => $apiKey
            ]
        );

        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {

            $pincode = $this->extractPincode($data['results'][0]['address_components']);

            return $pincode;
        } else {
            return 0;
        }
    }
}
