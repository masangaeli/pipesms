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
        $total_groups = Group::all()->count();
        $groupsList = Group::orderBy('created_at', 'desc')->paginate(24);

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
