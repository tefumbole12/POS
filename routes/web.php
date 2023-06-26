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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
	Route::get('/dashboard', 'HomeController@dashboard');
});

Route::group(['middleware' => ['auth', 'active']], function() {

	Route::get('/', 'HomeController@index');
	Route::get('/wp', 'HomeController@whatsapp');
	Route::get('/mmt', 'HomeController@mobileMoneyToken');
	Route::get('/mmr', 'HomeController@mobileMoneyRequest');
	Route::get('/mms', 'HomeController@mobileMoneyStatus');
	Route::get('/dashboard-filter/{start_date}/{end_date}', 'HomeController@dashboardFilter');
	Route::get('check-batch-availability/{product_id}/{batch_no}/{warehouse_id}', 'ProductController@checkBatchAvailability');

	Route::get('language_switch/{locale}', 'LanguageController@switchLanguage');

	Route::get('role/permission/{id}', 'RoleController@permission')->name('role.permission');
	Route::post('role/set_permission', 'RoleController@setPermission')->name('role.setPermission');
	Route::resource('role', 'RoleController');

	Route::post('importunit', 'UnitController@importUnit')->name('unit.import');
	Route::post('unit/deletebyselection', 'UnitController@deleteBySelection');
	Route::get('unit/lims_unit_search', 'UnitController@limsUnitSearch')->name('unit.search');
	Route::resource('unit', 'UnitController');

	Route::post('category/import', 'CategoryController@import')->name('category.import');
	Route::post('category/deletebyselection', 'CategoryController@deleteBySelection');
	Route::post('category/category-data', 'CategoryController@categoryData');
	Route::resource('category', 'CategoryController');

	Route::post('importbrand', 'BrandController@importBrand')->name('brand.import');
	Route::post('brand/deletebyselection', 'BrandController@deleteBySelection');
	Route::get('brand/lims_brand_search', 'BrandController@limsBrandSearch')->name('brand.search');
	Route::resource('brand', 'BrandController');

	Route::post('importsupplier', 'SupplierController@importSupplier')->name('supplier.import');
	Route::post('supplier/deletebyselection', 'SupplierController@deleteBySelection');
	Route::get('supplier/lims_supplier_search', 'SupplierController@limsSupplierSearch')->name('supplier.search');
	Route::resource('supplier', 'SupplierController');

	Route::post('importwarehouse', 'WarehouseController@importWarehouse')->name('warehouse.import');
	Route::post('warehouse/deletebyselection', 'WarehouseController@deleteBySelection');
	Route::get('warehouse/lims_warehouse_search', 'WarehouseController@limsWarehouseSearch')->name('warehouse.search');
	Route::resource('warehouse', 'WarehouseController');

	Route::post('importtax', 'TaxController@importTax')->name('tax.import');
	Route::post('tax/deletebyselection', 'TaxController@deleteBySelection');
	Route::get('tax/lims_tax_search', 'TaxController@limsTaxSearch')->name('tax.search');
	Route::resource('tax', 'TaxController');

	//Route::get('products/getbarcode', 'ProductController@getBarcode');
	Route::post('products/product-data', 'ProductController@productData');
	Route::get('products/gencode', 'ProductController@generateCode');
	Route::get('products/search', 'ProductController@search');
	Route::get('products/saleunit/{id}', 'ProductController@saleUnit');
	Route::get('products/getdata/{id}', 'ProductController@getData');
	Route::get('products/product_warehouse/{id}', 'ProductController@productWarehouseData');
	Route::post('importproduct', 'ProductController@importProduct')->name('product.import');
	Route::post('exportproduct', 'ProductController@exportProduct')->name('product.export');
	Route::get('products/print_barcode','ProductController@printBarcode')->name('product.printBarcode');

	Route::get('products/lims_product_search', 'ProductController@limsProductSearch')->name('product.search');
	Route::post('products/deletebyselection', 'ProductController@deleteBySelection');
	Route::post('products/update', 'ProductController@updateProduct');
	Route::resource('products', 'ProductController');

	Route::post('importcustomer_group', 'CustomerGroupController@importCustomerGroup')->name('customer_group.import');
	Route::post('customer_group/deletebyselection', 'CustomerGroupController@deleteBySelection');
	Route::get('customer_group/lims_customer_group_search', 'CustomerGroupController@limsCustomerGroupSearch')->name('customer_group.search');
	Route::resource('customer_group', 'CustomerGroupController');

	Route::post('importcustomer', 'CustomerController@importCustomer')->name('customer.import');
	Route::get('customer/getDeposit/{id}', 'CustomerController@getDeposit');
	Route::post('customer/add_deposit', 'CustomerController@addDeposit')->name('customer.addDeposit');
	Route::post('customer/update_deposit', 'CustomerController@updateDeposit')->name('customer.updateDeposit');
	Route::post('customer/deleteDeposit', 'CustomerController@deleteDeposit')->name('customer.deleteDeposit');
	Route::post('customer/deletebyselection', 'CustomerController@deleteBySelection');
	Route::get('customer/lims_customer_search', 'CustomerController@limsCustomerSearch')->name('customer.search');
	Route::resource('customer', 'CustomerController');

	Route::post('importbiller', 'BillerController@importBiller')->name('biller.import');
	Route::post('biller/deletebyselection', 'BillerController@deleteBySelection');
	Route::get('biller/lims_biller_search', 'BillerController@limsBillerSearch')->name('biller.search');
	Route::resource('biller', 'BillerController');

	Route::get('sales/category/associate', 'SaleController@addCategoryIdInSale');
	Route::post('sales/sale-data', 'SaleController@saleData');
	Route::post('sales/sendmail', 'SaleController@sendMail')->name('sale.sendmail');
	Route::get('sales/sale_by_csv', 'SaleController@saleByCsv');
	Route::get('sales/product_sale/{id}','SaleController@productSaleData');
	Route::post('importsale', 'SaleController@importSale')->name('sale.import');
	Route::get('pos', 'SaleController@posSale')->name('sale.pos');
	Route::get('sales/lims_sale_search', 'SaleController@limsSaleSearch')->name('sale.search');
	Route::get('sales/lims_product_search', 'SaleController@limsProductSearch')->name('product_sale.search');
	Route::get('sales/getcustomergroup/{id}', 'SaleController@getCustomerGroup')->name('sale.getcustomergroup');
	Route::get('sales/getproduct/{id}', 'SaleController@getProduct')->name('sale.getproduct');
	Route::get('sales/get-batch-products/{id}', 'SaleController@getBatchProduct')->name('sale.getBatchProducts');
	Route::get('sales/getproduct/{category_id}/{brand_id}', 'SaleController@getProductByFilter');
	Route::get('sales/getfeatured', 'SaleController@getFeatured');
	Route::get('sales/get_gift_card', 'SaleController@getGiftCard');
	Route::get('sales/paypalSuccess', 'SaleController@paypalSuccess');
	Route::get('sales/paypalPaymentSuccess/{id}', 'SaleController@paypalPaymentSuccess');
	Route::get('sales/gen_invoice/{id}', 'SaleController@genInvoice')->name('sale.invoice');
	Route::post('sales/add_payment', 'SaleController@addPayment')->name('sale.add-payment');
	Route::get('sales/getpayment/{id}', 'SaleController@getPayment')->name('sale.get-payment');
	Route::post('sales/updatepayment', 'SaleController@updatePayment')->name('sale.update-payment');
	Route::post('sales/deletepayment', 'SaleController@deletePayment')->name('sale.delete-payment');
	Route::get('sales/{id}/create', 'SaleController@createSale');
	Route::post('sales/deletebyselection', 'SaleController@deleteBySelection');
	Route::get('sales/print-last-reciept', 'SaleController@printLastReciept')->name('sales.printLastReciept');
	Route::get('sales/today-sale', 'SaleController@todaySale');
	Route::get('sales/today-profit/{warehouse_id}', 'SaleController@todayProfit');
	Route::resource('sales', 'SaleController');

	Route::get('delivery', 'DeliveryController@index')->name('delivery.index');
	Route::get('delivery/product_delivery/{id}','DeliveryController@productDeliveryData');
	Route::get('delivery/create/{id}', 'DeliveryController@create');
	Route::post('delivery/store', 'DeliveryController@store')->name('delivery.store');
	Route::post('delivery/sendmail', 'DeliveryController@sendMail')->name('delivery.sendMail');
	Route::get('delivery/{id}/edit', 'DeliveryController@edit');
	Route::post('delivery/update', 'DeliveryController@update')->name('delivery.update');
	Route::post('delivery/deletebyselection', 'DeliveryController@deleteBySelection');
	Route::post('delivery/delete/{id}', 'DeliveryController@delete')->name('delivery.delete');

	Route::get('quotations/product_quotation/{id}','QuotationController@productQuotationData');
	Route::get('quotations/lims_product_search', 'QuotationController@limsProductSearch')->name('product_quotation.search');
	Route::get('quotations/getcustomergroup/{id}', 'QuotationController@getCustomerGroup')->name('quotation.getcustomergroup');
	Route::get('quotations/getproduct/{id}', 'QuotationController@getProduct')->name('quotation.getproduct');
	Route::get('quotations/{id}/create_sale', 'QuotationController@createSale')->name('quotation.create_sale');
	Route::get('quotations/{id}/create_purchase', 'QuotationController@createPurchase')->name('quotation.create_purchase');
	Route::post('quotations/sendmail', 'QuotationController@sendMail')->name('quotation.sendmail');
	Route::post('quotations/sendwhatsapp', 'QuotationController@sendWhatsapp')->name('quotation.sendwhatsapp');
	Route::post('quotations/deletebyselection', 'QuotationController@deleteBySelection');
	Route::resource('quotations', 'QuotationController');

	Route::post('purchases/purchase-data', 'PurchaseController@purchaseData')->name('purchases.data');
	Route::get('purchases/product_purchase/{id}','PurchaseController@productPurchaseData');
	Route::get('purchases/lims_product_search', 'PurchaseController@limsProductSearch')->name('product_purchase.search');
	Route::post('purchases/add_payment', 'PurchaseController@addPayment')->name('purchase.add-payment');
	Route::get('purchases/getpayment/{id}', 'PurchaseController@getPayment')->name('purchase.get-payment');
	Route::post('purchases/updatepayment', 'PurchaseController@updatePayment')->name('purchase.update-payment');
	Route::post('purchases/deletepayment', 'PurchaseController@deletePayment')->name('purchase.delete-payment');
	Route::get('purchases/purchase_by_csv', 'PurchaseController@purchaseByCsv');
	Route::post('importpurchase', 'PurchaseController@importPurchase')->name('purchase.import');
	Route::post('purchases/deletebyselection', 'PurchaseController@deleteBySelection');
	Route::resource('purchases', 'PurchaseController');

	Route::get('transfers/product_transfer/{id}','TransferController@productTransferData');
	Route::get('transfers/transfer_by_csv', 'TransferController@transferByCsv');
	Route::post('importtransfer', 'TransferController@importTransfer')->name('transfer.import');
	Route::get('transfers/getproduct/{id}', 'TransferController@getProduct')->name('transfer.getproduct');
	Route::get('transfers/lims_product_search', 'TransferController@limsProductSearch')->name('product_transfer.search');
	Route::post('transfers/deletebyselection', 'TransferController@deleteBySelection');
	Route::resource('transfers', 'TransferController');

	Route::get('qty_adjustment/getproduct/{id}', 'AdjustmentController@getProduct')->name('adjustment.getproduct');
	Route::get('qty_adjustment/lims_product_search', 'AdjustmentController@limsProductSearch')->name('product_adjustment.search');
	Route::post('qty_adjustment/deletebyselection', 'AdjustmentController@deleteBySelection');
	Route::resource('qty_adjustment', 'AdjustmentController');

	Route::get('return-sale/getcustomergroup/{id}', 'ReturnController@getCustomerGroup')->name('return-sale.getcustomergroup');
	Route::post('return-sale/sendmail', 'ReturnController@sendMail')->name('return-sale.sendmail');
	Route::get('return-sale/getproduct/{id}', 'ReturnController@getProduct')->name('return-sale.getproduct');
	Route::get('return-sale/lims_product_search', 'ReturnController@limsProductSearch')->name('product_return-sale.search');
	Route::get('return-sale/product_return/{id}','ReturnController@productReturnData');
	Route::post('return-sale/deletebyselection', 'ReturnController@deleteBySelection');
	Route::resource('return-sale', 'ReturnController');

	Route::get('return-purchase/getcustomergroup/{id}', 'ReturnPurchaseController@getCustomerGroup')->name('return-purchase.getcustomergroup');
	Route::post('return-purchase/sendmail', 'ReturnPurchaseController@sendMail')->name('return-purchase.sendmail');
	Route::get('return-purchase/getproduct/{id}', 'ReturnPurchaseController@getProduct')->name('return-purchase.getproduct');
	Route::get('return-purchase/lims_product_search', 'ReturnPurchaseController@limsProductSearch')->name('product_return-purchase.search');
	Route::get('return-purchase/product_return/{id}','ReturnPurchaseController@productReturnData');
	Route::post('return-purchase/deletebyselection', 'ReturnPurchaseController@deleteBySelection');
	Route::resource('return-purchase', 'ReturnPurchaseController');

	Route::get('report/average_sale', 'ReportController@averageSale')->name('report.averageSale');
    Route::post('report/average_sale_data', 'ReportController@averageSaleData')->name('report.average.sale');
    Route::get('report/JE', 'ReportController@JE')->name('report.JE');
    Route::post('report/JE_data', 'ReportController@JEData')->name('report.JEData');
    Route::get('report/product_quantity_alert', 'ReportController@productQuantityAlert')->name('report.qtyAlert');
	Route::get('report/warehouse_stock', 'ReportController@warehouseStock')->name('report.warehouseStock');
	Route::post('report/warehouse_stock', 'ReportController@warehouseStockById')->name('report.warehouseStock');
	Route::get('report/daily_sale/{year}/{month}', 'ReportController@dailySale');
	Route::post('report/daily_sale/{year}/{month}', 'ReportController@dailySaleByWarehouse')->name('report.dailySaleByWarehouse');
	Route::get('report/monthly_sale/{year}', 'ReportController@monthlySale');
	Route::post('report/monthly_sale/{year}', 'ReportController@monthlySaleByWarehouse')->name('report.monthlySaleByWarehouse');
	Route::get('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchase');
	Route::post('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchaseByWarehouse')->name('report.dailyPurchaseByWarehouse');
	Route::get('report/monthly_purchase/{year}', 'ReportController@monthlyPurchase');
	Route::post('report/monthly_purchase/{year}', 'ReportController@monthlyPurchaseByWarehouse')->name('report.monthlyPurchaseByWarehouse');
	Route::get('report/best_seller', 'ReportController@bestSeller');
	Route::post('report/best_seller', 'ReportController@bestSellerByWarehouse')->name('report.bestSellerByWarehouse');
	Route::post('report/profit_loss', 'ReportController@profitLoss')->name('report.profitLoss');
	Route::get('report/product_report', 'ReportController@productReport')->name('report.product');
	Route::get('report/category_report', 'ReportController@categoryReport')->name('report.category');
	Route::post('report/product_report_data', 'ReportController@productReportData');
	Route::post('report/category_report_data', 'ReportController@categoryReportData')->name('report.category.data');
	Route::post('report/purchase', 'ReportController@purchaseReport')->name('report.purchase');
	Route::post('report/sale_report', 'ReportController@saleReport')->name('report.sale');
	Route::post('report/payment_report_by_date', 'ReportController@paymentReportByDate')->name('report.paymentByDate');
	Route::post('report/warehouse_report', 'ReportController@warehouseReport')->name('report.warehouse');
	Route::post('report/user_report', 'ReportController@userReport')->name('report.user');
	Route::post('report/customer_report', 'ReportController@customerReport')->name('report.customer');
	Route::post('report/supplier', 'ReportController@supplierReport')->name('report.supplier');
	Route::post('report/due_report_by_date', 'ReportController@dueReportByDate')->name('report.dueByDate');

	Route::get('user/profile/{id}', 'UserController@profile')->name('user.profile');
	Route::put('user/update_profile/{id}', 'UserController@profileUpdate')->name('user.profileUpdate');
	Route::put('user/changepass/{id}', 'UserController@changePassword')->name('user.password');
	Route::get('user/genpass', 'UserController@generatePassword');
	Route::post('user/deletebyselection', 'UserController@deleteBySelection');
	Route::resource('user','UserController');

	Route::get('setting/general_setting', 'SettingController@generalSetting')->name('setting.general');
	Route::post('setting/general_setting_store', 'SettingController@generalSettingStore')->name('setting.generalStore');

	Route::get('setting/reward-point-setting', 'SettingController@rewardPointSetting')->name('setting.rewardPoint');
	Route::post('setting/reward-point-setting_store', 'SettingController@rewardPointSettingStore')->name('setting.rewardPointStore');

	Route::get('backup', 'SettingController@backup')->name('setting.backup');
	Route::get('setting/general_setting/change-theme/{theme}', 'SettingController@changeTheme');
	Route::get('setting/mail_setting', 'SettingController@mailSetting')->name('setting.mail');
	Route::get('setting/sms_setting', 'SettingController@smsSetting')->name('setting.sms');
	Route::get('setting/createsms', 'SettingController@createSms')->name('setting.createSms');
	Route::post('setting/sendsms', 'SettingController@sendSms')->name('setting.sendSms');
	Route::get('setting/hrm_setting', 'SettingController@hrmSetting')->name('setting.hrm');
	Route::post('setting/hrm_setting_store', 'SettingController@hrmSettingStore')->name('setting.hrmStore');
	Route::post('setting/mail_setting_store', 'SettingController@mailSettingStore')->name('setting.mailStore');
	Route::post('setting/sms_setting_store', 'SettingController@smsSettingStore')->name('setting.smsStore');
	Route::get('setting/pos_setting', 'SettingController@posSetting')->name('setting.pos');
	Route::post('setting/pos_setting_store', 'SettingController@posSettingStore')->name('setting.posStore');
	Route::get('setting/empty-database', 'SettingController@emptyDatabase')->name('setting.emptyDatabase');

	Route::get('expense_categories/gencode', 'ExpenseCategoryController@generateCode');
	Route::post('expense_categories/import', 'ExpenseCategoryController@import')->name('expense_category.import');
	Route::post('expense_categories/deletebyselection', 'ExpenseCategoryController@deleteBySelection');
	Route::resource('expense_categories', 'ExpenseCategoryController');

	Route::post('expenses/deletebyselection', 'ExpenseController@deleteBySelection');
	Route::resource('expenses', 'ExpenseController');
	Route::get('/expense/asset', 'ExpenseController@asset')->name('asset.expense');
	Route::get('/activity/asset', 'ExpenseController@assetActivity')->name('asset.activity');
	Route::get('/activity/repair', 'ExpenseController@assetActivityRepair')->name('asset.activity.repair');
	Route::post('assets/expense/store', 'ExpenseController@assetStore')->name('expense_asset.store');
	Route::put('assets/expense/update/{id}', 'ExpenseController@updateAsset')->name('expense_asset.update');
	Route::delete('assets/expense/delete/{id}', 'ExpenseController@destroyAsset')->name('expense_asset.destroy');
	Route::get('expense/assets/edit/{id}', 'ExpenseController@editAsset')->name('expense_asset.edit');
    Route::get('activity/assets/edit/{id}', 'ExpenseController@editAsset')->name('activity_asset.edit');
	Route::get('expense/assets/show/{id}', 'ExpenseController@showAsset')->name('expense_asset.show');
	Route::get('activity/assets/show/{id}', 'ExpenseController@showAsset')->name('activity_asset.show');
    Route::resource('activity', 'ActivityController');

	Route::get('gift_cards/gencode', 'GiftCardController@generateCode');
	Route::post('gift_cards/recharge/{id}', 'GiftCardController@recharge')->name('gift_cards.recharge');
	Route::post('gift_cards/deletebyselection', 'GiftCardController@deleteBySelection');
	Route::resource('gift_cards', 'GiftCardController');

	Route::get('coupons/gencode', 'CouponController@generateCode');
	Route::post('coupons/deletebyselection', 'CouponController@deleteBySelection');
	Route::resource('coupons', 'CouponController');
	//accounting routes
	Route::get('accounts/make-default/{id}', 'AccountsController@makeDefault');
	Route::get('accounts/balancesheet', 'AccountsController@balanceSheet')->name('accounts.balancesheet');
	Route::post('accounts/account-statement', 'AccountsController@accountStatement')->name('accounts.statement');
	Route::resource('accounts', 'AccountsController');
	Route::resource('money-transfers', 'MoneyTransferController');
	//HRM routes
	Route::post('departments/deletebyselection', 'DepartmentController@deleteBySelection');
	Route::resource('departments', 'DepartmentController');

	Route::post('employees/deletebyselection', 'EmployeeController@deleteBySelection');
	Route::resource('employees', 'EmployeeController');

	Route::post('payroll/deletebyselection', 'PayrollController@deleteBySelection');
	Route::resource('payroll', 'PayrollController');

	Route::post('attendance/deletebyselection', 'AttendanceController@deleteBySelection');
	Route::resource('attendance', 'AttendanceController');

	Route::resource('stock-count', 'StockCountController');
	Route::post('stock-count/finalize', 'StockCountController@finalize')->name('stock-count.finalize');
	Route::get('stock-count/stockdif/{id}', 'StockCountController@stockDif');
	Route::get('stock-count/{id}/qty_adjustment', 'StockCountController@qtyAdjustment')->name('stock-count.adjustment');

	Route::post('holidays/deletebyselection', 'HolidayController@deleteBySelection');
	Route::get('approve-holiday/{id}', 'HolidayController@approveHoliday')->name('approveHoliday');
	Route::get('holidays/my-holiday/{year}/{month}', 'HolidayController@myHoliday')->name('myHoliday');
	Route::resource('holidays', 'HolidayController');

	Route::get('cash-register', 'CashRegisterController@index')->name('cashRegister.index');
	Route::get('cash-register/check-availability/{warehouse_id}', 'CashRegisterController@checkAvailability')->name('cashRegister.checkAvailability');
	Route::post('cash-register/store', 'CashRegisterController@store')->name('cashRegister.store');
	Route::get('cash-register/getDetails/{id}', 'CashRegisterController@getDetails');
	Route::get('cash-register/showDetails/{warehouse_id}', 'CashRegisterController@showDetails');
	Route::post('cash-register/close', 'CashRegisterController@close')->name('cashRegister.close');

	Route::post('notifications/store', 'NotificationController@store')->name('notifications.store');
	Route::get('notifications/mark-as-read', 'NotificationController@markAsRead');

	Route::resource('currency', 'CurrencyController');

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('my-transactions/{year}/{month}', 'HomeController@myTransaction');


    Route::resource('region', 'RegionController');
    Route::resource('station', 'StationController');
    Route::resource('donor', 'DonorController');
    Route::resource('assetCategory', 'AssetCategoryController');
    Route::resource('asset', 'AssetController');

    Route::get('/assets/dispose/form/{id}', 'AssetController@destroyAsset')->name('asset.dispose.form');
    Route::get('/assets/dispose/form/all', 'AssetController@destroyAssetAll')->name('asset.dispose.form.all');
    Route::post('/assets/dispose/update', 'AssetController@destroyAssetUpdate')->name('asset.dispose.update');
    Route::post('/assets/dispose', 'AssetController@destroyAssetData')->name('asset.dispose');
    Route::get('/assets/dispose/edit/{id}', 'AssetController@destroyAssetEdit')->name('asset.dispose.edit');
    Route::get('/assets/dispose/list', 'AssetController@destroyAssetList')->name('asset.dispose.list');

    Route::get('/assets/transfer/list', 'AssetController@transferAssetList')->name('asset.transfer.list');
    Route::get('/assets/transfer/search/{id}', 'AssetController@transferAssetSearch')->name('asset.transfer.search');
    Route::get('/assets/transfer/form/single/{id}', 'AssetController@transferAsset')->name('asset.transfer.form');
    Route::get('/assets/transfer/letter/{id}', 'AssetController@transferLetterAsset')->name('asset.transfer.letter');
    Route::get('/assets/transfer/form/all', 'AssetController@transferAssetAll')->name('asset.transfer.all');
    Route::get('/assets/transfer/edit/{id}', 'AssetController@transferAssetEdit')->name('asset.transfer.edit');
    Route::post('/assets/transfer/update', 'AssetController@transferAssetUpdate')->name('asset.transfer.update');
    Route::post('/assets/transfer', 'AssetController@transferAssetData')->name('asset.transfer');

    Route::get('/assets/sale/list', 'AssetController@saleAssetList')->name('asset.sale.list');
    Route::get('/assets/sale/search/{id}', 'AssetController@saleAssetSearch')->name('asset.sale.search');
    Route::get('/assets/sale/form/single/{id}', 'AssetController@saleAsset')->name('asset.sale.form');
    Route::get('/assets/sale/letter/{id}', 'AssetController@saleLetterAsset')->name('asset.sale.letter');
    Route::get('/assets/sale/form/all', 'AssetController@saleAssetAll')->name('asset.sale.all');
    Route::post('/assets/sale', 'AssetController@saleAssetData')->name('asset.sale');
    Route::post('/assets/sale/update', 'AssetController@saleAssetDataUpdate')->name('asset.sale.update');
    Route::get('/assets/sale/show/{id}', 'AssetController@saleAssetShow')->name('asset.sale.show');
    Route::get('/assets/sale/edit/{id}', 'AssetController@saleAssetEdit')->name('asset.sale.edit');

    Route::get('/asset/images/delete/{id}', 'AssetController@AssetImageDelete')->name('asset.image.delete');
    Route::get('/asset/department/{id}', 'AssetController@DepartmentSearch')->name('asset.department.search');
    Route::get('asset/category/dashboard', 'AssetController@Dashboard')->name('asset.dashboard');
    Route::get('asset.dashboard.category/{id}', 'AssetController@DashboardCategory')->name('asset.dashboard.category');
    Route::get('asset/report/dashboard', 'AssetController@Report')->name('asset.report.dashboard');
    Route::get('asset/report/category', 'AssetController@Category')->name('asset.report.category');
    Route::get('asset/report/department', 'AssetController@Department')->name('asset.report.department');
    Route::get('asset/report/donor', 'AssetController@Donor')->name('asset.report.donor');
    Route::get('asset/report/region', 'AssetController@Region')->name('asset.report.region');
    Route::get('asset/report/station', 'AssetController@Station')->name('asset.report.station');
    Route::post('asset/report/category', 'AssetController@CategoryData')->name('asset.report.category');
    Route::post('asset/report/department', 'AssetController@DepartmentData')->name('asset.report.department');
    Route::post('asset/report/donor', 'AssetController@DonorData')->name('asset.report.donor');
    Route::post('asset/report/region', 'AssetController@RegionData')->name('asset.report.region');
    Route::post('asset/report/station', 'AssetController@StationData')->name('asset.report.station');
    Route::get('asset/report/expense', 'AssetController@expenseReport')->name('asset.report.expense');
    Route::post('asset/report/expense', 'AssetController@ExpenseData')->name('asset.report.expense');
    Route::get('asset/report/photocopy', 'AssetController@photocopy')->name('asset.report.photocopy');
    Route::post('asset/report/photocopy', 'AssetController@photocopyData')->name('asset.report.photocopy');
    Route::get('asset/report/repair', 'AssetController@repair')->name('asset.report.repair');
    Route::post('asset/report/repair', 'AssetController@repairData')->name('asset.report.repair');
    Route::get('asset/report/general', 'AssetController@general')->name('asset.report.general');
    Route::post('asset/report/general', 'AssetController@generalData')->name('asset.report.general');
    Route::get('asset/report/dispose', 'AssetController@dispose')->name('asset.report.dispose');
    Route::post('asset/report/dispose', 'AssetController@disposeData')->name('asset.report.dispose');
    Route::get('asset/report/transfer', 'AssetController@transfer')->name('asset.report.transfer');
    Route::post('asset/report/transfer', 'AssetController@transferData')->name('asset.report.transfer');

    Route::get('/bookings/create', 'BookingController@create')->name('booking.create');
    Route::post('/bookings/store', 'BookingController@store')->name('booking.store');
    Route::DELETE('/bookings/destroy/{id}', 'BookingController@destroy')->name('booking.destroy');
    Route::get('/bookings/{id}/edit', 'BookingController@edit')->name('booking.edit');
    Route::PUT('/bookings/update/{id}', 'BookingController@update')->name('booking.update');

    Route::get('bookings/category/associate', 'BookingController@addCategoryIdInSale');
    Route::get('bookings/index', 'BookingController@index')->name('booking.index');
    Route::get('bookings/gen_invoice/{id}', 'BookingController@genInvoice')->name('booking.invoice');
    Route::get('bookings/returns/{id}', 'BookingController@return')->name('booking.return');
    Route::post('/bookings/return/data/{id}', 'BookingController@returnData')->name('booking.return.data');
    Route::get('bookings/products', 'BookingController@bookedproducts')->name('booking.product');
    Route::post('/bookings/product/report', 'BookingController@bookedproductsReport')->name('booking.product.report');

    Route::post('bookings/add_payment', 'BookingController@addPayment')->name('booking.add-payment');
    Route::get('/bookings/getpayment/{id}', 'BookingController@getPayment')->name('booking.get-payment');
    Route::post('/bookings/updatepayment', 'BookingController@updatePayment')->name('booking.update-payment');
    Route::post('/bookings/deletepayment', 'BookingController@deletePayment')->name('booking.delete-payment');
    Route::post('bookings/sale-data', 'BookingController@saleData');
    Route::post('bookings/sendmail', 'BookingController@sendMail')->name('booking.sendmail');
    Route::get('bookings/product_sale/{id}','BookingController@productSaleData');
    Route::get('bookings/lims_sale_search', 'BookingController@limsSaleSearch')->name('sale.search');
    Route::get('bookings/lims_product_search', 'BookingController@limsProductSearch')->name('product_sale.search');
    Route::get('bookings/getcustomergroup/{id}', 'BookingController@getCustomerGroup')->name('sale.getcustomergroup');
    Route::get('bookings/getproduct/{id}', 'BookingController@getProduct')->name('sale.getproduct');
    Route::get('bookings/get-batch-products/{id}', 'BookingController@getBatchProduct')->name('sale.getBatchProducts');
    Route::get('bookings/getproduct/{category_id}/{brand_id}', 'BookingController@getProductByFilter');
    Route::get('bookings/lims_product_search_by_duration/', 'BookingController@getProductPriceByDuration')->name('booking.search_by_duration');
    Route::get('bookings/lims_product_search_qty_by_duration/', 'BookingController@getProductQtyByDuration')->name('booking.search_qty_by_duration');

    Route::get('report/daily_booking/{year}/{month}', 'ReportController@dailyBooking');
    Route::post('report/daily_booking/{year}/{month}', 'ReportController@dailyBookingByWarehouse')->name('report.dailyBookingByWarehouse');


});

