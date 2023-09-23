<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseMigrations;
    public function testOrdersIndexResponsesAuthenticationError(): void
    {
        $response = $this->getJson(route("api.orders_index"));
        $response->assertUnauthorized();
    }

    public function testOrdersIndexResponsesNotFoundError(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route("api.orders_index"));
        $response->assertNotFound();
    }

    public function testOrdersIndexResponsesSuccess(): void
    {
        Order::factory()->has(Product::factory())->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route("api.orders_index"));
        $response->assertOk();
    }

    public function testOrdersStoreResponsesAuthenticationError(): void
    {
        $response = $this->postJson(route("api.orders_store"));
        $response->assertUnauthorized();
    }

    public function testOrderStoreResponsesValidationError(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route("api.orders_store"), ["products" => [
            "pr",
            "pi"
        ]]);
        $response->assertUnprocessable();
    }

    public function testOrderStoreResponsesNotFoundWhenAnProductNotFounded(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route("api.orders_store"), ["products" => [
            "id" => "fakeId",
            "quantity" => "fakeQuantity"
        ]]);
        $response->assertUnprocessable();
    }

    public function testOrderStoreResponsesBadRequestWhenAProductInventoryGoesLessThanZero(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson(route("api.orders_store"), [
           "products" => [
               [
                   "id" => $product->id,
                   "quantity" => $product->inventory + 1
               ]
           ]
        ]);
        $response->assertBadRequest();
    }

    public function testOrderStoreResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson(route("api.orders_store"), [
            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => $product->inventory
                ]
            ]
        ]);
        $response->assertCreated();
    }

}
