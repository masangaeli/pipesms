<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\GroupContact;

use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    //pullUserGroups
    public function pullUserGroups(Request $request)
    {
        //Input Validation
        $this->validate($request,
            [
                'user_id' => 'required',
                'contact_id' => 'required'
            ]);

        //Pull User Groups
        $userGroups = Group::where('user_id', $request->user_id)->get();

        $groups_ret_list = array();

        foreach ($userGroups as $group) {
            //Check Groups Where User is in
            $group_contact_check = GroupContact::where([
                ['contact_id', '=', $request->contact_id],
                ['group_id', '=', $group->id],
            ])->get();

            if (sizeof($group_contact_check) == 0) {
                $groups_ret_list[] = Group::find($group->id);
            }

        }

        return response()->json(array('groupsList' => $groups_ret_list), 200);
    }

    //groupsPage
    public function groupsPage(Request $request)
    {
        $total_groups = Group::where('user_id', Auth::User()->id)
                    ->get()->count();

        $groupsList = Group::where('user_id', Auth::User()->id)
                        ->orderBy('created_at', 'desc')->paginate(24);

        return view('pages.groupsPage', [
            'groups' => $groupsList,
            'total_groups' => $total_groups,
        ]);
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'group_title' => 'required',
            'group_info' => 'nullable'
        ]);

        Group::create($request->all());

        return redirect()->route('groups.index')
                ->with('success', 'Group created successfully.');
    }


    public function updateGroup(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
            'group_title' => 'required',
            'group_info' => 'nullable'
        ]);

        $group = Group::find($request->group_id);

        $group->update($request->all());

        return redirect()->route('groups.index')
                ->with('success', 'Group updated successfully.');
    }

    public function destroyGroup(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
        ]);

        $group = Group::find($request->group_id);

        $group->delete();

        return redirect()->route('groups.index')
                ->with('success', 'Group deleted successfully.');
    }
}
