<?php

use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\AppointmentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QRScannerController;
use App\Http\Controllers\Api\GetController;
use App\Http\Controllers\Api\ContactApiController;
;
use App\Http\Controllers\Api\DonorController;
use App\Http\Controllers\Api\UserRegistration;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\FAQApiController;
use App\Http\Controllers\Api\HealthLibraryApiController;

;
use App\Http\Controllers\Api\khaltiController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\Membership;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\SponserApiController;
use App\Http\Controllers\Api\UserLogin;
use App\Http\Controllers\Api\TeamApiController;
use App\Http\Controllers\Api\TestimonialApiController;
use App\Http\Controllers\AppointmentPaymentController;
use App\Http\Controllers\DonationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1'
], function ($router) {
    Route::post('/store-forgot-password', [AuthController::class, 'forgetPassword'])
                ->middleware('guest')
                ->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'resetPasswordLoad'])
                ->middleware('guest')
                ->name('password.email.reset');
    Route::post('/reset-password-store', [AuthController::class, 'resetPasswordStore'])
                ->middleware('guest')
                ->name('password.email.reset.store');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/page/{slug}', [GetController::class, 'get_page_by_slug']);
    Route::get('/image', [GetController::class, 'slider_image']);
    Route::get('/site_setting', [GetController::class, 'site_setting']);
    Route::get('/category', [GetController::class, 'category']);
    Route::post('/contacts/store', [ContactApiController::class, 'store']);
    Route::get('/international_events', [GetController::class, 'international_events']);

    Route::get('/news', [GetController::class, 'news']);
    Route::get('/news/{slug}', [GetController::class, 'getNewsBySlug']);


    Route::post('/event_registration',[UserRegistration::class,'event_registration']);
    Route::post('/update_event_registration/{id}',[UserRegistration::class,'update_event_registration']);
    Route::get('/test_test',[UserRegistration::class,'test_test']);
    Route::get('/get_event_by_slug/{slug}', [EventApiController::class, 'get_event_by_slug']);
    Route::get('/check_email', [UserRegistration::class, 'check_email']);

    Route::get('/send_email_to_activate_user/{id}',[UserRegistration::class,'send_email_to_activate_user']);
    Route::get('/send_email_to_register_member/{id}',[Membership::class,'send_email_to_register_member']);

    Route::post('/membership_registration',[Membership::class,'membership_registration']);
    Route::get('/membership_detail/{id}',[Membership::class,'membership_detail']);
    Route::post('/update_membership_registration/{id}',[Membership::class,'update_membership_registration']);
    Route::get('/get_membership_duration',[Membership::class,'get_membership_duration']);

    Route::get('/get_payment_by_country_id/{id}',[UserLogin::class,'get_payment_by_country_id']);
    Route::post('/login_user',[UserLogin::class,'login_user']);

    Route::post('/khalti_initiate',[khaltiController::class,'initiate']);
    Route::post('/donation_payment_page/{id}',[DonorController::class,'redirect_payment_page']);
    Route::get('/donation_khalti_callback',[DonorController::class,'donation_khalti_callback']);

    //Teams API routes

    Route::get('/teams', [TeamApiController::class, 'index']);
    Route::get('/teams/{slug}', [TeamApiController::class, 'getTeamBySlug']);
    Route::post('/teams', [TeamApiController::class, 'store']);
    Route::put('/teams/{id}', [TeamApiController::class, 'update']);
    Route::delete('/teams/{id}', [TeamApiController::class, 'destroy']);

    //Service API routes

    Route::get('/services', [ServiceApiController::class, 'index']);
    Route::get('/services/{slug}', [ServiceApiController::class, 'getServicesBySlug']);
    Route::post('/services', [ServiceApiController::class, 'store']);
    Route::put('/services/{id}', [ServiceApiController::class, 'update']);
    Route::delete('/services/{id}', [ServiceApiController::class, 'destroy']);

    //Static page
    Route::get('/static-pages/{slug}', [GetController::class, 'getStaticPageBySlug']);

    //FAQ Api
    Route::get('/faq', [FAQApiController::class, 'getAllFaq']);

    //Testimonial Api
    Route::get('/testimonials', [TestimonialApiController::class, 'index']);

    //Health Library Api
    Route::get('/healthlibrary', [HealthLibraryApiController::class, 'index']);
    Route::get('/sendMail/{id}',[MailController::class,'sendMail']);

    //applicantion form
    // Route::post('applicant/store', [ApplicantController::class, 'store']);
    


});
// Route::get('/page', [PageController::class, 'get_by_slug']);

Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'v1'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('get_user', [AuthController::class, 'get_user']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/qr-code-scanner', [QRScannerController::class, 'scanQrCode']);

});
