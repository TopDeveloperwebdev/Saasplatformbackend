<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('addUser', 'PagesController@addUser')->name('addUser');
Route::post('login', 'PagesController@login')->name('login');

// FamilyDirectors
Route::post('addFamilyDirectors', 'FamilyDirectorController@store')->name('addFamilyDirector');
Route::post('showFamilyDirectors', 'FamilyDirectorController@index')->name('showFamilyDirector');
Route::post('editFamilyDirectors', 'FamilyDirectorController@update')->name('editFamilyDirector');
Route::post('deleteFamilyDirectors', 'FamilyDirectorController@destroy')->name('deleteFamilyDirectors');

//  Patients
Route::post('addPharmacies', 'PharmaciesController@store')->name('addPharmacies');
Route::post('showPharmacies', 'PharmaciesController@index')->name('showPharmacies');
Route::post('editPharmacies', 'PharmaciesController@update')->name('editPharmacies');
Route::post('deletePharmacies', 'PharmaciesController@destroy')->name('deletePharmacies');

//  Patients
Route::post('addPatients', 'PatientsController@store')->name('addPatients');
Route::post('showPatients', 'PatientsController@index')->name('showPatients');
Route::post('editPatients', 'PatientsController@update')->name('editPatients');
Route::post('deletePatients', 'PatientsController@destroy')->name('deletePatients');

//  MedicationsController
Route::post('addMedications', 'MedicationsController@store')->name('addMedications');
Route::post('showMedications', 'MedicationsController@index')->name('showMedications');
Route::post('editMedications', 'MedicationsController@update')->name('editMedications');
Route::post('deleteMedications', 'MedicationsController@destroy')->name('deleteMedications');
Route::post('relationPatients', 'MedicationsController@relationPatients')->name('relationPatients');

//  ResourcesController
Route::post('addResources', 'ResourcesController@store')->name('addResources');
Route::post('showResources', 'ResourcesController@index')->name('showResources');
Route::post('editResources', 'ResourcesController@update')->name('editResources');
Route::post('deleteResources', 'ResourcesController@destroy')->name('deleteResources');

//  IngredientsController
Route::post('addIngredients', 'IngredientsController@store')->name('addIngredients');
Route::post('showIngredients', 'IngredientsController@index')->name('showIngredients');
Route::post('editIngredients', 'IngredientsController@update')->name('editIngredients');
Route::post('deleteIngredients', 'IngredientsController@destroy')->name('deleteIngredients');

//  InsuranceController
Route::post('addInsurances', 'InsuranceController@store')->name('addInsurances');
Route::post('showInsurances', 'InsuranceController@index')->name('showInsurances');
Route::post('editInsurances', 'InsuranceController@update')->name('editInsurances');
Route::post('deleteInsurances', 'InsuranceController@destroy')->name('deleteInsurances');



//  ServicesController
Route::post('addServices', 'ServicesController@store')->name('addServices');
Route::post('showServices', 'ServicesController@index')->name('showServices');
Route::post('editServices', 'ServicesController@update')->name('editServices');
Route::post('deleteServices', 'ServicesController@destroy')->name('deleteServices');

//  InstancesController
Route::post('addInstances', 'InstancesController@store')->name('addInstances');
Route::post('showInstances', 'InstancesController@index')->name('showInstances');
Route::post('editInstances', 'InstancesController@update')->name('editInstances');
Route::post('deleteInstances', 'InstancesController@destroy')->name('deleteInstances');

//  RolesController
Route::post('addRoles', 'RolesController@store')->name('addRoles');
Route::post('showRoles', 'RolesController@index')->name('showRoles');
Route::post('editRoles', 'RolesController@update')->name('editRoles');
Route::post('deleteRoles', 'RolesController@destroy')->name('deleteRoles');

//  PermissionsController
Route::post('addPermissions', 'PermissionsController@store')->name('addPermissions');
Route::post('showPermissions', 'PermissionsController@index')->name('showPermissions');
Route::post('editPermissions', 'PermissionsController@update')->name('editPermissions');
Route::post('deletePermissions', 'PermissionsController@destroy')->name('deletePermissions');

//  OrdersController
Route::post('addOrders', 'OrdersController@store')->name('addOrders');

Route::post('showOrders', 'OrdersController@index')->name('showOrders');
Route::post('getOrderDetail', 'OrdersController@getDetail')->name('getOrderDetail');
Route::post('editOrders', 'OrdersController@update')->name('editOrders');
Route::post('deleteOrders', 'OrdersController@destroy')->name('deleteOrders');
Route::post('submitComment', 'OrdersController@submit')->name('submitComment');

//  UsersController
Route::post('addUsers', 'PagesController@store')->name('addUsers');
Route::post('showUsers', 'PagesController@index')->name('showUsers');
Route::post('editUsers', 'PagesController@update')->name('editUsers');
Route::post('deleteUsers', 'PagesController@destroy')->name('deleteUsers');


//  FilesController
Route::post('addDocuments', 'FilesController@store')->name('addDocuments');
Route::post('showDocuments', 'FilesController@index')->name('showDocuments');
Route::post('editDocuments', 'FilesController@update')->name('editDocuments');
Route::post('deleteDocuments', 'FilesController@destroy')->name('deleteDocuments');
Route::post('getDocuments', 'FilesController@getDocument')->name('getDocument');

Route::post('addFolders', 'FilesController@storeFolder')->name('addFolders');
Route::post('editFolders', 'FilesController@updateFolder')->name('editFolders');
Route::post('showFolders', 'FilesController@indexFolder')->name('showFolders');
Route::post('deleteFolders', 'FilesController@destroyFolder')->name('deleteFolders');

Route::get('get_users', 'MessagesController@getUsers');
Route::get('get_messages', 'MessagesController@getMessages');
Route::post('notifications', 'MessagesController@sendMail');
// Route::get('categories/all', 'PagesController@apiShowCategories');
// Route::get('categories/premium', 'PagesController@apiShowCategoriesPremium');
// Route::get('categories/free', 'PagesController@apiShowCategoriesFree');

// Route::get('categories/{id}/all', 'PagesController@apiShowChildCategories');
// Route::get('categories/{id}/premium', 'PagesController@apiShowChildCategoriesPremium');
// Route::get('categories/{id}/free', 'PagesController@apiShowChildCategoriesFree');

// Route::get('category/{id}', 'PagesController@apiShowSingleCategory');
// Route::get('category/{id}/questions', 'PagesController@apiShowSingleCategoryQuestion');
// Route::get('questions', 'PagesController@apiShowQuestions');
// Route::get('question/{id}', 'PagesController@apiShowSingleQuestion');
// Route::get('tutorial', 'PagesController@apiShowTutorial');
// Route::post('user/{name}/{email}/{password}/{token}', 'PagesController@apiSignupUser');
// Route::post('getNotification', 'PagesController@getNotification')->name('getNotification');
// Route::post('forgotPassword', 'PagesController@forgotPassword')->name('forgotPassword');
