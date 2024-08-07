<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QueueMessage;
use App\Models\Contact;
use App\Models\Group;

use Carbon\Carbon;
use App\Models\SMSAPIKey;

use Illuminate\Support\Facades\Auth;

class QueueMessageController extends Controller
{
    //messagesPage
    public function messagesPage() {

        $total_messages = QueueMessage::where('user_id', Auth::User()->id)->count();

        $groups = Group::where('user_id', Auth::User()->id)->get();

        $messages = QueueMessage::where('user_id', Auth::User()->id)
                ->orderBy('created_at', 'desc')->paginate(24);

        $contacts = Contact::where('user_id', Auth::User()->id)->get();

        return view('pages.messagesPage', [
            'total_messages' => $total_messages,
            'messages' => $messages,
            'groups' => $groups,
            'contacts' => $contacts
        ]);
    }

    //messagesNewSingle
    public function messagesNewSingle(Request $request)
    {
        $request->validate([
            'contact_id' => 'nullable',
            'message_content' => 'nullable'
        ]);

        $contact = Contact::find($request->contact_id);

        $new_message = new QueueMessage();
        $new_message->user_id = Auth::User()->id;
        $new_message->contact_id = $request->contact_id;
        $new_message->to_phone_number = $contact->phone_number;
        $new_message->message_data = $request->message_content;
        $new_message->sent_status = 0;
        $new_message->dlr_report = 0;
        $new_message->save();

        return redirect()->route('contacts.index')
                ->with('success', 'Single Message Created Successfully.');
    }

    //messagesNewMultiple
    public function messagesNewMultiple(Request $request)
    {
        $request->validate([
            'group_id' => 'nullable',
            'message_content' => 'nullable'
        ]);

    }



       //resetNotDeliveredMessages
       public function resetNotDeliveredMessages(Request $request)
       {
           //Input Validation
           $this->validate($request,
                   [
                       'apiKey' => 'required'
                   ]);
   
           //Verify API Key
           $verifyApiKey = SMSAPIKey::where('apiKey', $request->apiKey)->get()->toArray();
   
           if (sizeof($verifyApiKey) == 1) {
               //Get All Outgoing SMS with Sent Status 1 and Delivered Status 0
               //Created At More than 120 seconds
               $outgoingSMSListNotDlr = QueueMessage::where([
                                   ['sent_status', '=', 1],
                                   ['dlr_report', '=', 0],
                                   ['created_at', '<', Carbon::now()->subMinutes(1)->toDateTimeString()]
                                   ])->get();
   
               foreach ($outgoingSMSListNotDlr as $outSMS) {
                   //Update Sent Status to Zero
                   $updateSMS = QueueMessage::find($outSMS->id);
                   $updateSMS->sentStatus = 0;
                   $updateSMS->update();
               }
               return response()->json(array('status' => True), 200);
           }
   
           return response()->json(array('status' => False, 'message' => 'Invalid API Key'), 200);
       }
   
       //clearDlrSMS
       public function clearDlrSMS(Request $request)
       {
           //Inputs Validation
           $this->validate($request,
               [
                   'apiKey' => 'required',
                   'smsId' => 'required'
               ]);
   
           //Verify API Key
           $verifyApiKey = SMSAPIKey::where('api_key', $request->apiKey)->get()->toArray();
   
           if (sizeof($verifyApiKey) == 1) {
               //Clearing Outgoing SMS for Delivered
               $clearDlrOutgoing = QueueMessage::find($request->smsId);
               $clearDlrOutgoing->dlr_report = 1;
               $clearDlrOutgoing->update();
   
               return response()->json(array('status' => True), 201);
   
           }else {
               return response()->json(array('status' => False, 'message_code' => 'INVALID_API_KEY'), 200);
           }
       }
   
       //clearSentSMS
       public function clearSentSMS(Request $request)
       {
           //Input Validation
           $this->validate($request,
                   [
                       'apiKey' => 'required',
                       'smsId' => 'required'
                   ]);
   
           //Verify API Key
           $verifyApiKey = SMSAPIKey::where('api_key', $request->apiKey)->get()->toArray();
   
           if (sizeof($verifyApiKey) == 1) {
               //Clearing Outgoing SMS for Sent
               $clearSentOutgoing = QueueMessage::find($request->smsId);
               $clearSentOutgoing->sent_status = 1;
               $clearSentOutgoing->update();
   
               return response()->json(array('status' => True), 201);
   
           }else {
               return response()->json(array('status' => False, 'message_code' => 'INVALID_API_KEY'), 200);
           }
       }
   
    
   
       /**
        * @OA\GET(
        *     path="/api/v1/get/action/outgoing/sms",
        *     tags={"OUTGOING_SMS"},
        *     summary="Get SMS from Mobile Interface to send them to End Users",
        *     description="Get SMS from Mobile Interface to send them to End Users",
        *
        *     @OA\Parameter(
        *          name="apiKey",
        *          in="query",
        *          required=true,
        *          description="Enter API Key",
        *          @OA\Schema(
        *              type="string"
        *          ),
        *     ),
        *
        *     @OA\Response(
        *         response="default",
        *         description="successful operation"
        *     )
        * )
        */
       //getActionOutgoingSMS
       public function getActionOutgoingSMS(Request $request)
       {
           //Input Validation
           $this->validate($request,
                   [
                       'apiKey' => 'required'
                   ]);
   
           //Verify API Key
           $verifyApiKey = SMSAPIKey::where('api_key', $request->apiKey)->get()->toArray();
   
           if (sizeof($verifyApiKey) == 1) {
               //Get Outgoing SMS for this apiKey
               $userId = $verifyApiKey['0']['user_id'];
   
               $OutgoingSMSList = QueueMessage::where([
                                       ['user_id', '=', $userId],
                                       ['sent_status', '=', 0],
                                   ])->orderBy('created_at', 'DESC')
                                   ->limit(10)->get();
   
               return response()->json(array('outgoing_list' => $OutgoingSMSList, 'status' => True), 200);
   
           }else {
               return response()->json(array('status' => False, 'message' => 'Invalid API Key'), 403);
           }
   
       }
   
       /**
        * @OA\POST(
        *     path="/api/v1/receive/action/send/sms",
        *     tags={"OUTGOING_SMS"},
        *     summary="Send Your SMS from Your App to this API to Get it In Dove SMS Lifecyle",
        *     description="Send Your SMS from Your App to this API to Get it In Dove SMS Lifecyle",
        *
        *     @OA\Parameter(
        *          name="apiKey",
        *          in="query",
        *          required=true,
        *          description="Enter API Key",
        *          @OA\Schema(
        *              type="string"
        *          ),
        *     ),
         *
         *     @OA\Parameter(
        *          name="phoneNumber",
        *          in="query",
        *          required=true,
        *          description="Enter Recepient Phone Number example : +255712100100",
        *          @OA\Schema(
        *              type="string"
        *          ),
        *     ),
        *
         *     @OA\Parameter(
        *          name="messageContent",
        *          in="query",
        *          required=true,
        *          description="Enter Message Content to Sent to End Users",
        *          @OA\Schema(
        *              type="string"
        *          ),
        *     ),
        *
        *     @OA\Response(
        *         response="default",
        *         description="successful operation"
        *     )
        * )
        */
       //receiveActionSendSMS
       public function receiveActionSendSMS(Request $request)
       {
           //Input Validation
           $this->validate($request,
               [
                   'apiKey' => 'required',
                   'phoneNumber' => 'required',
                   'messageContent' => 'required'
               ]);
   
           //Verify API Key
           $verifyApiKey = SMSAPIKey::where('apiKey', $request->apiKey)->get()->toArray();
   
           if (sizeof($verifyApiKey) == 1) {
               //Get User ID
               $userId = $verifyApiKey['0']['userId'];
   
               //Add New SMS in Outgoing SMS Queue
               $newOutgoingSMS = new QueueMessage();
               $newOutgoingSMS->user_id = $userId;
               $newOutgoingSMS->phoneNumber = $request->phoneNumber;
               $newOutgoingSMS->messageContent = $request->messageContent;
               $newOutgoingSMS->sentStatus = 0;
               $newOutgoingSMS->dlrReport = 0;
   
               if ($newOutgoingSMS->save()) {
                   return response()->json(array('status' => True, 'smsId' => $newOutgoingSMS->id), 201);
               }else {
                   return response()->json(array('status' => False, 'message' => 'Server Error'), 200);
               }
           }else {
               return response()->json(array('status' => False, 'message' => 'Invalid API Key'), 403);
           }
   
       }


}

