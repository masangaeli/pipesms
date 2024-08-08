<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\GroupContact;

use Illuminate\Support\Facades\Auth;

class GroupContactController extends Controller
{
    //groupContactDestroy
    public function groupContactDestroy(Request $request)
    {
        //Input Validation
        $this->validate($request,
            [
                'contact_id' => 'required',
                'group_id' => 'required',
            ]);

        $group_contact_query = GroupContact::where([
            ['group_id', '=', $request->group_id],
            ['contact_id', '=', $request->contact_id]
        ])->get()->toArray();

        $group_contact = GroupContact::find($group_contact_query['0']['id']);

        if ($group_contact != null) {
            $group_contact->delete();
        }

        return redirect()->route('groups.index')
        ->with('success', 'Group Contact Deleted successfully.');
    }

    //groupContactList
    public function groupContactList(Request $request)
    {
        //Input Validation
        $this->validate($request,
            [
                'group_id' => 'required'
            ]);

        $group_contacts = GroupContact::where('group_id', $request->group_id)->get();

        $contacts_response = array();

        foreach($group_contacts as $g_contact) {
            $contact = Contact::find($g_contact->contact_id);

            if ($contact != null) {
                $contacts_response[] = $contact;
            }
        }

        return response()->json(array('group_contacts' => $contacts_response), 200);
    }


    //addContactToGroup
    public function addContactToGroup(Request $request)
    {
        //Input Validation
        $this->validate($request,
            [
                'user_id' => 'required',
                'contact_id' => 'required',
                'group_id' => 'required',
            ]);

        $group_contact = new GroupContact();
        $group_contact->user_id = $request->user_id;
        $group_contact->group_id = $request->group_id;
        $group_contact->contact_id = $request->contact_id;
        $group_contact->save();

        return response()->json(array('status' => true), 201);
    }
}
