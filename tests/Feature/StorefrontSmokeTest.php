<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_storefront_pages_render(): void
    {
        $this->seed();

        foreach ([
            '/',
            '/about',
            '/shop',
            '/shop/sarasota-snook-jig',
            '/gallery',
            '/pricing',
            '/testimonials',
            '/blog',
            '/blog/choosing-the-right-jig-for-saltwater-fishing',
            '/contact',
            '/cart',
            '/login',
            '/register',
            '/privacy-policy',
            '/terms-and-conditions',
            '/return-policy',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }

        $this->get('/checkout')->assertRedirect('/cart');
    }

    public function test_session_cart_adds_updates_and_removes_items(): void
    {
        $this->seed();
        $product = Product::where('slug', 'sarasota-snook-jig')->firstOrFail();

        $this->post('/cart/add/'.$product->id, ['quantity' => 2])
            ->assertRedirect()
            ->assertSessionHas('cart.'.$product->id, 2);

        $this->post('/cart/update', ['product_id' => $product->id, 'quantity' => 3])
            ->assertRedirect()
            ->assertSessionHas('cart.'.$product->id, 3);

        $this->post('/cart/remove/'.$product->id)
            ->assertRedirect()
            ->assertSessionMissing('cart.'.$product->id);
    }

    public function test_contact_form_stores_messages(): void
    {
        $this->seed();

        $this->post('/contact', [
            'name' => 'Taylor Fisher',
            'email' => 'taylor@example.com',
            'phone' => '941-555-0100',
            'subject' => 'Custom jig colors',
            'message' => 'I would like help choosing colors for Sarasota snook fishing.',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas(ContactMessage::class, [
            'email' => 'taylor@example.com',
            'subject' => 'Custom jig colors',
        ]);
    }

    public function test_checkout_creates_order_payment_items_and_clears_cart(): void
    {
        $this->seed();
        $product = Product::where('slug', 'sarasota-snook-jig')->firstOrFail();

        $this->withSession(['cart' => [$product->id => 2]])
            ->post('/checkout/place-order', [
                'name' => 'Taylor Fisher',
                'email' => 'taylor@example.com',
                'phone' => '941-555-0100',
                'address' => '123 Marina Way',
                'city' => 'Sarasota',
                'state' => 'FL',
                'zip' => '34236',
                'payment_method' => 'manual_payment',
                'notes' => 'Please confirm color availability.',
            ])
            ->assertRedirect()
            ->assertSessionMissing('cart');

        $order = Order::with(['items', 'payment'])->firstOrFail();

        $this->assertSame('Taylor Fisher', $order->customer_name);
        $this->assertSame('pending', $order->payment_status);
        $this->assertCount(1, $order->items);
        $this->assertNotNull($order->payment);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => $product->stock - 2,
        ]);
    }
}
