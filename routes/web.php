<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('admin.pages.index');
// });
Route::get('/', 'HomeController@index');

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function()
{
	Route::middleware('auth:admin')->group(function()
	{
		//profile
		Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
		Route::get('/myprofile', 'AdminController@myprofile')->name('admin.myprofile');
		Route::post('/profile-update', 'AdminController@updateProfile')->name('admin.updateProfile');
		Route::get('/change-password', 'AdminController@changePassword')->name('admin.changePassword');
		Route::post('/change-password', 'AdminController@changePassword')->name('admin.changePassword');

		//employee
		Route::get('/employees', 'EmployeeDetailController@employees')->name('employees');
		Route::get('/employees-all', 'EmployeeDetailController@employeesAll')->name('employees.all');
		Route::post('/employees-status-change', 'EmployeeDetailController@statusChange')->name('employees.statusChange');
		Route::post('/employee-add-or-update', 'EmployeeDetailController@addOrUpdate')->name('employees.addOrUpdate');

		
		//accounts
		Route::get('/accounts', 'AccountController@accounts')->name('accounts');
		Route::get('/accounts-all', 'AccountController@accountsAll')->name('accounts.all');
		Route::post('/accounts-status-change', 'AccountController@statusChange')->name('accounts.statusChange');
		Route::post('/accounts-add-or-update', 'AccountController@addOrUpdate')->name('accounts.addOrUpdate');
		
		//ledgers
		Route::get('/ledgers', 'LedgerController@ledgers')->name('ledgers');
		Route::get('/ledgers-all', 'LedgerController@ledgersAll')->name('ledgers.all');
		Route::post('/ledgers-status-change', 'LedgerController@statusChange')->name('ledgers.statusChange');
		Route::post('/ledgers-add-or-update', 'LedgerController@addOrUpdate')->name('ledgers.addOrUpdate');

		//expenses
		Route::get('/expenses', 'ExpenseController@expenses')->name('expenses');
		Route::get('/expenses-all', 'ExpenseController@expensesAll')->name('expenses.all');
		Route::post('/expenses-status-change', 'ExpenseController@statusChange')->name('expenses.statusChange');
		Route::post('/expenses-add-or-update', 'ExpenseController@addOrUpdate')->name('expenses.addOrUpdate');

		//productCategories
		Route::get('/productCategories', 'ProductCategoryController@productCategories')->name('productCategories');
		Route::get('/productCategories-all', 'ProductCategoryController@productCategoriesAll')->name('productCategories.all');
		Route::post('/productCategories-status-change', 'ProductCategoryController@statusChange')->name('productCategories.statusChange');
		Route::post('/productCategories-add-or-update', 'ProductCategoryController@addOrUpdate')->name('productCategories.addOrUpdate');

		//report
		Route::get('/overview',  'ReportController@overview')->name('report.overview');
		Route::post('/overview',  'ReportController@overviewGet')->name('report.overview');



		Route::get('/incomeExpense',  'ReportController@incomeExpense')->name('report.incomeExpense');
		Route::post('/incomeExpense',  'ReportController@incomeExpenseGet')->name('report.incomeExpense');
		Route::get('/inventory',  'ReportController@inventoryReport')->name('report.inventoryReport');
		Route::post('/inventory',  'ReportController@inventoryReportGet')->name('report.inventoryReport');
		Route::get('/Ledger',  'ReportController@ledgerReport')->name('report.ledger');
		Route::post('/Ledger',  'ReportController@ledgerReportGet')->name('report.ledger');
		Route::get('/purchase',  'ReportController@purchaseReport')->name('report.purchase');
		Route::post('/purchase',  'ReportController@purchaseReportGet')->name('report.purchase');
		Route::get('/sale',  'ReportController@saleReport')->name('report.sale');
		Route::post('/sale',  'ReportController@saleReportGet')->name('report.sale');
		Route::get('/supplier',  'ReportController@supplierReport')->name('report.supplier');
		Route::post('/supplier',  'ReportController@supplierReportGet')->name('report.supplier');
		Route::get('/customer',  'ReportController@customerReport')->name('report.customer');
		Route::post('/customer',  'ReportController@customerReportGet')->name('report.customer');
		Route::get('/dueReceive',  'ReportController@dueReceive')->name('report.dueReceive');
		Route::post('/dueReceive',  'ReportController@dueReceivGet')->name('report.dueReceive');
		Route::get('/duePaySummery',  'ReportController@duePaySummery')->name('report.duePay');
		Route::post('/duePaySummery',  'ReportController@duePaySummeryGet')->name('report.duePay');

		//products
		Route::get('/products', 'ProductController@products')->name('products');
		Route::get('/products-all', 'ProductController@productsAll')->name('products.all');
		Route::post('/products-status-change', 'ProductController@statusChange')->name('products.statusChange');
		Route::post('/products-add-or-update', 'ProductController@addOrUpdate')->name('products.addOrUpdate');

		//suppliers
		Route::get('/suppliers', 'SupplierController@suppliers')->name('suppliers');
		Route::get('/suppliers-all', 'SupplierController@suppliersAll')->name('suppliers.all');
		Route::post('/suppliers-status-change', 'SupplierController@statusChange')->name('suppliers.statusChange');
		Route::post('/suppliers-add-or-update', 'SupplierController@addOrUpdate')->name('suppliers.addOrUpdate');


		//customers
		Route::get('/customers', 'CustomerController@customers')->name('customers');
		Route::get('/customers-all', 'CustomerController@customersAll')->name('customers.all');
		Route::post('/customers-status-change', 'CustomerController@statusChange')->name('customers.statusChange');
		Route::post('/customers-add-or-update', 'CustomerController@addOrUpdate')->name('customers.addOrUpdate');

		//purchases (initially purchase, purchase detail and purchase transaction will be one action)
		Route::get('/purchases', 'PurchaseController@purchases')->name('purchases');
		Route::get('/purchases-all', 'PurchaseController@purchasesAll')->name('purchases.all');
		Route::get('/purchases-detail', 'PurchaseController@purchasesdetail')->name('purchasesdetail.all');
		Route::post('/purchases-add-or-update', 'PurchaseController@addOrUpdate')->name('purchases.addOrUpdate');
		//purchase details

		Route::get('/purchasesDetail', 'PurchaseDetailController@purchasesDetail')->name('purchasesDetails');
		Route::get('/purchasesDetail-all', 'PurchaseDetailController@purchasesDetailAll')->name('purchasesDetails.all');
		//purchase transection

		Route::get('/purchaseTransaction', 'PurchaseTransactionController@purchaseTransaction')->name('purchaseTransaction');
		Route::get('/purchaseTransaction-all', 'PurchaseTransactionController@purchaseTransactionAll')->name('purchaseTransaction.all');
		Route::post('/purchaseTransaction-add-or-update', 'PurchaseTransactionController@addOrUpdate')->name('purchaseTransaction.addOrUpdate');

		//inventory
		Route::get('/inventories', 'InventoryController@purchases')->name('inventories');
		Route::get('/inventories-all', 'InventoryController@inventoriesAll')->name('inventories.all');
		Route::get('/inventories-prodducts', 'InventoryController@inventoriesProdducts')->name('inventories.prodducts');

		//sales (initially sale, sale detail and sale transaction will be one action)
		Route::get('/sales', 'SaleController@sales')->name('sales');
		Route::get('/sales-all', 'SaleController@salesAll')->name('sales.all');
		Route::get('/salesdetail-all', 'SaleController@salesdetail')->name('salesdetail.all');
		Route::post('/sales-add-or-update', 'SaleController@addOrUpdate')->name('sales.addOrUpdate');
		//SalesDetails
		Route::get('/salesDetails', 'SaleDetailController@salesDetails')->name('salesDetails');
		Route::get('/salesDetails-all', 'SaleDetailController@salesDetailAll')->name('salesDetails.all');
        //SaleTransection
		Route::get('/saleTransaction', 'saleTransactionController@saleTransaction')->name('saleTransaction');
		Route::get('/saleTransaction-all', 'saleTransactionController@saleTransactionAll')->name('saleTransaction.all');
		Route::post('/saleTransaction-add-or-update', 'saleTransactionController@addOrUpdate')->name('saleTransaction.addOrUpdate');

		//damages 
		Route::get('/damages', 'DamageController@damages')->name('damages');
		Route::get('/damages-all', 'DamageController@damagesAll')->name('damages.all');
		Route::post('/damages-status-change', 'DamageController@statusChange')->name('damages.statusChange');
		Route::post('/damages-add-or-update', 'DamageController@addOrUpdate')->name('damages.addOrUpdate');

		//warranties 
		Route::get('/warranties', 'WarrantyController@warranties')->name('warranties');
		Route::get('/warranties-all', 'WarrantyController@warrantiesAll')->name('warranties.all');
		Route::post('/warranties-status-change', 'WarrantyController@statusChange')->name('warranties.statusChange');
		Route::post('/warranties-add-or-update', 'WarrantyController@addOrUpdate')->name('warranties.addOrUpdate');


		Route::get('/', 'AdminController@index')->name('admin.index');
	});
	Route::post('/admin/emailCheck', 'Auth\AdminLoginController@emailCheck')->name('admin.emailCheck');
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login');
    Route::post('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');

	Route::get('/{wild}', 'AdminController@page404')->name('admin.page404');
});



Route::prefix('employee')->group(function()
{
	Route::middleware('auth:employee')->group(function(){
		//profile
		Route::get('/dashboard', 'EmployeeController@dashboard')->name('employee.dashboard');	
		Route::get('/myprofile', 'EmployeeController@myprofile')->name('employee.myprofile');	
		Route::post('/profile-update', 'EmployeeController@updateProfile')->name('employee.updateProfile');
		Route::get('/change-password', 'EmployeeController@changePassword')->name('employee.changePassword');
		Route::post('/change-password', 'EmployeeController@changePassword')->name('employee.changePassword');

		Route::get('/', 'EmployeeController@index')->name('employee.index');
	});
	Route::post('/employee/emailCheck', 'Auth\EmployeeLoginController@emailCheck')->name('employee.emailCheck');
	Route::get('/login', 'Auth\EmployeeLoginController@showLoginForm')->name('employee.login');
	Route::post('/login', 'Auth\EmployeeLoginController@login');
    Route::post('/logout', 'Auth\EmployeeLoginController@employeeLogout')->name('employee.logout');

	Route::get('/{wild}', 'EmployeeController@page404')->name('employee.page404');
});

Route::prefix('common')->group(function()
{
	Route::middleware('auth:admin')->group(function(){

	});

	Route::middleware('auth:employee')->group(function(){	


	});

	Route::middleware('auth:admin,employee')->group(function(){


	});
	Route::get('/{wild}', 'HomeController@page404')->name('admin.page404');
});

Route::get('/index', 'HomeController@page404')->name('site.index');
Route::get('/page404', 'HomeController@page404')->name('page404');
Route::get('/{wild}', 'HomeController@page404');

