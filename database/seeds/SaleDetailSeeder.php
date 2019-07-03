<?php

use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only Customer, Sale, SaleDetail, SaleTransaction

        echo "Sale seeding .... \n";
        $sale =App\Sale::create([
            'customer_id' => 1,
            'sale_date'=>"01-07-19",
            'amount'=>"434",
            'commission'=>"50",
            'payment'=>"300",
            'due'=>"100",
        ]);
        echo "Sale seeded .... \n";

        echo "SaleDetail seeding .... \n";
        App\SaleDetail::create([
            'sale_id' =>$sale->id,
            'inventory_id'=>1,
            'price'=>"434",
            'warranty_duration'=>"6 month",
            'warranty_type'=>"service",
            'warranty_start'=>"01-07-19",
            'warranty_end'=>"01-07-20",
            'unique_code'=>"112",
        ]);
        echo "SaleDetail seeded .... \n";

    }
}
