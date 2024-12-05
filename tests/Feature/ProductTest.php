<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TechChallenge\Infra\DB\Eloquent\Product\Model as Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para listar todos os produtos.
     */
    public function test_list_all_products()
    {
        // Arrange: Cria produtos no banco de dados
        $products = Product::factory()->count(3)->create();

        // Act: Faz a requisição GET para o endpoint /product
        $response = $this->getJson('/product');

        // Assert: Verifica o status da resposta e o conteúdo
        $response->assertStatus(200)
                 ->assertJsonCount(3) // Deve conter 3 produtos
                 ->assertJsonFragment([
                     'id' => $products[0]->id,
                     'name' => $products[0]->name,
                     'price' => $products[0]->price,
                 ]);
    }

    /**
     * Teste para exibir detalhes de um produto específico.
     */
    public function test_show_product_by_id()
    {
        // Arrange: Cria um produto no banco de dados
        $product = Product::factory()->create([
            'id' => 1,
            'name' => 'Product 1',
            'price' => 100.50,
        ]);

        // Act: Faz a requisição GET para o endpoint /product/{id}
        $response = $this->getJson('/product/' . $product->id);

        // Assert: Verifica o status da resposta e o conteúdo
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $product->id,
                     'name' => 'Product 1',
                     'price' => 100.50,
                 ]);
    }

    /**
     * Teste para exibir um produto inexistente.
     */
    public function test_show_product_not_found()
    {
        // Act: Faz a requisição GET para um ID inexistente
        $response = $this->getJson('/product/999');

        // Assert: Verifica se retorna erro 404
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Product not found.', // Certifique-se de que a mensagem corresponda ao controller
                 ]);
    }
}
