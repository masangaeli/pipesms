<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QueueMessageController;
use App\Http\Controllers\IncomingSMSController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GroupContactController;
use App\Http\Controllers\GroupController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'v1'], function () {

	//Pull User Groups
	Route::get('/pull/user/groups', [GroupController::class, 'pullUserGroups']);

	//Add Contact to Group
	Route::get('/add/contact/to/group', [GroupContactController::class, 'addContactToGroup']);

	//Get Group Contacts List
	Route::get('/group/contacts/list', [GroupContactController::class, 'groupContactList']);

		

	//Reset Not Delivered Messages for 120 Seconds
	Route::get('/reset/not/delivered/messages', [QueueMessageController::class, 'resetNotDeliveredMessages']);

	//Clear SMS Delivery Report
	Route::post('/mobile/interface/clear/delivery/rpt', [QueueMessageController::class, 'clearDlrSMS']);

	//Clear Send SMS from Smart Phone
	Route::post('/mobile/interface/clear/outgoing', [QueueMessageController::class, 'clearSentSMS']);

	//Mobile Interface Login
	Route::post('/mobile/interface/login', [Controller::class, 'mobileInterfaceLogin']);

	//Post SMS Incoming
	Route::post('/receive/action/sms/incoming', [IncomingSMSController::class, 'receiveSMSIncoming']);

	//Get SMS for Outgoing
	Route::get('/get/action/outgoing/sms', [QueueMessageController::class, 'getActionOutgoingSMS']);

	//Receive SMS from External
	Route::post('/receive/action/send/sms', [QueueMessageController::class, 'receiveActionSendSMS']);

});
