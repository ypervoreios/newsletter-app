<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignTrackingController;
use App\Mail\CampaignMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Campaign;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $contacts = \App\Models\Contact::count();
    $campaigns = \App\Models\Campaign::count();
    $sentCampaigns = \App\Models\Campaign::where('status', 'sent')->count();
    $draftCampaigns = \App\Models\Campaign::where('status', 'draft')->count();
    $latestSentCampaigns = \App\Models\Campaign::where('status', 'sent')
        ->withCount([
            'recipients',
            'recipients as opened_count' => fn ($query) => $query->whereNotNull('opened_at'),
        ])
        ->withMax('recipients', 'sent_at')
        ->latest()
        ->get();

    return view('dashboard', compact('contacts', 'campaigns', 'sentCampaigns', 'draftCampaigns', 'latestSentCampaigns'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function(){
    Route::middleware('admin')->group(function () {
        Route::get('/settings/mail', [App\Http\Controllers\SettingsController::class, 'mail'])->name('settings.mail');
        Route::post('/settings/mail', [App\Http\Controllers\SettingsController::class, 'mailUpdate'])->name('settings.mail.update');
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/contacts/import', 
    [ContactController::class, 'import']
)->middleware(['auth', 'verified'])
->name('contacts.import');

Route::post('/contacts/import', 
    [ContactController::class, 'importStore']
)->middleware(['auth', 'verified'])
->name('contacts.import.store');

Route::resource('contacts', ContactController::class)->middleware(['auth', 'verified']);


Route::get('/campaigns/track/open/{token}',
    [CampaignTrackingController::class, 'open']
)->name('campaigns.track.open');

Route::get('/campaigns/unsubscribe/{token}',
    [CampaignTrackingController::class, 'unsubscribe']
)->name('campaigns.unsubscribe');

Route::resource('campaigns', CampaignController::class)
    ->middleware(['auth', 'verified']);

Route::get('/campaigns/{campaign}/preview',
    [CampaignController::class, 'preview']
)->name('campaigns.preview')
->middleware(['auth','verified']);

Route::get('/test-mail/{id}', function($id){

    $campaign = Campaign::findOrFail($id);


    Mail::to('akis@aplan.gr')
        ->send(new CampaignMail($campaign));


    return "Email sent";});

    Route::get('/campaigns/{campaign}/test',
    [CampaignController::class, 'testEmail']
)
->name('campaigns.test')
->middleware(['auth','verified']);


Route::post('/campaigns/{campaign}/test',
    [CampaignController::class, 'sendTestEmail']
)
->name('campaigns.test.send')
->middleware(['auth','verified']);

Route::get('/campaigns/{campaign}/send',
    [CampaignController::class,'send'])
    ->name('campaigns.send')
    ->middleware(['auth','verified']);

Route::post('/campaigns/{campaign}/send',
    [CampaignController::class,'sendToContacts'])
    ->name('campaigns.send.submit')
    ->middleware(['auth','verified']);

require __DIR__.'/auth.php';
