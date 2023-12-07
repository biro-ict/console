<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//auth
Route::post('/login', 'App\Http\Controllers\Auth\authController@authUsers');
Route::post('/access', 'App\Http\Controllers\Auth\authController@accessUsers');
Route::post('/detils', 'App\Http\Controllers\Auth\authController@detailUsers');
Route::post('/access_user', 'App\Http\Controllers\Auth\authController@showAppsUser');
Route::get('/defaultapps', 'App\Http\Controllers\Auth\authController@showDefaultApps');


//users
Route::post('/users/dashboard', 'App\Http\Controllers\Users\usersController@dashboardUsers');

//HRD
//Employee
Route::get('/empl/all', 'App\Http\Controllers\employeeController@seeEmployee');
Route::get('/empl/{id}', 'App\Http\Controllers\employeeController@seeEmplById');
Route::get('/empl/usrnm/{username}', 'App\Http\Controllers\employeeController@seeEmplByUsrnm');
Route::get('/app/empl/access', 'App\Http\Controllers\employeeController@seeEmplAccess');
Route::post('/users/search', 'App\Http\Controllers\employeeController@searchEmpl');
Route::post('/empl/add', 'App\Http\Controllers\employeeController@addEmpl');
Route::post('/empl/update', 'App\Http\Controllers\employeeController@updateEmpl');
Route::post('/empl/delete', 'App\Http\Controllers\employeeController@deleteEmpl');

//Organizations
Route::get('/orgz/all', 'App\Http\Controllers\organizationsController@seeOrgz');
Route::get('/orgz/{id}', 'App\Http\Controllers\organizationsController@seeOrgzById');
Route::post('/org/search', 'App\Http\Controllers\organizationsController@searchOrgz');
Route::post('/org/add', 'App\Http\Controllers\organizationsController@addOrgz');
Route::post('/org/update', 'App\Http\Controllers\organizationsController@updateOrgz');
Route::post('/org/delete', 'App\Http\Controllers\organizationsController@deleteOrgz');

//Directory
Route::get('/dirs/all', 'App\Http\Controllers\directoryController@seeDirectory');
Route::get('/dirs/{id}', 'App\Http\Controllers\directoryController@seeDirById');
Route::post('/dir/search', 'App\Http\Controllers\directoryController@searchDir');
Route::post('/dir/add', 'App\Http\Controllers\directoryController@addDir');
Route::post('/dir/update', 'App\Http\Controllers\directoryController@updateDir');
Route::post('/dir/delete', 'App\Http\Controllers\directoryController@deleteDir');

//Division
Route::get('/division/all', 'App\Http\Controllers\divisionController@seeDivision');
Route::post('/division/search', 'App\Http\Controllers\divisionController@searchDivision');
Route::get('/division/{id}', 'App\Http\Controllers\divisionController@seeDivisionById');
Route::post('/division/add', 'App\Http\Controllers\divisionController@addDivision');
Route::post('/division/update', 'App\Http\Controllers\divisionController@updateDivision');
Route::post('/division/delete', 'App\Http\Controllers\divisionController@deleteDivision');

//branch
Route::get('/branches/all', 'App\Http\Controllers\branchController@seeBranch');
Route::get('/branches/{id}', 'App\Http\Controllers\branchController@seeBranchById');
Route::post('/branch/search', 'App\Http\Controllers\branchController@searchBranch');
Route::post('/branch/add','App\Http\Controllers\branchController@addBranch');
Route::post('/branch/update', 'App\Http\Controllers\branchController@updateBranch');
Route::post('/branch/delete', 'App\Http\Controllers\branchController@deleteBranch');

//Depts
Route::get('/depts/all', 'App\Http\Controllers\departmentsController@seeDepts');
Route::get('/depts/{id}', 'App\Http\Controllers\departmentsController@seeDeptById');
Route::post('/depts/search', 'App\Http\Controllers\departmentsController@searchDepts');
Route::post('/depts/add', 'App\Http\Controllers\departmentsController@addDepts');
Route::post('/depts/update', 'App\Http\Controllers\departmentsController@updateDepts');
Route::post('/depts/delete', 'App\Http\Controllers\departmentsController@deleteDepts');


//grade
Route::get('/grade/all', 'App\Http\Controllers\gradeController@seeGrade');
Route::get('/grade/{id}', 'App\Http\Controllers\gradeController@seeById');
Route::post('/grade/search', 'App\Http\Controllers\gradeController@searchDepts');
Route::post('/grade/add', 'App\Http\Controllers\gradeController@addGrade');
Route::post('/grade/update', 'App\Http\Controllers\gradeController@updateGrade');
Route::post('/grade/delete', 'App\Http\Controllers\gradeController@deleteGrade');

// employee status
//status
Route::get('/status/all', 'App\Http\Controllers\statusController@seeStatus');
Route::get('/status/{id}', 'App\Http\Controllers\statusController@seeById');
Route::post('/status/search', 'App\Http\Controllers\statusController@searchDepts');
Route::post('/status/add', 'App\Http\Controllers\statusController@addStatus');
Route::post('/status/update', 'App\Http\Controllers\statusController@updateStatus');
Route::post('/status/delete', 'App\Http\Controllers\statusController@deleteStatus');


//ICT
//Apps
Route::get('/apps/all', 'App\Http\Controllers\applicationController@seeApps');
Route::get('/apps/details/all', 'App\Http\Controllers\applicationController@seeDetailsApps');
Route::get('/apps/{id}', 'App\Http\Controllers\applicationController@seeAppsById');
Route::post('/apps/add', 'App\Http\Controllers\applicationController@addApps');
Route::post('/apps/update', 'App\Http\Controllers\applicationController@updateApps');
Route::post('/apps/delete', 'App\Http\Controllers\applicationController@deleteApps');

//akses apps by apps or user
Route::get('/app/access', 'App\Http\Controllers\applicationController@seeAppsAccess');
Route::post('/app/accessbyapp', 'App\Http\Controllers\applicationController@seeUserByApps');
Route::post('/app/addaccess', 'App\Http\Controllers\applicationController@addAccessApp');
Route::post('/app/deleteaccess', 'App\Http\Controllers\applicationController@delAccessApp');

//Status Apps
Route::get('/status_app/all', 'App\Http\Controllers\applicationController@seeStatusApps');
Route::get('/status_apps/{id}', 'App\Http\Controllers\applicationController@seeStatusAppsById');
Route::post('/status_apps/add', 'App\Http\Controllers\applicationController@addStatusApps');
Route::post('/status_apps/update', 'App\Http\Controllers\applicationController@updateStatusApps');
Route::post('/status_apps/delete', 'App\Http\Controllers\applicationController@deleteStatusApps');

//login level
Route::get('/login_level/all', 'App\Http\Controllers\applicationController@seeLoginLevel');


//Visitor
Route::post('/visitor/all', 'App\Http\Controllers\visitorController@seeVisitor');
Route::get('/visitor/{id}', 'App\Http\Controllers\visitorController@seeVisitorById');
Route::post('/visitor/add', 'App\Http\Controllers\visitorController@addVisitor');
Route::post('/visitor/update', 'App\Http\Controllers\visitorController@updateVisitor');
Route::post('/visitor/delete', 'App\Http\Controllers\visitorController@delVisitor');

//mac 
Route::post('/mac/search', 'App\Http\Controllers\macradiusController@searchMacaddr');
Route::get('/mac/{mac}', 'App\Http\Controllers\macradiusController@seeMacaddrById');
Route::post('/mac/add', 'App\Http\Controllers\macradiusController@addMacaddr');
Route::post('/mac/update', 'App\Http\Controllers\macradiusController@updateMacaddr');
Route::post('/mac/delete', 'App\Http\Controllers\macradiusController@deleteMacaddr');

//Licenses User
Route::get('/licenses', 'App\Http\Controllers\licensesController@seeLicenses');
Route::get('/license/{id}', 'App\Http\Controllers\licensesController@seeLicensesById');
Route::get('/licenses/{username}', 'App\Http\Controllers\licensesController@seeLicensesByUser');
Route::post('/licenses/add', 'App\Http\Controllers\licensesController@addLicenses');
Route::post('/licenses/update', 'App\Http\Controllers\licensesController@updateLicenses');
Route::post('/licenses/delete', 'App\Http\Controllers\licensesController@deleteLicenses');

//Corus
Route::get('/configurasi', 'App\Http\Controllers\ICT\corusController@seeConfigurasi');
Route::get('/corus/costumer', 'App\Http\Controllers\ICT\corusController@seeCustomer');
Route::get('/corus/{id}', 'App\Http\Controllers\ICT\corusController@seeOldNumber');
Route::post('/corus/update', 'App\Http\Controllers\ICT\corusController@updateCorus');
Route::get('/checkcorus', 'App\Http\Controllers\ICT\corusController@checkCorus');

//Keuangan
//datasource
Route::post('/datasource', 'App\Http\Controllers\Finance\datasourceController@seeDataSource');
Route::get('/datasource/{id}', 'App\Http\Controllers\Finance\datasourceController@seeDataSourceById');
Route::post('/datasource/add', 'App\Http\Controllers\Finance\datasourceController@addDataSource');
Route::post('/datasource/update', 'App\Http\Controllers\Finance\datasourceController@updateDataSource');
Route::post('/datasource/delete', 'App\Http\Controllers\Finance\datasourceController@deleteDataSource');

//Penerima
Route::post('/penerima', 'App\Http\Controllers\Finance\penerimaController@seePenerima');
Route::get('/penerima/{id}', 'App\Http\Controllers\Finance\penerimaController@seePenerimaById');
Route::post('/penerima/delete', 'App\Http\Controllers\Finance\penerimaController@deletePenerima');
Route::post('/penerima/add', 'App\Http\Controllers\Finance\penerimaController@addPenerima');
Route::post('/penerima/update', 'App\Http\Controllers\Finance\penerimaController@editPenerima');

//Rekening
Route::post('/rekening', 'App\Http\Controllers\Finance\rekeningController@seeNoRek');
Route::get('/rekening/{id}', 'App\Http\Controllers\Finance\rekeningController@seeNoRekById');
Route::post('/rekening/add', 'App\Http\Controllers\Finance\rekeningController@addRekening');
Route::post('/rekening/update', 'App\Http\Controllers\Finance\rekeningController@updateRekening');
Route::post('/rekening/delete', 'App\Http\Controllers\Finance\rekeningController@deleteRekening');

//Bank
Route::post('/bank', 'App\Http\Controllers\Finance\rekeningController@seeBank');
Route::get('/bank/{id}', 'App\Http\Controllers\Finance\rekeningController@seeBankById');
Route::post('/bank/add', 'App\Http\Controllers\Finance\rekeningController@addBank');
Route::post('/bank/update', 'App\Http\Controllers\Finance\rekeningController@updateBank');
Route::post('/bank/delete', 'App\Http\Controllers\Finance\rekeningController@deleteBank');

//Curency
Route::post('/currency', 'App\Http\Controllers\Finance\rekeningController@seeCurrency');
Route::get('/currency/{id}', 'App\Http\Controllers\Finance\rekeningController@seeCurrencyById');
Route::post('/currency/add', 'App\Http\Controllers\Finance\rekeningController@addCurrency');
Route::post('/currency/update', 'App\Http\Controllers\Finance\rekeningController@updateCurrency');
Route::post('/currency/delete', 'App\Http\Controllers\Finance\rekeningController@deleteCurrency');

//Providers atau Produsen
Route::post('/providers', 'App\Http\Controllers\Finance\providersController@seeProviders');
Route::get('/provider/{id}', 'App\Http\Controllers\Finance\providersController@seeProvidersById');
Route::post('/provider/add', 'App\Http\Controllers\Finance\providersController@addProvider');
Route::post('/provider/update', 'App\Http\Controllers\Finance\providersController@updateProvider');
Route::post('/provider/delete', 'App\Http\Controllers\Finance\providersController@deleteProvider');


//Customer
Route::post('/customer', 'App\Http\Controllers\Finance\customerController@seeCustomer');

//Module Budget
Route::get('/budgets/area', 'App\Http\Controllers\Finance\budgetController@seeAreaFinance');
Route::get('/budgets/depts', 'App\Http\Controllers\Finance\budgetController@seeDeptFinance');
Route::get('/budgets/header', 'App\Http\Controllers\Finance\budgetController@seeBudgetHead');
Route::get('/budgets/years', 'App\Http\Controllers\Finance\budgetController@seeYearFinance');
Route::post('/budgets/detail', 'App\Http\Controllers\Finance\budgetController@seeDetaiBudget');
Route::post('/budgets/update', 'App\Http\Controllers\Finance\budgetController@updateBudget');


//Procurement
//warehouse
Route::post('/warehouse', 'App\Http\Controllers\Proc\warehouseController@seeWarehouse');
Route::get('/warehouse/{id}', 'App\Http\Controllers\Proc\warehouseController@seeWarehousebyId');
Route::get('/lastid_warehouse', 'App\Http\Controllers\Proc\warehouseController@seeLastId');
Route::post('/warehouse/add', 'App\Http\Controllers\Proc\warehouseController@addWarehouse');
Route::post('/warehouse/update', 'App\Http\Controllers\Proc\warehouseController@updateWarehouse');
Route::post('/warehouse/delete', 'App\Http\Controllers\Proc\warehouseController@deleteWarehouse');

//item measure
Route::post('/itemmeasure', 'App\Http\Controllers\Proc\itemmeasureController@seeItemmeasure');
Route::get('/itemmeasure/{id}', 'App\Http\Controllers\Proc\itemmeasureController@seeItemmeasureById');
Route::get('/lastid_itemmeasure', 'App\Http\Controllers\Proc\itemmeasureController@seeLastId');
Route::post('/itemmeasure/add', 'App\Http\Controllers\Proc\itemmeasureController@addItemmeasure');
Route::post('/itemmeasure/update', 'App\Http\Controllers\Proc\itemmeasureController@updateItemmeasure');
Route::post('/itemmeasure/delete', 'App\Http\Controllers\Proc\itemmeasureController@deleteItemmeasure');

//item type
Route::post('/itemtype', 'App\Http\Controllers\Proc\itemtypeController@seeItemtype');
Route::get('/itemtype/{id}', 'App\Http\Controllers\Proc\itemtypeController@seeItemtypeById');
Route::get('/lastid_itemtype', 'App\Http\Controllers\Proc\itemtypeController@seeLastId');
Route::post('/itemtype/add', 'App\Http\Controllers\Proc\itemtypeController@addItemtype');
Route::post('/itemtype/update', 'App\Http\Controllers\Proc\itemtypeController@updateItemType');
Route::post('/itemtype/delete', 'App\Http\Controllers\Proc\itemtypeController@deleteItemType');

//itemcategory
Route::post('/itemcategory', 'App\Http\Controllers\Proc\itemcategoryController@seeItemCategory');
Route::get('/itemcategory/{id}', 'App\Http\Controllers\Proc\itemcategoryController@seeItemCategoryById');
Route::get('/lastid_category', 'App\Http\Controllers\Proc\itemcategoryController@seeLastId');
Route::post('/itemcategory/add', 'App\Http\Controllers\Proc\itemcategoryController@addItemCategory');
Route::post('/itemcategory/update', 'App\Http\Controllers\Proc\itemcategoryController@updateItemCategory');
Route::post('/itemcategory/delete', 'App\Http\Controllers\Proc\itemcategoryController@deleteItemCategory');

//item
Route::post('/item', 'App\Http\Controllers\Proc\itemController@seeItems');
Route::get('/item/{id}', 'App\Http\Controllers\Proc\itemController@seeItemById');
Route::get('/lastid_item', 'App\Http\Controllers\Proc\itemController@seeLastId');
Route::post('/item/add', 'App\Http\Controllers\Proc\itemController@addItem');
Route::post('/item/update', 'App\Http\Controllers\Proc\itemController@updateItem');
Route::post('/item/delete', 'App\Http\Controllers\Proc\itemController@deleteItems');

//payment term
Route::post('/paymentterm', 'App\Http\Controllers\Proc\paymenttermController@seePaymentterm');
Route::get('/paymentterm/{id}', 'App\Http\Controllers\Proc\paymenttermController@seePaymenttermById');
Route::get('/lastid_paymentterm', 'App\Http\Controllers\Proc\paymenttermController@seeLastId');
Route::post('/paymentterm/add', 'App\Http\Controllers\Proc\paymenttermController@addPaymentterm');
Route::post('/paymentterm/update', 'App\Http\Controllers\Proc\paymenttermController@updatePaymentterm');
Route::post('/paymentterm/delete', 'App\Http\Controllers\Proc\paymenttermController@deletePaymentterm');

//Group supplier
Route::post('/groupsupplier', 'App\Http\Controllers\Proc\groupsupplierController@seeGroupsupplier');
Route::get('/groupsupplier/{id}', 'App\Http\Controllers\Proc\groupsupplierController@seeGroupsupplierById');
Route::get('/lastid_groupsupplier', 'App\Http\Controllers\Proc\groupsupplierController@seeLastId');
Route::post('/groupsupplier/add', 'App\Http\Controllers\Proc\groupsupplierController@addGroupsupplier');
Route::post('/groupsupplier/update', 'App\Http\Controllers\Proc\groupsupplierController@updateGroupsupplier');
Route::post('/groupsupplier/delete', 'App\Http\Controllers\Proc\groupsupplierController@deleteGroupsupplier');

//Supplier
Route::get('/supplier', 'App\Http\Controllers\Proc\supplierController@seeSupplier');
Route::get('/supplier/{id}', 'App\Http\Controllers\Proc\supplierController@seeSupplierById');
Route::get('/supplierByGroup/{id}', 'App\Http\Controllers\Proc\supplierController@seeSupplierByGroup');
Route::get('/lastid_supplier', 'App\Http\Controllers\Proc\supplierController@seeLastId');
Route::post('/supplier/add', 'App\Http\Controllers\Proc\supplierController@addSupplier');
Route::post('/supplier/update', 'App\Http\Controllers\Proc\supplierController@updateSupplier');
Route::post('/supplier/delete', 'App\Http\Controllers\Proc\supplierController@deleteSupplier');


Route::post('/contactsupplier', 'App\Http\Controllers\Proc\contactsupplierController@showContact');
Route::post('/contactsupplier/update', 'App\Http\Controllers\Proc\contactsupplierController@updateContact');
Route::post('/contactsupplier/delete', 'App\Http\Controllers\Proc\contactsupplierController@deleteContact');