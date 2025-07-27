<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_the_products_index_page()
    {
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertSee('Produtos');
    }

    #[Test]
    public function it_can_store_a_product_with_variations_and_stock()
    {
        $payload = [
            'name' => 'Camiseta Teste',
            'price' => 59.90,
            'variations' => ['P', 'M', 'G'],
            'quantities' => [3, 5, 2],
        ];

        $response = $this->post(route('products.store'), $payload);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Camiseta Teste',
            'price' => 59.90,
        ]);

        $product = Product::where('name', 'Camiseta Teste')->first();
        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'variation' => 'P',
            'quantity' => 3,
        ]);
        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'variation' => 'M',
            'quantity' => 5,
        ]);
        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'variation' => 'G',
            'quantity' => 2,
        ]);
    }

    #[Test]
    public function it_can_update_a_product_and_its_stock()
    {
        $product = Product::factory()->create([
            'name' => 'Origem',
            'price' => 100.00,
        ]);
        Stock::factory()->create([
            'product_id' => $product->id,
            'variation' => 'U',
            'quantity' => 1,
        ]);

        $payload = [
            'name' => 'Alterado',
            'price' => 120.50,
            'variations' => ['U', 'G'],
            'quantities' => [2, 4],
        ];

        $response = $this->put(route('products.update', $product->id), $payload);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Alterado',
            'price' => 120.50,
        ]);
        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'variation' => 'G',
            'quantity' => 4,
        ]);
    }

    #[Test]
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();
        $response = $this->delete(route('products.destroy', $product->id));
        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
