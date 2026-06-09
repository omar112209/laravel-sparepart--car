<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class BackendCRUDTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'status' => 1,
            'role' => '1',
        ]);
        $this->actingAs($this->admin, 'admin');
        $this->actingAs($this->admin);
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->get(route('backend.beranda'));
        $response->assertStatus(200);
    }

    public function test_admin_can_view_users_page(): void
    {
        $response = $this->get(route('backend.user.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_view_categories_page(): void
    {
        $response = $this->get(route('backend.kategori.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_category(): void
    {
        $response = $this->post(route('backend.kategori.store'), [
            'nama_kategori' => 'Test Kategori',
        ]);

        $response->assertRedirect(route('backend.kategori.index'));
        $this->assertDatabaseHas('kategori', ['nama_kategori' => 'Test Kategori']);
    }

    public function test_admin_can_update_category(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Kategori Lama']);

        $response = $this->put(route('backend.kategori.update', $kategori->id), [
            'nama_kategori' => 'Kategori Baru',
        ]);

        $response->assertRedirect(route('backend.kategori.index'));
        $this->assertDatabaseHas('kategori', ['nama_kategori' => 'Kategori Baru']);
        $this->assertDatabaseMissing('kategori', ['nama_kategori' => 'Kategori Lama']);
    }

    public function test_admin_can_delete_category(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Kategori Hapus']);

        $response = $this->delete(route('backend.kategori.destroy', $kategori->id));

        $response->assertRedirect(route('backend.kategori.index'));
        $this->assertDatabaseMissing('kategori', ['id' => $kategori->id]);
    }

    public function test_admin_can_view_products_page(): void
    {
        $response = $this->get(route('backend.produk.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_view_customers_page(): void
    {
        $response = $this->get(route('backend.customer.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_access_orders_pages(): void
    {

        $response = $this->get(route('pesanan.proses'));
        $response->assertStatus(200);

        $response = $this->get(route('pesanan.selesai'));
        $response->assertStatus(200);
    }
}
