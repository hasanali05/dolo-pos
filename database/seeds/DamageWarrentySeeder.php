<?php

use Illuminate\Database\Seeder;

class DamageWarrentySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only Damange and Warrenty
        echo "Warranty seeding .... \n";
        $inventory = App\Inventory::create([
             // 'id'=>$line[0],
             'product_id'=>1,
             'unique_code'=>"33",
             'quantity'=>"4",
             'buying_price'=>"100",
             'selling_price'=>"120",
             'status'=>"sold",
             'supplier_id'=>1,
             'supply_id'=>1,
             'customer_id'=>1,
             'sale_id'=>1,
            ]);
        App\Warranty::create([
            'inventory_id' => $inventory->id,
            'purchase_id' => 1,
            'sale_id' => 1,
            'warranty_duration'=>6,
            'warranty_type'=>"months",
            'warranty_start'=>"02-07-19",
            'warranty_end'=>"02-07-20",
            'issue_date'=>"02-07-29",
            'reason'=>"Damage",
            'return_date'=>"23-07-29",
        ]);

        $inventory = App\Inventory::create([
             // 'id'=>$line[0],
             'product_id'=>1,
             'unique_code'=>"33",
             'quantity'=>"4",
             'buying_price'=>"100",
             'selling_price'=>"120",
             'status'=>"sold",
             'supplier_id'=>1,
             'purchase_id'=>1,
             'customer_id'=>1,
             'sale_id'=>1,
            ]);
        App\Damage::create([
            'inventory_id' => $inventory->id,
            'issue_date'=>"2-07-19",
            'reason'=>"No reson",
            'status'=>"damaged",
        ]);
        echo "Warranty seeded .... \n";
    }
}
