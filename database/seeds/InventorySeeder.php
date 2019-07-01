<?php

use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only ProductCategory, Product
        echo "Inventory seeding .... \n";

        factory(App\ProductCategory::class,20)->create();
        factory(App\Product::class,20)->create();

        echo "Inventory seeded .... \n";
    }
}
