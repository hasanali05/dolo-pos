<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        echo "Database seeding .... \n";
        $this->call(AuthenticateSeeder::class);

        $this->call(AccountSeeder::class);
        // $this->call(ExpenseSeeder::class);

        $this->call(InventorySeeder::class);
        $this->call(PurchaseSeeder::class);
        
        $this->call(SaleSeeder::class);
        $this->call(DamageWarrentySeeder::class);

        echo "Database seeded .... \n";
    }
}
