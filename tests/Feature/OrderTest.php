<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TechChallenge\Infra\DB\Eloquent\Order\Model as Order;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para exibir os detalhes de um pedido específico.
     */
    public function test_show_order_by_id()
    {
        // Arrange: Cria um pedido no banco de dados
        $order = Order::factory()->create([
            'id' => 1,
            'status' => 'pending',
            'total' => 150.00,
        ]);

        // Act: Faz a requisição GET para o endpoint /order/{id}
        $response = $this->getJson('/order/' . $order->id);

        // Assert: Verifica o status da resposta e o conteúdo
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $order->id,
                     'status' => 'pending',
                     'total' => 150.00,
                 ]);
    }

    /**
     * Teste para criar um novo pedido.
     */
    public function test_create_order()
    {
        // Arrange: Payload do novo pedido
        $payload = [
            'customer_id' => 1,
            'items' => [
                ['product_id' => 1, 'quantity' => 2],
                ['product_id' => 2, 'quantity' => 1],
            ],
            'total' => 200.00,
        ];

        // Act: Faz a requisição POST para o endpoint /order
        $response = $this->postJson('/order', $payload);

        // Assert: Verifica o status da resposta e o conteúdo
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Order created successfully.',
                     'order' => [
                         'customer_id' => 1,
                         'total' => 200.00,
                     ],
                 ]);
    }

    /**
     * Teste para atualizar um pedido existente.
     */
    public function test_update_order()
    {
        // Arrange: Cria um pedido no banco de dados
        $order = Order::factory()->create([
            'id' => 1,
            'total' => 150.00,
        ]);

        // Payload para atualização
        $payload = [
            'total' => 200.00,
        ];

        // Act: Faz a requisição PUT para o endpoint /order/{id}
        $response = $this->putJson('/order/' . $order->id, $payload);

        // Assert: Verifica o status da resposta
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Order updated successfully.',
                     'order' => [
                         'id' => $order->id,
                         'total' => 200.00,
                     ],
                 ]);
    }

    /**
     * Teste para deletar um pedido.
     */
    public function test_delete_order()
    {
        // Arrange: Cria um pedido no banco de dados
        $order = Order::factory()->create();

        // Act: Faz a requisição DELETE para o endpoint /order/{id}
        $response = $this->deleteJson('/order/' . $order->id);

        // Assert: Verifica o status da resposta
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Order deleted successfully.',
                 ]);
    }

    /**
     * Teste para realizar o checkout de um pedido.
     */
    public function test_checkout_order()
    {
        // Arrange: Cria um pedido no banco de dados
        $order = Order::factory()->create([
            'status' => 'pending',
        ]);

        // Act: Faz a requisição POST para o endpoint /order/checkout/{id}
        $response = $this->postJson('/order/checkout/' . $order->id);

        // Assert: Verifica o status da resposta
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Checkout completed successfully.',
                     'order' => [
                         'id' => $order->id,
                         'status' => 'completed',
                     ],
                 ]);
    }

    /**
     * Teste para alterar o status de um pedido.
     */
    public function test_change_order_status()
    {
        // Arrange: Cria um pedido no banco de dados
        $order = Order::factory()->create([
            'status' => 'pending',
        ]);

        // Act: Faz a requisição POST para o endpoint /order/status/{id}
        $response = $this->postJson('/order/status/' . $order->id, [
            'status' => 'shipped',
        ]);

        // Assert: Verifica o status da resposta
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Order status updated successfully.',
                     'order' => [
                         'id' => $order->id,
                         'status' => 'shipped',
                     ],
                 ]);
    }

    /**
     * Teste para o endpoint de webhook.
     */
    public function test_webhook_endpoint()
    {
        // Arrange: Payload enviado pelo webhook
        $payload = [
            'event' => 'order_updated',
            'order_id' => 1,
            'status' => 'shipped',
        ];

        // Act: Faz a requisição POST para o endpoint /order/webhook
        $response = $this->postJson('/order/webhook', $payload);

        // Assert: Verifica o status da resposta
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Webhook processed successfully.',
                 ]);
    }
}
