<?php

use App\Http\Controllers\QueueMessageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Route;



//Authenticated Routes
Route::middleware(['auth'])->group(function () {

    //Groups
    Route::get('/groups', [GroupController::class, 'groupsPage'])
        ->name('groups.index');

    //Destroy  Group
    Route::delete('groups/destroy', [GroupController::class, 'destroyGroup'])
        ->name('groups.destroy');

    //Store Groups
    Route::post('groups/store', [GroupController::class, 'storeGroup'])
        ->name('groups.store');

    //Update Groups
    Route::post('groups/update', [GroupController::class, 'updateGroup'])
        ->name('groups.update');



    

            


    //Users
    Route::get('/users', [Controller::class, 'usersPage'])
            ->name('users.index');

   //Destroy Users
   Route::delete('users/destroy', [Controller::class, 'destroyUser'])
       ->name('users.destroy');

   //Store Users
   Route::post('users/store', [Controller::class, 'storeUser'])
       ->name('users.store');

   //Update Users
   Route::post('users/update', [Controller::class, 'updateUser'])
       ->name('users.update');


       
    //Devices
    Route::get('/devices', [DeviceController::class, 'devicesPage'])
        ->name('devices.index');

    //Destroy Devices
    Route::delete('devices/destroy', [DeviceController::class, 'destroyDevice'])
    ->name('devices.destroy');

    //Store Devices
    Route::post('devices/store', [DeviceController::class, 'storeDevice'])
    ->name('devices.store');

    //Update Devices
    Route::post('devices/update', [DeviceController::class, 'updateDevice'])
    ->name('devices.update');


    
    //Contacts
    Route::get('/contacts', [ContactController::class, 'contactsPage'])
        ->name('contacts.index');

    //Destroy Contacts
    Route::delete('contacts/destroy', [ContactController::class, 'destroyContact'])
        ->name('contacts.destroy');
 
    //Store Contacts
    Route::post('contacts/store', [ContactController::class, 'storeContact'])
        ->name('contacts.store');
 
    //Update Contacts
    Route::post('contacts/update', [ContactController::class, 'updateContact'])
        ->name('contacts.update');



    //Messages
    Route::get('/messages', [QueueMessageController::class, 'messagesPage'])
        ->name('messages.index');

    //New Single Message
    Route::post('/messages/new_single', [QueueMessageController::class, 'messagesNewSingle'])
            ->name('messages.new_single');

    //New Multiple Messages
    Route::post('/messages/multiple_messages', [QueueMessageController::class, 'messagesNewMultiple'])
    ->name('messages.new_multiple');


});

// Public Routes
Route::get('/', [Controller::class, 'indexPage']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
