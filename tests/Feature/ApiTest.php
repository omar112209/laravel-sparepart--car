<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ApiTest extends TestCase
{
    public function test_provinces_endpoint_returns_json(): void
    {
        Http::fake([
            'rajaongkir.komerce.id/*' => Http::response([
                'success' => true,
                'data' => [['id' => 1, 'name' => 'Jawa Barat']]
            ], 200),
        ]);

        $response = $this->get('/provinces');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_cities_endpoint_returns_json(): void
    {
        Http::fake([
            'rajaongkir.komerce.id/*' => Http::response([
                'success' => true,
                'data' => [['id' => 1, 'name' => 'Bandung']]
            ], 200),
        ]);

        $response = $this->get('/cities?province_id=1');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_districts_endpoint_returns_json(): void
    {
        Http::fake([
            'rajaongkir.komerce.id/*' => Http::response([
                'success' => true,
                'data' => [['id' => 1, 'name' => 'Cimahi']]
            ], 200),
        ]);

        $response = $this->get('/districts/1');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
}
