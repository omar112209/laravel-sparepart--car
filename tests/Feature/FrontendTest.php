<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_redirects_to_beranda(): void
    {
        $response = $this->get('/');
        $response->assertRedirect(route('beranda'));
    }

    public function test_beranda_page_returns_200(): void
    {
        $response = $this->get(route('beranda'));
        $response->assertStatus(200);
    }

    public function test_all_products_page_returns_200(): void
    {
        $response = $this->get(route('produk.all'));
        $response->assertStatus(200);
    }

    public function test_product_detail_displays_product(): void
    {
        $user = User::factory()->create();
        $kategori = Kategori::create(['nama_kategori' => 'Test']);
        $produk = Produk::create([
            'kategori_id' => $kategori->id,
            'user_id' => $user->id,
            'nama_produk' => 'Produk Test',
            'detail' => 'Detail produk',
            'harga' => 50000,
            'berat' => 1,
            'stok' => 10,
            'status' => 1,
            'foto' => 'default.jpg',
        ]);

        $response = $this->get(route('produk.detail', $produk->id));
        $response->assertStatus(200);
        $response->assertSee('Produk Test');
    }

    public function test_product_detail_with_invalid_id_returns_404(): void
    {
        $response = $this->get(route('produk.detail', 99999));
        $response->assertStatus(404);
    }

    public function test_product_by_category_displays_products(): void
    {
        $user = User::factory()->create();
        $kategori = Kategori::create(['nama_kategori' => 'Mesin']);
        $produk = Produk::create([
            'kategori_id' => $kategori->id,
            'user_id' => $user->id,
            'nama_produk' => 'Produk Mesin',
            'detail' => 'Detail',
            'harga' => 100000,
            'berat' => 2,
            'stok' => 5,
            'status' => 1,
            'foto' => 'default.jpg',
        ]);

        $response = $this->get(route('produk.kategori', $kategori->id));
        $response->assertStatus(200);
    }

    public function test_product_by_category_with_invalid_id_returns_200_empty(): void
    {
        $response = $this->get(route('produk.kategori', 99999));
        $response->assertStatus(200);
    }
}
