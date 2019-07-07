<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        View::composer('admin.*', function ($view) {

            $accountGroups = ['Asset', 'Expense', 'Liability', 'Income', 'Capital'];
            $view->with('accountGroups', json_encode($accountGroups));

            $accountSubGroups = ['Accounts Payable', 'Accounts Receiveable', 'Bank', 'Capital', 'Cash', 'Expense', 'Profit & Loss'];
            $view->with('accountSubGroups', json_encode($accountSubGroups));

            $transactionAccounts = \App\Account::where('group', '=', 'Asset')
                            ->where('sub_group', '=', 'Cash')
                            ->orWhere('sub_group', '=', 'Bank')->get();
            $view->with('transactionAccounts', json_encode($transactionAccounts));

            $receivableAccounts = \App\Account::where('group', '=', 'Asset')
                            ->where('sub_group', '=', 'Accounts Receiveable')->get();
            $view->with('receivableAccounts', json_encode($receivableAccounts));

            $liabilityAccounts = \App\Account::where('group', '=', 'Expense')
                            ->orWhere('group', '=', 'Liability')->get();
            $view->with('liabilityAccounts', json_encode($liabilityAccounts));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
