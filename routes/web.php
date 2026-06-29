<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\HealthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\BudgetSubitems;
use App\Http\Controllers\Card;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\HoldingController;
use App\Http\Controllers\MasterXController;
use App\Http\Controllers\NatureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserRelatedController;
use App\Http\Controllers\XItemController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ─── Public / Guest ──────────────────────────────────────────────────────────

Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/features', fn() => view('features'))->name('features');
Route::get('/about', fn() => view('About'))->name('About');
Route::get('/contact', fn() => view('Contact'))->name('Contact');

Auth::routes(['verify' => true]);

// ─── Authenticated + Email Verified ──────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Onboarding
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding/complete', [OnboardingController::class, 'complete'])->name('onboarding.complete');

    // Natures
    Route::get('/natures', [NatureController::class, 'index'])->name('natures.index');
    Route::get('/natures/create', [NatureController::class, 'create'])->name('natures.create');
    Route::post('/natures', [NatureController::class, 'store'])->name('natures.store');
    Route::get('/natures/{nature}/edit', [NatureController::class, 'edit'])->name('natures.edit');
    Route::put('/natures/{nature}', [NatureController::class, 'update'])->name('natures.update');
    Route::delete('/natures/{nature}', [NatureController::class, 'destroy'])->name('natures.destroy');

    // Budgets
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/budgets/recurring', [BudgetController::class, 'Recurrings'])->name('budgets.Recurring');
    Route::get('/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::get('/budgets/{budget}', [BudgetController::class, 'show'])->name('budgets.show');
    Route::get('/budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::post('/budgets/update', [BudgetController::class, 'update'])->name('budgets.update');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
    Route::put('/budgets/{budget}/finalize', [BudgetController::class, 'Finalized'])->name('budgets.Finalized');

    // Budget Sub-items
    Route::get('/budget-subitems', [BudgetSubitems::class, 'index'])->name('budget_subitems.index');
    Route::get('/budget-subitems/create', [BudgetSubitems::class, 'create'])->name('budget_subitems.create');
    Route::post('/budget-subitems', [BudgetSubitems::class, 'store'])->name('budget_subitems.store');
    Route::get('/budget-subitems/{subitem}/edit', [BudgetSubitems::class, 'edit'])->name('budget_subitems.edit');
    Route::put('/budget-subitems/{subitem}', [BudgetSubitems::class, 'update'])->name('budget_subitems.update');
    Route::delete('/budget-subitems/{subitem}', [BudgetSubitems::class, 'destroy'])->name('budget_subitems.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Transfers
    Route::get('/transfers', [TransferController::class, 'index'])->name('transfers.index');
    Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');
    Route::post('/transfers', [TransferController::class, 'store'])->name('transfers.store');
    Route::delete('/transfers/{transfer}', [TransferController::class, 'destroy'])->name('transfers.destroy');

    // Bank Statement Import
    Route::get('/statements/import', [StatementController::class, 'index'])->name('statements.import');
    Route::post('/statements/upload', [StatementController::class, 'upload'])->name('statements.upload');
    Route::get('/statements/preview', [StatementController::class, 'preview'])->name('statements.preview');
    Route::post('/statements/confirm', [StatementController::class, 'confirm'])->name('statements.confirm');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/history', [TransactionController::class, 'Dashboard'])->name('transactions.list');
    Route::get('/transactions/download', [TransactionController::class, 'download'])->name('transactions.download');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Cards
    Route::get('/cards', [Card::class, 'index'])->name('cards.index');
    Route::get('/cards/create', [Card::class, 'create'])->name('cards.create');
    Route::post('/cards', [Card::class, 'store'])->name('cards.store');
    Route::get('/cards/{card}', [Card::class, 'show'])->name('cards.show');
    Route::get('/cards/{card}/edit', [Card::class, 'edit'])->name('cards.edit');
    Route::put('/cards/{card}', [Card::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [Card::class, 'destroy'])->name('cards.destroy');

    // Related Users
    Route::get('/user-related', [UserRelatedController::class, 'index'])->name('user_related.index');
    Route::get('/user-related/create', [UserRelatedController::class, 'create'])->name('user_related.create');
    Route::post('/user-related', [UserRelatedController::class, 'store'])->name('user_related.store');
    Route::get('/user-related/{userRelated}/edit', [UserRelatedController::class, 'edit'])->name('user_related.edit');
    Route::put('/user-related/{userRelated}', [UserRelatedController::class, 'update'])->name('user_related.update');
    Route::delete('/user-related/{userRelated}', [UserRelatedController::class, 'destroy'])->name('user_related.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Goals
    Route::get('/goals/overview', [GoalsController::class, 'Goals'])->name('Goals.Matter');
    Route::get('/goals', [GoalsController::class, 'index'])->name('goals.index');
    Route::get('/goals/create', [GoalsController::class, 'create'])->name('goals.create');
    Route::post('/goals', [GoalsController::class, 'store'])->name('goals.save');
    Route::get('/goals/{goal}/edit', [GoalsController::class, 'edit'])->name('goals.edit');
    Route::put('/goals/{goal}', [GoalsController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{goal}', [GoalsController::class, 'destroy'])->name('goals.destroy');
    Route::put('/goals/{goal}/milestones', [GoalsController::class, 'show'])->name('goals.show');
    Route::get('/goals/balance', [GoalsController::class, 'UpdateBalance'])->name('goals.Balance');

    // Reports
    Route::get('/reports/spending', [ReportsController::class, 'index'])->name('Report.spending');
    Route::get('/reports/cash-budget', [ReportsController::class, 'CashBudget'])->name('forecast');
    Route::get('/reports/balance-sheet', [ReportsController::class, 'Balancesheet'])->name('Balancesheet');
    Route::get('/reports/trial-balance/{id}', [ReportsController::class, 'show'])->name('T-Balance');
    Route::get('/reports/monthly-trends', [ReportsController::class, 'monthlyTrends'])->name('reports.trends');

    // Master X
    Route::get('/master/create', [MasterXController::class, 'create'])->name('Master');
    Route::post('/master', [MasterXController::class, 'store'])->name('masterx.store');
    Route::get('/master', [MasterXController::class, 'index'])->name('master.index');
    Route::get('/master/{id}', [MasterXController::class, 'show'])->name('master.show');

    // Sections / X-Items
    Route::get('/sections/create', [XItemController::class, 'create'])->name('section');
    Route::post('/sections', [XItemController::class, 'store'])->name('x_items.store');
    Route::get('/sections/{id}/edit', [XItemController::class, 'edit'])->name('section.edit');
    Route::post('/sections/{id}', [XItemController::class, 'update'])->name('section.update');
    Route::delete('/sections/{id}', [XItemController::class, 'destroy'])->name('section.delete');

    // Holdings
    Route::get('/holdings/create', [HoldingController::class, 'create'])->name('holding.create');
    Route::post('/holdings', [HoldingController::class, 'store'])->name('holding.store');
    Route::post('/holdings/update', [HoldingController::class, 'update'])->name('holding.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');

    // ─── Admin (role-protected) ───────────────────────────────────────────────
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard & core
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/online', [AdminController::class, 'Onlineusers'])->name('online');
        Route::get('/activity-log', [AdminController::class, 'activityLog'])->name('activity-log');

        // User management
        Route::get('/users', [AdminController::class, 'Users'])->name('users');
        Route::post('/users/{user}/role', [UserManagementController::class, 'changeRole'])->name('users.role');
        Route::post('/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
        Route::post('/users/{user}/reactivate', [UserManagementController::class, 'reactivate'])->name('users.reactivate');
        Route::post('/users/{user}/force-logout', [UserManagementController::class, 'forceLogout'])->name('users.force-logout');
        Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/activity', [UserManagementController::class, 'userActivity'])->name('users.activity');
        Route::post('/users/{user}/notes', [UserManagementController::class, 'addNote'])->name('users.notes.store');
        Route::delete('/notes/{note}', [UserManagementController::class, 'deleteNote'])->name('notes.destroy');

        // Impersonation (Master only)
        Route::post('/users/{user}/impersonate', [UserManagementController::class, 'impersonate'])->name('users.impersonate');
        Route::post('/stop-impersonating', [UserManagementController::class, 'stopImpersonating'])->name('stop-impersonating');

        // Site monitor (cross-instance via Xquisite API)
        Route::get('/sites', [AdminController::class, 'siteMonitor'])->name('sites');

        // Platform health
        Route::get('/health', [HealthController::class, 'index'])->name('health');

        // Announcements
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::post('/announcements/{announcement}/deactivate', [AnnouncementController::class, 'deactivate'])->name('announcements.deactivate');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });
});
