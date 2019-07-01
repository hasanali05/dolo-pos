<?php

use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only Expense
        echo "Expense seeding .... \n";
        $account = App\Account::create([
             // 'id'=>$line[0],
             'name'=>"Shop expense",
             'sub_group'=>"Expense",
             'group'=>"Expense",
             'created_by'=>1,
             'is_active'=>1,
            ]);
        for($i=0;$i<10;$i++){
            App\Expense::create([
                'account_id' => $account->id,
                'title'=>"Product Sell",
                'expense_date'=>"29-06-19",
                'amount'=>"500",
                'reason'=>"No reson",
                 'type' =>"regular",
            ]);
        }
        echo "Expense seeded .... \n";
    }
}
