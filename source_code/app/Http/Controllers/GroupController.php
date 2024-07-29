<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\GroupContact;

class GroupController extends Controller
{
    //groupsPage
    public function groupsPage(Request $request)
    {
        $groupsList = Group::orderBy('created_by', 'desc')->paginate(24);

        return view('groupsPage', [
            'groups' => $groupsList
        ]);
    }
}
