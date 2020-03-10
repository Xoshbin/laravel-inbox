<?php

use Illuminate\Support\Facades\Route;
use Xoshbin\Inbox\Http\Controllers\InboxController;

Route::prefix('api')->group(function () {
    // Dashboard Routes...
    Route::get('/emails', [InboxController::class, 'emails'])->name('inbox.emails');
    Route::get('/star/{id}', [InboxController::class, 'star'])->name('inbox.star');
    Route::get('/bookmark/{id}', [InboxController::class, 'bookmark'])->name('inbox.bookmark');
    Route::get('/show/{id}', [InboxController::class, 'email'])->name('inbox.show');
    Route::get('/unread/{id}', [InboxController::class, 'unread'])->name('inbox.unread');
    Route::get('/delete/{id}', [InboxController::class, 'delete'])->name('inbox.delete');
    Route::get('/reply/{id}', [InboxController::class, 'email'])->name('inbox.reply');
    Route::post('/sendreply', [InboxController::class, 'sendreply'])->name('inbox.sendreply');
    Route::get('/forward/{id}', [InboxController::class, 'email'])->name('inbox.forward');
    Route::post('/sendforward', [InboxController::class, 'sendforward'])->name('inbox.sendforward');
    Route::post('/send', [InboxController::class, 'send'])->name('inbox.send');
    Route::get('/starred', [InboxController::class, 'starred'])->name('inbox.starred');
    Route::get('/sent', [InboxController::class, 'sent'])->name('inbox.sent');
    Route::get('/important', [InboxController::class, 'important'])->name('inbox.important');
    Route::get('/trash', [InboxController::class, 'trash'])->name('inbox.trash');
    Route::post('/bulkdelete', [InboxController::class, 'bulkDelete'])->name('inbox.bulkdelete');
    Route::post('/bulkunread', [InboxController::class, 'bulkUnread'])->name('inbox.bulkunread');
    Route::post('/bulkstar', [InboxController::class, 'bulkStar'])->name('inbox.bulkstar');
    Route::post('/bulkbookmark', [InboxController::class, 'bulkbookmark'])->name('inbox.bulkbookmark');
});

// Catch-all Route...
Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('inbox.index');