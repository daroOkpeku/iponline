<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(PostController::class)->group(function(){
    Route::get("/", 'home')->name('home');
    Route::get("register", "register")->name('register');
    Route::get('/allorders', "allorders");
    Route::get('/paystack_verify/{ref}', "paystack_verify");
    Route::post('/register', 'registerx');
    Route::get('/signin', 'signin')->name('login');
    Route::post("/signin", 'signinx');
    Route::get("/adminlogin", "admin");
    Route::post("/admin", "adminx");
    Route::get("/checkemail/{name}/{email}", 'checkemail');
    Route::post("/muitplepayment", "muitplepayment");
    Route::get("/logout", "logout")->name('logout');


});


Route::group(['middleware' => 'admin',  'prefix' => 'admin'], function () {


        Route::get("/admindashbord", [PostController::class, "admindashbord"])->name('admindashbord');
        Route::get("/allpurchase/{page}", [PostController::class, "allpurchase"]);
        Route::get("/adminproducts", [PostController::class, "adminproducts"])->name('adminproducts');
        Route::get("allproduct/{page}", [PostController::class, "allproduct"]);
        Route::get("/searchproduct/{search}", [PostController::class, "searchproduct"]);
        Route::put("/updatestatus", [PostController::class, "updatestatus"]);
});


Route::group(['middleware' => 'auth'], function () {
// normally auth
});


