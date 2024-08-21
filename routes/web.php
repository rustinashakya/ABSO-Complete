<?php

use App\Http\Controllers\Admin\ApplicantCommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\StaticpagesController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\FunController;
use App\Http\Controllers\Admin\InvestmentController;
use App\Http\Controllers\Admin\InvestmentLanguageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsLanguageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectLanguageController;
use App\Http\Controllers\Admin\ProjectTypeController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\CampaignLanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\FutureVacancyController;
use App\Http\Controllers\LanguagePageController;
use App\Http\Controllers\PasswordReset;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\VacancyPostionController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', function () {
    return redirect(route('home'));
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return redirect(route('home'));
});
// frontend route
require __DIR__ . '/frontend.php';

Route::get('admin/web-login', function () {
    return view('auth.login');
})->name('admin.login');

Route::get('/reset_password/{token}/{email}', [PasswordReset::class, 'reset_password'])->name('reset_password.reset');
Route::post('/resetpassword/{id}', [PasswordReset::class, 'reset_password_post'])->name('reset_password_post');
Route::get('/success', [PasswordReset::class, 'success'])->name('reset_password.success');

/*admin route */
require __DIR__ . '/auth.php';

//change password
Route::get('/change/password', [UserController::class, 'changePassword'])->name('change.password');
Route::post('/update/password', [UserController::class, 'updateChangePassword'])->name('update.password');

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    //Route for static pages
    Route::prefix('static/page')->as('static.pages.')->controller(StaticpagesController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'add')->name('add');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{static_id}', 'edit')->name('edit');
        Route::put('/update/{static_id}', 'update')->name('update');
        Route::delete('/delete/{static_id}', 'delete')->name('delete');
    });

    //Route for designation
    Route::prefix('designation')->as('designation.')->controller(DesignationController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
    });

    //Route for Teams
    Route::prefix('team')->as('teams.')->controller(TeamController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    //sector
    Route::prefix('sector')->as('sectors.')->controller(SectorController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    //service
    Route::prefix('service')->as('services.')->controller(ServiceController::class)->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    //site Setting
    Route::namespace('App\Http\Controllers\Admin')
        ->group(function () {
            Route::resource('roles', 'RoleController');
            Route::resource('permissions', 'PermissionController');
            Route::resource('users', 'UserController');
        });

    Route::controller(SiteSettingController::class)->group(function () {
        Route::get('/site-setting/{id}', 'edit')->name('site.setting.edit');
        Route::post('/site-setting-update/{id}', 'update')->name('site.setting.update');
    });

    Route::prefix('slider')->as('slider.')->controller(SliderController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'add')->name('add');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });



    //Route for contacts
    Route::prefix('contact')->as('contact.')->controller(ContactUsController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/view/{id}', 'view')->name('view');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/export', 'export')->name('export');
    });

    Route::prefix('client')->as('client.')->controller(ClientController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('fun')->as('fun.')->controller(FunController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
});

Route::get('/export/newsletters', [NewsletterController::class, 'exportNewsLetters'])->name('export.newsletters');

require __DIR__ . '/front_auth.php';



//404 page

Route::get('/{any}', [FrontendController::class, 'error'])->where('any', '.*')->name('404');
