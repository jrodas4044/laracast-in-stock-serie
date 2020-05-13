<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_tracks_product_stock()
    {
        // Given
        // I have a product with stock
        $switch = Product::create(['name' => 'Nitendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price' => 1000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => false
        ]);

        $bestBuy->addStock($switch, $stock);

        $this->assertFalse($stock->fresh()->in_stock);

        // When
        // I trigger the php artisan track command
        \Http::fake(function () {
            return [
                'available' => true,
                'price' => 29000
            ];
        });
        $this->artisan('track');

        // Then
        // The stock details should be refreshed
        $this->assertTrue($stock->fresh()->in_stock);
    }
}
