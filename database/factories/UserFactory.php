<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\ProductCategory::class, function (Faker $faker) {
    return [
        'name' =>$faker->name,
        'is_active' =>$faker->boolean,
        
    ];
});


$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' =>$faker->name,
        'category_id'=>rand(1,10),
        'detail'=>$faker->word,
        'is_active' =>$faker->boolean,
        
    ];
});

$factory->define(App\Supplier::class, function (Faker $faker) {
    return [
        
        'account_id'=>rand(1,10),
        'name' =>$faker->name,
        'contact' =>$faker->e164PhoneNumber,
        'address'=>$faker->address,
        'is_active' =>$faker->boolean,
        
    ];
});

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        
        'supplier_id'=>rand(1,10),
        'purchase_date' =>$faker->date,
        'amount' =>rand(10,20),
        'commission'=>rand(10,20),
        'payment' =>rand(10,20),
        'due' =>rand(10,20),
        
    ];
});
$factory->define(App\PurchaseDetail::class, function (Faker $faker) {
    return [
        
        'purchase_id'=>rand(1,10),
        'product_id'=>rand(1,10),
        'price' =>rand(10,20),
        'warranty_duration'=>$faker->dateTimeThisCentury,
        'unique_code' =>$faker->swiftBicNumber,
        
    ];
});


$factory->define(App\Inventory::class, function (Faker $faker) {
    return [
        
        'product_id'=>rand(1,10),
        'unique_code'=>$faker->swiftBicNumber,
        'quantity'=>$faker->randomDigit,
        'buying_price'=>rand(500,2000),
        'selling_price'=>rand(600,2000),
        'supplier_id'=>rand(1,10),
         'purchase_id'=>rand(1,10),
        'customer_id'=>rand(1,10),
        'sale_id'=>rand(1,10),
        
    ];

});

$factory->define(App\PurchaseTransaction::class, function (Faker $faker) {
    return [
        
        'supplier_id'=>rand(1,10),
        'amount'=>rand(500,2000),
 
        
    ];
});

$factory->define(App\Sale::class, function (Faker $faker) {
    return [
        
        'customer_id'=>rand(1,10),
        'sale_date'=>$faker->date,
        'amount'=>rand(50,500),
        'commission'=>rand(10,20),
        'payment'=>rand(10,20),
        'due'=>rand(10,20),
        
    ];

});
