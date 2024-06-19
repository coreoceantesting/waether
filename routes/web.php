<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreWeatherController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PollutionLocationController;
use App\Http\Controllers\Admin\PollutionAirQualityController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\ScriptController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('insert-dummy-data', [ScriptController::class, 'index']);

Route::get('/', [HomeController::class, 'home']);

Route::get('data', [StoreWeatherController::class, 'storeWeatherData']);
Route::get('filter', [WebsiteController::class, 'filter'])->name('filter');
Route::post('filter', [WebsiteController::class, 'getFilter']);
Route::get('weather-info/filter', [WebsiteController::class, 'filterWeatherInfo'])->name('filterweatherinfo');
Route::post('weather-info/filter', [WebsiteController::class, 'getFilterWeatherInfo']);
Route::get('hightide', [HomeController::class, 'hightide']);


// Route::get('contact',[WebsiteController::class, 'contact']);
// Route::post('contact',[WebsiteController::class, 'saveContact']);

Route::get('climatemonitring', [WebsiteController::class, 'climatemonitring']);

Route::get('pollution-update', [WebsiteController::class, 'pollutionUpdate']);
Route::get('pollution-update/chart', [WebsiteController::class, 'pollutionUpdateChart']);
Route::get('pollution-update/pie-chart', [WebsiteController::class, 'pollutionUpdatePieChart']);
Route::get('pollution-air-quality', [WebsiteController::class, 'pollutionAirQuality']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('admin/hightide/import', ImportController::class);
    Route::get('/setImport', 'ImportController@setImport');
    Route::post('/importRegister', 'ImportController@importRegister');
    Route::post('admin/hightide/import', [ImportController::class, 'importHighTide'])->name('importhightide');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/setting', [SettingController::class, 'list']);
    Route::post('/admin/setting', [SettingController::class, 'save']);
    Route::post('/admin/setting/dashboard-banner', [SettingController::class, 'saveDashboardBanner']);
    Route::get('/admin/pollution/location/list', [PollutionLocationController::class, 'list']);
    Route::get('/admin/pollution/location/add', [PollutionLocationController::class, 'add']);
    Route::post('/admin/pollution/location/store', [PollutionLocationController::class, 'store']);
    Route::get('/admin/pollution/location/edit/{id}', [PollutionLocationController::class, 'edit']);
    Route::post('/admin/pollution/location/update', [PollutionLocationController::class, 'update']);


    Route::get('/admin/pollution/location/{location}/air-quality/list', [PollutionAirQualityController::class, 'list']);
    Route::get('/admin/pollution/location/{location}/air-quality/add', [PollutionAirQualityController::class, 'add']);
    Route::post('/admin/pollution/location/air-quality/store', [PollutionAirQualityController::class, 'store']);
    Route::get('/admin/pollution/location/{location}/air-quality/edit/{id}', [PollutionAirQualityController::class, 'edit']);
    Route::post('/admin/pollution/location/air-quality/update', [PollutionAirQualityController::class, 'update']);
    Route::post('/admin/pollution/location/air-quality/import', [PollutionAirQualityController::class, 'import']);
    Route::post('/admin/pollution/location/air-quality/delete', [PollutionAirQualityController::class, 'delete']);

    Route::get('/admin/device/list', [DeviceController::class, 'list']);
    Route::get('/admin/device/add', [DeviceController::class, 'add']);
    Route::post('/admin/device/store', [DeviceController::class, 'store']);
    Route::get('/admin/device/edit/{id}', [DeviceController::class, 'edit']);
    Route::post('/admin/device/update', [DeviceController::class, 'update']);

    Route::get('/admin/hightide/edit/{id}', [DashboardController::class, 'edit']);
    Route::post('/admin/hightide/update', [DashboardController::class, 'update']);
    Route::post('/admin/hightide/delete', [DashboardController::class, 'delete']);

    // Route::get('/admin/contact/list', [ContactController::class, 'list']);
    // Route::post('/admin/contact/delete', [ContactController::class, 'delete']);
    // Route::get('/admin/contact/send-message', [ContactController::class, 'sendMessage']);
    // Route::post('/admin/contact/send-message', [ContactController::class, 'sendContactMessage']);
});
