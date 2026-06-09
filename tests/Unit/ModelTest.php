<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\User;
use App\Models\FotoProduk;
use ReflectionClass;

class ModelTest extends TestCase
{
    public function test_produk_model_has_belongs_to_kategori_relation(): void
    {
        $model = new Produk();
        $reflection = new ReflectionClass($model);

        $this->assertTrue($reflection->hasMethod('kategori'));
        $this->assertTrue($reflection->hasMethod('user'));
        $this->assertTrue($reflection->hasMethod('fotoProduk'));
    }

    public function test_produk_model_uses_correct_table(): void
    {
        $model = new Produk();
        $this->assertEquals('produk', $model->getTable());
    }

    public function test_kategori_model_uses_correct_table(): void
    {
        $model = new Kategori();
        $this->assertEquals('kategori', $model->getTable());
    }

    public function test_kategori_model_has_no_timestamps(): void
    {
        $model = new Kategori();
        $this->assertFalse($model->timestamps);
    }

    public function test_order_model_has_relations(): void
    {
        $model = new Order();
        $reflection = new ReflectionClass($model);

        $this->assertTrue($reflection->hasMethod('orderItems'));
        $this->assertTrue($reflection->hasMethod('customer'));
    }

    public function test_order_model_uses_correct_table(): void
    {
        $model = new Order();
        $this->assertEquals('order', $model->getTable());
    }

    public function test_order_item_model_has_relations(): void
    {
        $model = new OrderItem();
        $reflection = new ReflectionClass($model);

        $this->assertTrue($reflection->hasMethod('order'));
        $this->assertTrue($reflection->hasMethod('produk'));
        $this->assertTrue($reflection->hasMethod('kategori'));
    }

    public function test_order_item_model_uses_correct_table(): void
    {
        $model = new OrderItem();
        $this->assertEquals('order_item', $model->getTable());
    }

    public function test_customer_model_uses_correct_table(): void
    {
        $model = new Customer();
        $this->assertEquals('customer', $model->getTable());
    }

    public function test_customer_model_has_relation(): void
    {
        $model = new Customer();
        $reflection = new ReflectionClass($model);

        $this->assertTrue($reflection->hasMethod('user'));
    }

    public function test_user_model_uses_correct_table(): void
    {
        $model = new User();
        $this->assertEquals('user', $model->getTable());
    }

    public function test_foto_produk_model_exists(): void
    {
        $this->assertTrue(class_exists(FotoProduk::class));
    }
}
