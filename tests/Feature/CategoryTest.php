<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TechChallenge\Infra\DB\Eloquent\Category\Model as Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para listar todas as categorias.
     */
    public function test_list_all_categories()
    {
        // Arrange: Cria 3 categorias no banco de dados
        $categories = Category::factory()->count(3)->create();

        // Act: Faz a requisição GET para o endpoint /category
        $response = $this->getJson('/category');

        // Assert: Verifica o status da resposta e o conteúdo
        $response->assertStatus(200)
                 ->assertJsonCount(3) // Deve conter 3 categorias
                 ->assertJsonFragment([
                     'id' => $categories[0]->id,
                     'name' => $categories[0]->name,
                 ]);
    }

    /**
     * Teste para exibir os detalhes de uma categoria específica.
     */
    public function test_show_category_by_id()
    {
        // Arrange: Cria uma categoria no banco de dados
        $category = Category::factory()->create([
            'id' => 1,
            'name' => 'Electronics',
        ]);

        // Act: Faz a requisição GET para o endpoint /category/{id}
        $response = $this->getJson('/category/' . $category->id);

        // Assert: Verifica o status da resposta e o conteúdo
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $category->id,
                     'name' => 'Electronics',
                 ]);
    }

    /**
     * Teste para exibir uma categoria inexistente.
     */
    public function test_show_category_not_found()
    {
        // Act: Faz a requisição GET para uma categoria inexistente
        $response = $this->getJson('/category/999');

        // Assert: Verifica se retorna erro 404
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Category not found.', // Certifique-se de que a mensagem corresponda à do controller
                 ]);
    }
}
