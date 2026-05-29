<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\InvitationVerificationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/events', [HomeController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [HomeController::class, 'eventShow'])->name('events.show');

// Search API
Route::middleware(['auth', 'verified', 'check.status'])->get('/search/events', [HomeController::class, 'searchApi'])->name('search.events');

// Authenticated User Routes
Route::middleware(['auth', 'verified', 'check.status'])->group(function () {
    // User Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/invitations', [UserDashboardController::class, 'invitations'])->name('user.invitations');
        Route::post('/events/{event}/request-invitation', [UserDashboardController::class, 'requestInvitation'])->name('user.request-invitation');
        Route::get('/invitations/{invitation}/pass', [UserDashboardController::class, 'invitationPass'])->name('user.invitation-pass');
        Route::get('/favorites', [UserDashboardController::class, 'favorites'])->name('user.favorites');
        Route::post('/events/{event}/favorite', [UserDashboardController::class, 'toggleFavorite'])->name('user.toggle-favorite');
        Route::get('/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');
        Route::post('/notifications/{id}/read', [UserDashboardController::class, 'markNotificationRead'])->name('user.notification-read');
        Route::post('/notifications/read-all', [UserDashboardController::class, 'markAllNotificationsRead'])->name('user.notifications-read-all');
        Route::get('/settings', [UserDashboardController::class, 'settings'])->name('user.settings');
        Route::put('/settings', [UserDashboardController::class, 'updateSettings'])->name('user.settings.update');
        Route::post('/theme', [UserDashboardController::class, 'updateTheme'])->name('user.theme.update');
    });

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Invitation Verification (Event Managers & Admins)
    Route::prefix('verification')->name('verification.')->middleware(['role:super_admin,event_manager'])->group(function () {
        Route::get('/', [InvitationVerificationController::class, 'index'])->name('index');
        Route::post('/verify', [InvitationVerificationController::class, 'verify'])->name('verify');
        Route::post('/ajax/verify', [InvitationVerificationController::class, 'verifyAjax'])->name('verify-ajax');
        Route::post('/{invitation}/mark-attended', [InvitationVerificationController::class, 'markAttended'])->name('mark-attended');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['role:super_admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Users
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'userCreate'])->name('users.create');
        Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
        Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
        Route::post('/users/{user}/suspend', [AdminController::class, 'userSuspend'])->name('users.suspend');
        Route::post('/users/{user}/activate', [AdminController::class, 'userActivate'])->name('users.activate');

        // Events
        Route::get('/events', [AdminController::class, 'events'])->name('events');
        Route::get('/events/create', [AdminController::class, 'eventCreate'])->name('events.create');
        Route::post('/events', [AdminController::class, 'eventStore'])->name('events.store');
        Route::get('/events/{event}', [AdminController::class, 'eventShow'])->name('events.show');
        Route::get('/events/{event}/edit', [AdminController::class, 'eventEdit'])->name('events.edit');
        Route::put('/events/{event}', [AdminController::class, 'eventUpdate'])->name('events.update');
        Route::delete('/events/{event}', [AdminController::class, 'eventDestroy'])->name('events.destroy');
        Route::post('/events/{event}/approve', [AdminController::class, 'eventApprove'])->name('events.approve');
        Route::post('/events/{event}/reject', [AdminController::class, 'eventReject'])->name('events.reject');
        Route::post('/events/{event}/cancel', [AdminController::class, 'eventCancel'])->name('events.cancel');
        Route::post('/events/{event}/featured', [AdminController::class, 'eventToggleFeatured'])->name('events.featured');

        // Invitations
        Route::get('/invitations', [AdminController::class, 'invitations'])->name('invitations');
        Route::post('/invitations/{invitation}/approve', [AdminController::class, 'invitationApprove'])->name('invitations.approve');
        Route::post('/invitations/{invitation}/reject', [AdminController::class, 'invitationReject'])->name('invitations.reject');

        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/reports/users/pdf', [AdminController::class, 'exportUsersPdf'])->name('reports.users.pdf');
        Route::get('/reports/events/pdf', [AdminController::class, 'exportEventsPdf'])->name('reports.events.pdf');

        // Logs
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
        Route::get('/logs/activity', [AdminController::class, 'activityLogs'])->name('logs.activity');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    });
});

require __DIR__.'/auth.php';
