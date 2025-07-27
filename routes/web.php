<?php

use App\Http\Controllers\StripeController;
use App\Livewire\Actions\Logout;
use App\Livewire\Admin\Amenity\AmenityComponent;
use App\Livewire\Admin\AmenityType\AmenityTypeComponent;
use App\Livewire\Admin\Area\AreaComponent;
use App\Livewire\Admin\Booking\ManageBookings;
use App\Livewire\Admin\BookingComponent;
use App\Livewire\Admin\BookingShowComponent;
use App\Livewire\Admin\City\CityComponent;
use App\Livewire\Admin\Country\CountryComponent;
use App\Livewire\Admin\Dashboard\DashboardComponent;
use App\Livewire\Admin\Maintain\MaintainComponent;
use App\Livewire\Admin\MaintainType\MaintainTypeComponent;
use App\Livewire\Admin\Package\CreatePackageComponent;
use App\Livewire\Admin\Package\EditPackageComponent;
use App\Livewire\Admin\Package\PackageComponent;
use App\Livewire\Admin\Package\ShowPackageComponent;
use App\Livewire\Admin\ProfileComponent;
use App\Livewire\Admin\Property\PropertyComponent;
use App\Livewire\Admin\PropertyType\PropertyTypeComponent;
use App\Livewire\Admin\Settings\FooterSection;
use App\Livewire\Admin\Settings\FooterSectionFourSettings;
use App\Livewire\Admin\Settings\FooterSectionThreeSettings;
use App\Livewire\Admin\Settings\FooterSectionTwoSettings;
use App\Livewire\Admin\Settings\FooterSettings;
use App\Livewire\Admin\Settings\HeaderSettings;
use App\Livewire\Admin\Settings\HeroSettings;
use App\Livewire\Admin\Settings\HomeDataSettings;
use App\Livewire\Admin\Settings\ParetnerTermsConditionSettings;
use App\Livewire\Admin\Settings\PrivacyPolicySettings;
use App\Livewire\Admin\Settings\TermsConditionSettings;
use App\Livewire\Admin\SettingsComponent;
use App\Livewire\Admin\User\ManageUserComponent;
use App\Livewire\Admin\UserViewComponent;
use App\Livewire\MultipleFormsComponent;
use App\Livewire\PaymentForm;
use App\Livewire\RP\PermissionManager;
use App\Livewire\RP\RoleManager;
use App\Livewire\RP\UserManager;
use App\Livewire\User\BookingComplete;
use App\Livewire\User\BookingList;
use App\Livewire\User\CheckoutComponent;
use App\Livewire\User\HomeComponent;
use App\Livewire\User\PackageList;
use App\Livewire\User\PackageShow;
use App\Livewire\User\PartnerTermsConditionComponent;
use App\Livewire\User\PrivacyPolicyComponent;
use App\Livewire\User\ShowBooking;
use App\Livewire\User\TermsConditionComponent;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


Route::get('/payment', PaymentForm::class);
Route::post('stripe', [StripeController::class, 'stripe'])->name('stripe');
Route::get('sucsess', [CheckoutComponent::class, 'sucsess'])->name('sucsess');
Route::get('cancel', [CheckoutComponent::class, 'cancel'])->name('cancel');

Route::get('/storage-link', function () {
    try {
        Artisan::call('storage:link');
        return "The [public/storage] directory has been linked.";
    } catch (\Exception $e) {
        return "There was an error: " . $e->getMessage();
    }
})->name('storage.link');

// Route::view('/', 'welcome');

Route::get('/', HomeComponent::class)->name('home');
Route::post('/logout', [Logout::class, 'logout'])->name('logout');


Route::get('/packages', PackageList::class)->name('package.list');
Route::get('booking-complete/{bookingId}', BookingComplete::class)->name('booking.complete');

Route::get('/package/{id}', PackageShow::class)->name('package.show');
Route::get('/seeder', function () {
    Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\RolesAndSuperAdminSeeder']);
    return 'Roles and Super Admin seeder ran successfully!';
});

Route::get('/migrate',function(){
    Artisan::call('migrate');
});


Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');

Route::get('/checkout/cancel', function () {
    return view('checkout.cancel');
})->name('checkout.cancel');
Route::get('/stripe/return', [StripeController::class, 'handleStripeReturn'])->name('stripe.return');

Route::get('/privacy-policy', PrivacyPolicyComponent::class)->name('privacy-policy');
Route::get('/terms-condition', TermsConditionComponent::class)->name('terms-condition');
Route::get('/partner-terms-condition', PartnerTermsConditionComponent::class)->name('partner-terms-condition');




Route::middleware(['auth'])->group(function () {

    Route::get('/roles', RoleManager::class)->name('roles');
    Route::get('/permissions', PermissionManager::class)->name('permissions');
    Route::get('/users', UserManager::class)->name('users');
    Route::get('/profile', ProfileComponent::class)->name('profile');

    Route::get('/admin/countries', CountryComponent::class)->name('countries')->middleware('can:package.setup');
    Route::get('/admin/cities', CityComponent::class)->name('cities')->middleware('can:package.setup');
    Route::get('/admin/areas', AreaComponent::class)->name('areas')->middleware('can:package.setup');
    Route::get('/admin/property-types', PropertyTypeComponent::class)->name('property-types')->middleware('can:package.setup');
    Route::get('/admin/properties', PropertyComponent::class)->name('properties')->middleware('can:package.setup');
    Route::get('/admin/maintain-type', MaintainTypeComponent::class)->name('maintain-type')->middleware('can:package.setup');
    Route::get('/admin/maintain', MaintainComponent::class)->name('maintain')->middleware('can:package.setup');
    Route::get('/admin/amenity-type', AmenityTypeComponent::class)->name('amenity-type')->middleware('can:package.setup');
    Route::get('/admin/amenities', AmenityComponent::class)->name('amenities')->middleware('can:package.setup');
    Route::get('/admin/packages', PackageComponent::class)->name('admin.packages');
    Route::get('/admin/packages/create', CreatePackageComponent::class)->name('admin.packages.create');
    Route::get('/admin/package/edit/{packageId}', EditPackageComponent::class)->name('admin.package.edit');
    Route::get('/packages/{packageId}/show', ShowPackageComponent::class)->name('packages.show');
    Route::get('/admin/bookings', ManageBookings::class)->name('admin.bookings');
    Route::get('/admin/users/manage', ManageUserComponent::class)->name('users.manage');
    Route::get('/admin/users/{userId}', UserViewComponent::class)->name('admin.users.view');

    Route::get('/admin', DashboardComponent::class)->name('dashboard')->middleware('can:dashboard');

    Route::get('/checkout', CheckoutComponent::class)->name('checkout');

    Route::get('/user/bookings', BookingList::class)->name('user.bookings.index');
    Route::get('/bookings/{id}', ShowBooking::class)->name('bookings.show');

    Route::get('admin/bookings', BookingComponent::class)->name('admin.bookings.index');
    Route::get('admin/bookings/{id}', BookingShowComponent::class)->name('admin.bookings.show');

    Route::get('/admin/settings', SettingsComponent::class)->name('site.settings');






    Route::get('/admin/logo', HeaderSettings::class)->name('logo');
    Route::get('/admin/hero-section', HeroSettings::class)->name('hero-section');
    Route::get('/admin/home-data', HomeDataSettings::class)->name('home-data');
    Route::get('/admin/privacy-policy', PrivacyPolicySettings::class)->name('admin.privacy-policy');
    Route::get('/admin/terms-condition', TermsConditionSettings::class)->name('admin-terms-condition');
    Route::get('/admin/partner-terms-condition', ParetnerTermsConditionSettings::class)->name('admin-partner-terms-condition');
    Route::get('/admin/footer-main', FooterSettings::class)->name('footer-main');
    Route::get('/admin/footer-two', FooterSectionTwoSettings::class)->name('footer-two');
    Route::get('/admin/footer-three', FooterSectionThreeSettings::class)->name('footer-three');
    Route::get('/admin/footer-four', FooterSectionFourSettings::class)->name('footer-four');

});

Route::get('/test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('designfic.com@gmail.com')
                ->subject('Test Email');
    });

    return 'Email sent successfully';
});

Route::get('/test', function () {
    return "You have permission to access this test content!";
})->middleware('can:create-post');
Route::get('/permissions-test', function () {
    return view('permissions-test');
})->middleware('auth');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboards');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__.'/auth.php';
