<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SyncAttendanceController;
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



Route::get('login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('admin');
});

Route::get('/info/{id?}', [ErrorController::class , 'error'])->name('errors');


Route::get('/attendance', [SyncAttendanceController::class, 'showAttendance']);
Route::get('/sync-attendance', [SyncAttendanceController::class, 'syncAttendance']);

Route::group(['prefix' => 'admin', 'middleware' => ['loggin', 'system']], function () {
    Voyager::routes();

    Route::get('people', [PersonController::class, 'index'])->name('voyager.people.index');
    Route::get('people/ajax/list', [PersonController::class, 'list']);


    Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('attendances/synchronize', [AttendanceController::class, 'synchronize'])->name('attendances.synchronize');
    Route::get('attendances/ajax/list/{search?}', [AttendanceController::class, 'list']);



    Route::get('users/ajax/list', [UserController::class, 'list']);
    Route::post('users/store', [UserController::class, 'store'])->name('voyager.users.store');
    Route::put('users/{id}', [UserController::class, 'update'])->name('voyager.users.update');
    Route::delete('users/{id}/deleted', [UserController::class, 'destroy'])->name('voyager.users.destroy');



    Route::get('ajax/personList', [AjaxController::class, 'personList']);
    Route::post('ajax/person/store', [AjaxController::class, 'personStore']);

});


// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');

    // Artisan::call('db:seed', ['--class' => 'UpdateBreadSeeder']);
    // Artisan::call('db:seed', ['--class' => 'UpdatePermissionsSeeder']);
    
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');