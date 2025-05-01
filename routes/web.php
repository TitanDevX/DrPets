<?php

use App\Http\Controllers\authentications\ForgotPassword;
use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\authentications\Register;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CanUseDashboardMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Main Page Route

Route::get('/',[DashboardController::class,'index']);
Route::get('/login')->name('login');
Route::get('/register')->name('register');
Route::get('/dashboard')->name('dashboard');
// Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
// // authentication
// Route::get('/auth/login', [Login::class, 'index'])->name('auth-login');
// Route::post('/auth/login', [Login::class, 'login'])->name('auth-login-login');
// Route::get('/auth/register', [Register::class, 'index'])->name('auth-register');
// Route::get('/auth/forgot-password', [ForgotPassword::class, 'index'])->name('auth-reset-password');


// Route::middleware(CanUseDashboardMiddleware::class)->group(function () {
 
// });
