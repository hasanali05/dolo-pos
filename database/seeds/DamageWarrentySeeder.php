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
        echo "Damage and warrenty seeding .... \n";
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
        App\Damage::create([
            'inventory_id' => $inventory->id,
            'issue_date'=>"2-07-19",
            'reason'=>"No reson",
            'status'=>"sold",
        ]);
        echo "Damage and warrenty seeded .... \n";
    }
}
