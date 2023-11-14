<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(Tests\TestCase::class, RefreshDatabase::class);

it('does not create a product without validated fields', function () {
    $response = $this->postJson('/api/products', []);
    $response->assertStatus(422)
        ->assertJson([
            "success" => false,
            "code" => 422
        ]);
});

it('can create a Product', function () {
    $attributes = Product::factory()->raw();
    $response = $this->postJson('/api/products', $attributes);
    $response->assertStatus(201)
        ->assertJson([
            "success" => true,
            "code" => 200
        ]);

    $this->assertDatabaseHas('products', $attributes);
});

it('can fetch a product', function () {
    $product = Product::factory()->create();

    $response = $this->getJson("/api/products/{$product->id}");

    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'code' => 200,
    ]);
});


it('can update a product', function () {
    $product = Product::factory()->create();
    $updatedProduct = [
        'name' => 'Updated name',
        'description' => 'Updated description',
        'price' => 34.00,
    ];
    $response = $this->putJson("/api/products/{$product->id}", $updatedProduct);
    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'code' => 200,
        ]);
    $this->assertDatabaseHas('products', $updatedProduct);
});


it('cannot fetch a product', function () {
    $response = $this->getJson("/api/products/10");
    $response->assertStatus(404)
        ->assertJson([
            "message" => "Record not found.",
            "success" => false
        ]);

    $this->assertDatabaseMissing('products', ['id' => 10]);
});

it('can delete a product', function () {
    $product = Product::factory()->create();
    $response = $this->deleteJson("/api/products/{$product->id}");
    $response->assertStatus(200)->assertJson([
        'success' => true,
        'code' => 200,
    ]);;
    $this->assertCount(0, $product::all());
});


