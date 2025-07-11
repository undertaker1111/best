<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\DashboardController;

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

Route::redirect('/', 'login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Real Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Ticket Dashboard
    Route::get('/tickets/dashboard', [TicketController::class, 'index'])
        ->middleware('can:view tickets')
        ->name('tickets.dashboard');
    // All Tickets
    Route::get('/tickets', [TicketController::class, 'index'])
        ->middleware('can:view tickets')
        ->name('tickets.index');
    // My Tickets
    Route::get('/tickets/my', [TicketController::class, 'myTickets'])
        ->middleware('can:view tickets')
        ->name('tickets.my');
    // Create Ticket
    Route::get('/tickets/create', [TicketController::class, 'create'])
        ->middleware('can:create tickets')
        ->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])
        ->middleware('can:create tickets')
        ->name('tickets.store');
    // Show Ticket
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])
        ->middleware('can:view tickets')
        ->name('tickets.show');
    // Edit Ticket
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])
        ->middleware('can:edit tickets')
        ->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])
        ->middleware('can:edit tickets')
        ->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])
        ->middleware('can:delete tickets')
        ->name('tickets.destroy');

    // AI AJAX endpoints for tickets
    Route::post('/tickets/ai-generate-description', [TicketController::class, 'aiGenerateDescription'])
        ->middleware('can:create tickets')
        ->name('tickets.ai.generateDescription');
    Route::get('/tickets/{ticket}/ai-suggestions', [TicketController::class, 'aiSuggestions'])
        ->middleware('can:view tickets')
        ->name('tickets.ai.suggestions');
    Route::post('/tickets/{ticket}/ai-accept-suggestion', [TicketController::class, 'aiAcceptSuggestion'])
        ->middleware('can:view tickets')
        ->name('tickets.ai.acceptSuggestion');

    // Kanban Board for Tickets
    Route::get('/tickets/board', [TicketController::class, 'board'])
        ->middleware('can:view tickets')
        ->name('tickets.board');

    // Profile
    Route::view('/profile', 'profile.show')->name('profile.show');
    // Settings
    Route::view('/settings', 'settings')->name('settings');
    // AI/Automations Placeholder
    Route::get('/ai', function () { return view('ai.placeholder'); })
        ->middleware('can:view ai')
        ->name('ai.placeholder');
    Route::post('/ai', [AIController::class, 'storeApiKey'])
        ->middleware('can:manage ai')
        ->name('ai.saveApiKey');

    // AI Management
    Route::get('/ai-management', [\App\Http\Controllers\AIManagementController::class, 'index'])
        ->middleware('can:manage ai')
        ->name('ai.management');
    Route::post('/ai-management', [\App\Http\Controllers\AIManagementController::class, 'update'])
        ->middleware('can:manage ai')
        ->name('ai.management.update');
    Route::get('/ai-logs', [\App\Http\Controllers\AIManagementController::class, 'logs'])
        ->middleware('can:manage ai')
        ->name('ai.logs');

    // User Management
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('can:manage users')
        ->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('can:manage users')
        ->name('users.create');
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('can:manage users')
        ->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('can:manage users')
        ->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('can:manage users')
        ->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('can:manage users')
        ->name('users.destroy');

    // Permissions Management
    Route::get('/permissions', [UserController::class, 'permissions'])
        ->middleware('can:manage permissions')
        ->name('permissions.index');
    Route::post('/permissions/assign', [UserController::class, 'assignPermission'])
        ->middleware('can:manage permissions')
        ->name('permissions.assign');
    Route::post('/permissions/revoke', [UserController::class, 'revokePermission'])
        ->middleware('can:manage permissions')
        ->name('permissions.revoke');

    // Audits
    Route::get('/audits', [AuditController::class, 'index'])
        ->middleware('can:view audits')
        ->name('audits.index');

    // Fallback
    Route::fallback(function() {
        return redirect()->route('dashboard');
    });

    Route::get('/json-data-feed', [\App\Http\Controllers\DashboardController::class, 'jsonDataFeed']);
});
