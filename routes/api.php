<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UpcomingAppointmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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


Route::group(['middleware' => 'auth:sanctum'], function () {

    /* Start of Essentials Routes */
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('conditions', ConditionController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::apiResource('settings', SettingController::class);
    Route::apiResource('sessions', SessionController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('upcomings', UpcomingAppointmentController::class);

    Route::apiResource('notifications', NotificationController::class);

    /*End of Essentials Routes */

    
    /*Start Additional Routes */
    Route::get('conditions/patient/{patient}/{type}', [ConditionController::class, 'patient']);
    Route::get('patients/by/{condition}', [PatientController::class, 'getPatientsByCondition']);

    //*Search Routes */
    Route::get('search/patients', [PatientController::class, 'search']);
    Route::get('search/conditions', [ConditionController::class, 'search']);
    Route::get('search/sessions', [SessionController::class, 'search']);


    Route::get('patient/{patient}/conditions/{condition}/{type}', [ConditionController::class, 'linkCondition']);
    Route::get('nextdates', [AppointmentController::class, 'calendar']);
    Route::post('nextdates/{appointment}', [AppointmentController::class, 'deleteDate']);
    Route::get('check/{patient}/{condition}', [AppointmentController::class, 'checkIfExists']);
    Route::get('patient/{patient}/detach/{condition}', [PatientController::class, 'detach']);

    //HomePage & Stats Routes //
    Route::get('generalData', [HomeController::class, 'generalData']);

    //Notifications Routes //
    Route::get('notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);

    /* End Additional Routes */
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('update/password', [UserController::class, 'updatePassword']); 
    Route::post('update/receptionist/password', [UserController::class, 'updateRecPassword']);    
   
    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});