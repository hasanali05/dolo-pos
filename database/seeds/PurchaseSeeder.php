<?php

use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only Supplier, Purchase, PurchaseDetail, PurchaseTransaction, Inventory
        echo "Purchase seeding .... \n";

        factory(App\Supplier::class,20)->create();
        factory(App\Purchase::class,20)->create();
        factory(App\PurchaseDetail::class,20)->create();
        factory(App\PurchaseTransaction::class,20)->create();
        factory(App\Inventory::class,20)->create();
        

        
        echo "Purchase seeded .... \n";
    }
}
