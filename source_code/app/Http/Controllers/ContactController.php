<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    //contactsPage
    public function contactsPage(Request $request)
    {
        //Get Contacts List
        $contactsList = Contact::orderBy('created_at', 'desc')->paginate(24);

        return view('pages.contactsPage',
        [
            'contacts' => $contactsList
        ]);
    }
}
