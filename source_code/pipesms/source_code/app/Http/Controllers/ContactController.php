<?php

namespace App\Http\Controllers;

use App\Models\GroupContact;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Group;

use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //contactsPage
    public function contactsPage(Request $request)
    {
        //Get Contacts List
        $total_contacts = Contact::where('user_id', Auth::User()->id)
                    ->count();
                    
        $groups = Group::where('user_id', Auth::User()->id)
                    ->get();

        $contactsList = Contact::where('user_id', Auth::User()->id)
                    ->orderBy('created_at', 'desc')->paginate(24);

        return view('pages.contactsPage',
        [
            'groups' => $groups,
            'total_contacts' => $total_contacts,
            'contacts' => $contactsList
        ]);
    }



    public function storeContact(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'phone_number' => 'nullable',
        ]);

        $new_contact = new Contact();
        $new_contact->user_id = Auth::User()->id;
        $new_contact->first_name = $request->first_name;
        $new_contact->last_name = $request->last_name;
        $new_contact->phone_number = $request->phone_number;
        $new_contact->save();

        if ($request->default_group) {
            //Add This Contact to Group
            $new_contact_group = new GroupContact();
            $new_contact_group->user_id = Auth::User()->id;
            $new_contact_group->group_id = $request->default_group;
            $new_contact_group->contact_id = $new_contact->id;
            $new_contact_group->save();
        }

        return redirect()->route('contacts.index')
                ->with('success', 'Contact created successfully.');
    }


    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required'
        ]);

        $contact = Contact::find($request->contact_id);

        $contact->update($request->all());

        return redirect()->route('contacts.index')
                ->with('success', 'Contact updated successfully.');
    }

    public function destroyContact(Request $request)
    {
        $request->validate([
            'contact_id' => 'required',
        ]);

        $contact = Contact::find($request->contact_id);

        $contact->delete();

        return redirect()->route('contacts.index')
                ->with('success', 'Contact deleted successfully.');
    }


}
