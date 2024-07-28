<?php

use App\Http\Controllers\QueueMessageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;



// Authenticated Routes

    //Groups
    Route::get('/groups', [GroupController::class, 'groupsPage']);

    //Contacts
    Route::get('/contacts', [ContactController::class, 'contactsPage']);

    //Messages
    Route::get('/messages', [QueueMessageController::class, 'messagesPage']);



// Public Routes
Route::get('/', [Controller::class, 'indexPage']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
