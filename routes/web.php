<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Generic fallback dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Success page route
Route::get('/success', function () {
    return view('auth.success');
})->middleware(['auth'])->name('success');

// Role-based dashboards
Route::middleware(['auth'])->group(function () {

    // --- Admin section ---
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Users CRUD
Route::get('/users', [AdminController::class, 'users'])->name('users.index');
Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');   
Route::match(['put','patch'], '/users/{user}', [AdminController::class, 'updateUser'])->name('users.update'); 
Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');




        // Donations CRUD
        Route::get('/donations', [AdminController::class, 'donations'])->name('donations.index');
        Route::get('/donations/create', [AdminController::class, 'createDonation'])->name('donations.create');
        Route::post('/donations', [AdminController::class, 'storeDonation'])->name('donations.store');
        Route::get('/donations/{donation}/edit', [AdminController::class, 'editDonation'])->name('donations.edit');
        Route::match(['put', 'patch'], '/donations/{donation}', [AdminController::class, 'updateDonation'])->name('donations.update');
        Route::delete('/donations/{donation}', [AdminController::class, 'destroyDonation'])->name('donations.destroy');

        // Charities CRUD
Route::get('/charities', [AdminController::class, 'charities'])->name('charities.index');
Route::get('/charities/create', [AdminController::class, 'createCharity'])->name('charities.create');
Route::post('/charities', [AdminController::class, 'storeCharity'])->name('charities.store');
Route::get('/charities/{charity}/edit', [AdminController::class, 'editCharity'])->name('charities.edit');
Route::put('/charities/{charity}', [AdminController::class, 'updateCharity'])->name('charities.update');
Route::delete('/charities/{charity}', [AdminController::class, 'destroyCharity'])->name('charities.destroy');


        // Campaigns CRUD
        Route::get('/campaigns', [AdminController::class, 'campaigns'])->name('campaigns.index');
        Route::get('/campaigns/create', [AdminController::class, 'createCampaign'])->name('campaigns.create');
        Route::post('/campaigns', [AdminController::class, 'storeCampaign'])->name('campaigns.store');
        Route::get('/campaigns/{campaign}/edit', [AdminController::class, 'editCampaign'])->name('campaigns.edit');
        Route::put('/campaigns/{campaign}', [AdminController::class, 'updateCampaign'])->name('campaigns.update');
        Route::delete('/campaigns/{campaign}', [AdminController::class, 'destroyCampaign'])->name('campaigns.destroy');

        // Events CRUD
        Route::get('/events', [AdminController::class, 'events'])->name('events.index');
        Route::get('/events/create', [AdminController::class, 'createEvent'])->name('events.create');
        Route::post('/events', [AdminController::class, 'storeEvent'])->name('events.store');
        Route::get('/events/{event}/edit', [AdminController::class, 'editEvent'])->name('events.edit');
        Route::put('/events/{event}', [AdminController::class, 'updateEvent'])->name('events.update');
        Route::delete('/events/{event}', [AdminController::class, 'destroyEvent'])->name('events.destroy');

        // Volunteers CRUD
        Route::get('/volunteers', [AdminController::class, 'volunteers'])->name('volunteers.index');
        Route::get('/volunteers/create', [AdminController::class, 'createVolunteer'])->name('volunteers.create');
        Route::post('/volunteers', [AdminController::class, 'storeVolunteer'])->name('volunteers.store');
        Route::get('/volunteers/{volunteer}/edit', [AdminController::class, 'editVolunteer'])->name('volunteers.edit');
        Route::put('/volunteers/{volunteer}', [AdminController::class, 'updateVolunteer'])->name('volunteers.update');
        Route::delete('/volunteers/{volunteer}', [AdminController::class, 'destroyVolunteer'])->name('volunteers.destroy');

        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/reports/pdf', [AdminController::class, 'reportsPdf'])->name('reports.pdf');

        // Notifications
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
        Route::patch('/notifications/{id}/read', [AdminController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::patch('/notifications/read-all', [AdminController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::patch('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });

// --- Manager section ---
Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard');

    // ✅ Campaigns CRUD
    Route::get('/campaigns', [ManagerController::class, 'campaigns'])->name('campaigns');
    Route::get('/campaigns/create', [ManagerController::class, 'createCampaign'])->name('campaigns.create');
    Route::post('/campaigns', [ManagerController::class, 'storeCampaign'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}/edit', [ManagerController::class, 'editCampaign'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [ManagerController::class, 'updateCampaign'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [ManagerController::class, 'destroyCampaign'])->name('campaigns.destroy');

   // Donations CRUD
Route::get('/donations', [ManagerController::class, 'donations'])->name('donations');
Route::get('/donations/create', [ManagerController::class, 'createDonation'])->name('donations.create');
Route::post('/donations', [ManagerController::class, 'storeDonation'])->name('donations.store');
Route::get('/donations/{donation}/edit', [ManagerController::class, 'editDonation'])->name('donations.edit');
Route::put('/donations/{donation}', [ManagerController::class, 'updateDonation'])->name('donations.update');
Route::delete('/donations/{donation}', [ManagerController::class, 'destroyDonation'])->name('donations.destroy');

    // Events CRUD
Route::get('/events', [ManagerController::class, 'events'])->name('events');
Route::get('/events/create', [ManagerController::class, 'createEvent'])->name('events.create');
Route::post('/events', [ManagerController::class, 'storeEvent'])->name('events.store');
Route::get('/events/{event}/edit', [ManagerController::class, 'editEvent'])->name('events.edit');
Route::put('/events/{event}', [ManagerController::class, 'updateEvent'])->name('events.update');
Route::delete('/events/{event}', [ManagerController::class, 'destroyEvent'])->name('events.destroy');
Route::get('/events/{event}', [ManagerController::class, 'showEvent'])->name('events.show');

    // Volunteers CRUD
Route::get('/volunteers', [ManagerController::class, 'volunteers'])->name('volunteers');
Route::get('/volunteers/create', [ManagerController::class, 'createVolunteer'])->name('volunteers.create');
Route::post('/volunteers', [ManagerController::class, 'storeVolunteer'])->name('volunteers.store');
Route::get('/volunteers/{volunteer}/edit', [ManagerController::class, 'editVolunteer'])->name('volunteers.edit');
Route::put('/volunteers/{volunteer}', [ManagerController::class, 'updateVolunteer'])->name('volunteers.update');
Route::delete('/volunteers/{volunteer}', [ManagerController::class, 'destroyVolunteer'])->name('volunteers.destroy');

    // Participants CRUD
Route::get('/participants', [ManagerController::class, 'participants'])->name('participants');
Route::get('/participants/create', [ManagerController::class, 'createParticipant'])->name('participants.create');
Route::post('/participants', [ManagerController::class, 'storeParticipant'])->name('participants.store');
Route::get('/participants/{participant}/edit', [ManagerController::class, 'editParticipant'])->name('participants.edit');
Route::put('/participants/{participant}', [ManagerController::class, 'updateParticipant'])->name('participants.update');
Route::delete('/participants/{participant}', [ManagerController::class, 'destroyParticipant'])->name('participants.destroy');

    // Reports
Route::get('/reports', [ManagerController::class, 'reports'])->name('reports');
Route::get('/reports/pdf', [ManagerController::class, 'reportsPdf'])->name('reports.pdf');

    // Notifications CRUD
Route::get('/notifications', [ManagerController::class, 'notifications'])->name('notifications');
Route::post('/notifications/{notification}/mark-read', [ManagerController::class, 'markAsRead'])->name('notifications.markRead');
Route::post('/notifications/mark-all-read', [ManagerController::class, 'markAllAsRead'])->name('notifications.markAllRead');
Route::delete('/notifications/{notification}', [ManagerController::class, 'destroyNotification'])->name('notifications.destroy');

    // Gallery CRUD
Route::get('/gallery', [ManagerController::class, 'gallery'])->name('gallery');
Route::get('/gallery/create', [ManagerController::class, 'createGallery'])->name('gallery.create');
Route::post('/gallery', [ManagerController::class, 'storeGallery'])->name('gallery.store');
Route::put('/gallery/{gallery}', [ManagerController::class, 'updateGallery'])->name('gallery.update'); // ✅ new route
Route::delete('/gallery/{gallery}', [ManagerController::class, 'destroyGallery'])->name('gallery.destroy');



Route::get('/feedback', [ManagerController::class, 'feedbackIndex'])
    ->name('feedback.index');
// Show profile settings
Route::get('/profile', [ManagerController::class, 'profile'])->name('profile');

// Update profile settings
Route::patch('/profile', [ManagerController::class, 'updateProfile'])->name('profile.update');

});



 // --- Donor section ---
Route::prefix('donor')->name('donor.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DonorController::class, 'index'])->name('dashboard');

    // Donations
    Route::get('/donations', [DonorController::class, 'donations'])->name('donations');
    Route::get('/donations/download', [DonorController::class, 'downloadDonations'])->name('donations.download');

    // Campaigns
    Route::get('/campaigns', [DonorController::class, 'campaigns'])->name('campaigns');
    Route::get('/campaigns/{campaign}', [DonorController::class, 'showCampaign'])->name('campaigns.show');
    Route::post('/campaigns/{campaign}/donate', [DonorController::class, 'donate'])->name('campaigns.donate');

    // Events
    Route::get('/events', [DonorController::class, 'events'])->name('events');
    Route::get('/events/{event}', [DonorController::class, 'showEvent'])->name('events.show');
    Route::post('/events/{event}/join', [DonorController::class, 'joinEvent'])->name('events.join');
    Route::post('/events/{event}/cancel', [DonorController::class, 'cancelEvent'])->name('events.cancel'); // ✅ added

    // Receipts
    Route::get('/receipts', [DonorController::class, 'receipts'])->name('receipts');
    Route::get('/receipts/{donation}/download', [DonorController::class, 'downloadReceipt'])->name('receipts.download');

    // Notifications
    Route::get('/notifications', [DonorController::class, 'notifications'])->name('notifications');

    // Profile
    Route::get('/profile', [DonorController::class, 'profile'])->name('profile');

    // Volunteer Activities
    Route::get('/volunteer', [DonorController::class, 'volunteer'])->name('volunteer');
});




// --- Volunteer section ---
Route::prefix('volunteer')->name('volunteer.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [VolunteerController::class, 'index'])->name('dashboard');

    // Events
    Route::get('/events', [VolunteerController::class, 'events'])->name('events.index');   // ✅ index
    Route::get('/events/{event}', [VolunteerController::class, 'showEvent'])->name('events.show'); // ✅ show
    Route::post('/events/{event}/join', [VolunteerController::class, 'joinEvent'])->name('events.join');   // ✅ join
    Route::post('/events/{event}/cancel', [VolunteerController::class, 'cancelEvent'])->name('events.cancel'); // ✅ cancel

    // Participation History
    Route::get('/history', [VolunteerController::class, 'history'])->name('history');

    // Notifications
    Route::get('/notifications', [VolunteerController::class, 'notifications'])->name('notifications');

    // Feedback
    Route::post('/feedback', [VolunteerController::class, 'feedback'])->name('feedback');

    // Profile
    Route::get('/profile', [VolunteerController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [VolunteerController::class, 'updateProfile'])->name('profile.update');
});



    // --- Profile routes ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\StakabaWebhookController;

Route::post('/webhooks/stakaba', [StakabaWebhookController::class, 'handle'])->name('webhooks.stakaba');


require __DIR__.'/auth.php';










