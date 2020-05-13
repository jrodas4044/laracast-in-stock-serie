<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stock_for_products_at_retailers()
    {
        $switch = Product::create(['name' => 'Nitendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price' => 1000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => true
        ]);

        $bestBuy->addStock($switch, $stock);

        $this->assertTrue($switch->inStock());
    }
}
