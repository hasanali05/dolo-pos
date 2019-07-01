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

        echo "Customer seeding .... \n";

        $account = App\Account::create([
             // 'id'=>$line[0],
             'name'=>"Shop Customer",
             'sub_group'=>"Asset",
             'group'=>"Accounts Receiveable",
             'created_by'=>1,
             'is_active'=>1,
            ]);
        for($i=0;$i<10;$i++){
            $customer = App\Customer::create([
                'account_id' => $account->id,
                'name'=>"Sama".$i,
                'contact'=>"0182738434",
                'address'=>"Dhaka",
                'is_active'=>1,
            ]);
        }
        echo "Customer seeded .... \n";

        echo "Sale seeding .... \n";
        App\Sale::create([
            'customer_id' => $customer->id,
            'sale_date'=>"01-07-19",
            'amount'=>"434",
            'commission'=>"50",
            'payment'=>"300",
            'due'=>"100",
        ]);
        echo "Sale seeded .... \n";
    }
}
