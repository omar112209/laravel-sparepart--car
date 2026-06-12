<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RajaOngkirController extends Controller
{
    // ================= PROVINSI =================
    public function getProvinces()
    {
        $data = Cache::remember('provinces', 60 * 60 * 24, function () {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.api_key')
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');
            return $response->json();
        });

        return response()->json($data);
    }

    // ================= KOTA =================
    public function getCities(Request $request)
    {
        $provinceId = $request->input('province_id');

        $data = Cache::remember('cities_' . $provinceId, 60 * 60 * 24, function () use ($provinceId) {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.api_key')
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/city/' . $provinceId);
            return $response->json();
        });

        return response()->json($data);
    }

    // ================= KECAMATAN =================
    public function getDistricts($cityId)
    {
        Cache::forget('districts_' . $cityId);
        $data = Cache::remember('districts_' . $cityId, 60 * 60 * 24, function () use ($cityId) {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.api_key')
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/district/' . $cityId);
            return $response->json();
        });

        return response()->json($data);
    }

    // ================= CEK ONGKIR =================
    public function getCost(Request $request)
    {
        $response = Http::asForm() // ← WAJIB asForm() untuk Komerce
            ->withHeaders([
                'Accept' => 'application/json',
                'key'    => config('services.rajaongkir.api_key'),
            ])
            ->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin'      => $request->input('origin'),
                'destination' => $request->input('destination'), // ← ID kecamatan
                'weight'      => $request->input('weight'),
                'courier'     => $request->input('courier'),
            ]);

        return response()->json($response->json());
    }
}
