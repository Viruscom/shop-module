<?php

use App\Http\Controllers\AdminControllers\AdBoxesProductsController;
use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\admin\ShopSettingsController;
use Modules\Shop\Http\Controllers\BasketController;
use Modules\Shop\Http\Controllers\CartController;
use Modules\Shop\Http\Controllers\CityZipCodesController;
use Modules\Shop\Http\Controllers\DeliveriesController;
use Modules\Shop\Http\Controllers\PaymentsController;
use Modules\Shop\Http\Controllers\ProductsController;
use Modules\Shop\Http\Controllers\VatsController;

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

/*
 * ADMIN ROUTES
 */
Route::group(['prefix' => 'admin/shop', 'middleware' => ['auth']], static function () {
    /* Product Adboxes */
    Route::group(['prefix' => 'product_adboxes'], static function () {
        Route::get('/', [AdBoxesProductsController::class, 'index'])->name('admin.product-adboxes.index');
        //        Route::get('/create', [CategoryPageController::class, 'create'])->name('admin.category-page.create');
        //        Route::post('/store', [CategoryPageController::class, 'store'])->name('admin.category-page.store');

        Route::group(['prefix' => 'multiple'], static function () {
            Route::get('active/{active}', [AdBoxesProductsController::class, 'activeMultiple'])->name('admin.product-adboxes.active-multiple');
            Route::get('delete', [AdBoxesProductsController::class, 'deleteMultiple'])->name('admin.product-adboxes.delete-multiple');
        });

        Route::group(['prefix' => '{id}'], static function () {
            Route::get('edit', [AdBoxesProductsController::class, 'edit'])->name('admin.product-adboxes.edit');
            Route::post('update', [AdBoxesProductsController::class, 'update'])->name('admin.product-adboxes.update');
            Route::get('delete', [AdBoxesProductsController::class, 'delete'])->name('admin.product-adboxes.delete');
            Route::get('show', [AdBoxesProductsController::class, 'show'])->name('admin.product-adboxes.show');
            Route::get('active/{active}', [AdBoxesProductsController::class, 'active'])->name('admin.product-adboxes.changeStatus');
            Route::get('position/up', [AdBoxesProductsController::class, 'positionUp'])->name('admin.product-adboxes.position-up');
            Route::get('position/down', [AdBoxesProductsController::class, 'positionDown'])->name('admin.product-adboxes.position-down');
            Route::get('return_to_waiting', [AdBoxesProductsController::class, 'returnToWaiting'])->name('admin.product-adboxes.return-to-waiting');
        });
    });

    Route::group(['prefix' => 'settings'], static function () {
        Route::get('/', [ShopSettingsController::class, 'index'])->name('shop.settings.index');
        Route::prefix('payments')->group(function () {
            Route::get('/', [PaymentsController::class, 'index'])->name('payments.index');
            Route::get('/edit/{id}', [PaymentsController::class, 'edit'])->name('payments.edit');
            Route::post('/update/{id}', [PaymentsController::class, 'update'])->name('payments.update');
            Route::get('/update/state/{id}/{active}', [PaymentsController::class, 'updateState'])->name('payments.update_state');
            Route::get('/update/position/{id}/{position}', [PaymentsController::class, 'updatePosition'])->name('payments.update_option');
        });

        Route::prefix('deliveries')->group(function () {
            Route::get('/', [DeliveriesController::class, 'index'])->name('deliveries.index');
            Route::get('/edit/{id}', [DeliveriesController::class, 'edit'])->name('deliveries.edit');
            Route::post('/update/{id}', [DeliveriesController::class, 'update'])->name('deliveries.update');
            Route::get('/update/state/{id}/{active}', [DeliveriesController::class, 'updateState'])->name('deliveries.update_state');
            Route::get('/update/position/{id}/{position}', [DeliveriesController::class, 'updatePosition'])->name('deliveries.update_option');
        });

        Route::prefix('zipcodes')->group(function () {
            Route::get('/', [CityZipCodesController::class, 'index'])->name('zip_codes.index');
            Route::get('/edit/{id}', [CityZipCodesController::class, 'edit'])->name('zip_codes.edit');
            Route::post('/update/{id}', [CityZipCodesController::class, 'update'])->name('zip_codes.update');
        });

        Route::prefix('vats')->group(function () {
            Route::prefix('countries')->group(function () {
                Route::get('/', [VatsController::class, 'index'])->name('vats.countries.index');
                Route::get('/edit/{id}', [VatsController::class, 'edit'])->name('vats.countries.edit');
                Route::post('/update/{id}', [VatsController::class, 'update'])->name('vats.countries.update');

                Route::prefix('states')->group(function () {
                    Route::get('{id}/', [VatsController::class, 'states'])->name('vats.countries.states.index');
                    Route::get('/edit/{id}', [VatsController::class, 'statesEdit'])->name('vats.countries.states.edit');
                    Route::post('/update/{id}', [VatsController::class, 'statesUpdate'])->name('vats.countries.states.update');

                    Route::prefix('cities')->group(function () {
                        Route::get('{id}/', [VatsController::class, 'cities'])->name('vats.countries.states.cities.index');
                        Route::get('/edit/{id}', [VatsController::class, 'citiesEdit'])->name('vats.countries.states.cities.edit');
                        Route::post('/update/{id}', [VatsController::class, 'citiesUpdate'])->name('vats.countries.states.cities.update');
                    });
                });
            });

            Route::prefix('categories')->group(function () {
                Route::prefix('countries')->group(function () {
                    Route::get('{id}/', [VatsController::class, 'categories'])->name('vats.countries.categories.index');
                    Route::get('{id}/create', [VatsController::class, 'categoriesCreate'])->name('vats.countries.categories.create');
                    Route::post('{id}/store', [VatsController::class, 'categoriesStore'])->name('vats.countries.categories.store');
                    Route::get('/edit/{id}', [VatsController::class, 'categoriesEdit'])->name('vats.countries.categories.edit');
                    Route::post('/update/{id}', [VatsController::class, 'categoriesUpdate'])->name('vats.countries.categories.update');
                    Route::get('/delete/{id}', [VatsController::class, 'categoriesDestroy'])->name('vats.countries.categories.delete');

                    Route::prefix('states')->group(function () {
                        Route::get('{id}/', [VatsController::class, 'statesCategories'])->name('vats.countries.states.categories.index');
                        Route::get('{id}/create', [VatsController::class, 'statesCategoriesCreate'])->name('vats.countries.states.categories.create');
                        Route::post('{id}/store', [VatsController::class, 'statesCategoriesStore'])->name('vats.countries.states.categories.store');
                        Route::get('/edit/{id}', [VatsController::class, 'statesCategoriesEdit'])->name('vats.countries.states.categories.edit');
                        Route::post('/update/{id}', [VatsController::class, 'statesCategoriesUpdate'])->name('vats.countries.states.categories.update');
                        Route::get('/delete/{id}', [VatsController::class, 'statesCategoriesDestroy'])->name('vats.countries.states.categories.delete');

                        Route::prefix('cities')->group(function () {
                            Route::get('{id}/', [VatsController::class, 'citiesCategories'])->name('vats.countries.states.cities.categories.index');
                            Route::get('{id}/create', [VatsController::class, 'citiesCategoriesCreate'])->name('vats.countries.states.cities.categories.create');
                            Route::post('{id}/store', [VatsController::class, 'citiesCategoriesStore'])->name('vats.countries.states.cities.categories.store');
                            Route::get('/edit/{id}', [VatsController::class, 'citiesCategoriesEdit'])->name('vats.countries.states.cities.categories.edit');
                            Route::post('/update/{id}', [VatsController::class, 'citiesCategoriesUpdate'])->name('vats.countries.states.cities.categories.update');
                            Route::get('/delete/{id}', [VatsController::class, 'citiesCategoriesDestroy'])->name('vats.countries.states.cities.categories.delete');
                        });
                    });
                });
            });
        });
    });

    Route::get('/', 'ShopProductController@index');

    Route::post('/user/location', [App\Http\Controllers\HomeController::class, 'setUserLocation'])->name('user.location.set');

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    });
});

/*
 * FRONT ROUTES
 */

Route::prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'index'])->name('basket.index');
    Route::post('add', [BasketController::class, 'addProduct'])->name('basket.products.add');

    /* Order */
    Route::group(['prefix' => 'order'], static function () {
        Route::get('preview/{id}', [BasketController::class, 'previewOrder'])->name('basket.order.preview');
        Route::get('create', [BasketController::class, 'createOrder'])->name('basket.order.create');
        Route::post('store', [BasketController::class, 'storeOrder'])->name('basket.order.store');
    });
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
});

/* Shop Auth */
Route::group(['prefix' => 'shop'], static function () {
    // Authentication Routes
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('shop.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('shop.logout');

    // Registration Routes
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('shop.register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('shop.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('shop.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('shop.password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('shop.password.update');

    // Account Verification Routes
    Route::get('email/verify', 'Auth\VerificationController@show')->name('shop.verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('shop.verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('shop.verification.resend');
});

