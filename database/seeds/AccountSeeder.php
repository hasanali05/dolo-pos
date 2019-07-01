<?php

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only Account and Ledger
        echo "Account seeding .... \n";
        $account=fopen('database/seeds/account.txt','r') or die("Unable to open account!");
        while (($line = fgetcsv($account)) !== false) {
            App\Account::create([
             // 'id'=>$line[0],
             'name'=>$line[1],
             'sub_group'=>$line[2],
             'group'=>$line[3],
             'created_by'=>1,
             'is_active'=>$line[5],
            ]);
        }
        fclose($account);
        echo "Account seeded .... \n";
    }
}
