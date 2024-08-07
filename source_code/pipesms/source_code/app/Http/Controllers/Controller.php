<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Device;
use App\Models\SMSAPIKey;

use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    //usersPage
    public function usersPage(Request $request)
    {
        $total_users = User::all()->count();
        $usersList = User::orderBy('created_at', 'DESC')->paginate(24);

        return view("pages.usersPage",
        [
            'users' => $usersList,
            'total_users' => $total_users
        ]);
    }

    //indexPage
    public function indexPage(Request $request)
    {
        return view("index");
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $new_user = new User();
        $new_user->first_name = $request->first_name;
        $new_user->last_name = $request->last_name;
        $new_user->email = $request->email;
        $new_user->password = $request->password;
        $new_user->level = 3;
        $new_user->save();

        return redirect()->route('users.index')
                ->with('success', 'Group created successfully.');
    }


    public function updateUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required'
        ]);

        $update_user = User::find($request->user_id);

        $update_user->first_name = $request->first_name;
        $update_user->last_name = $request->last_name;
        $update_user->email = $request->email;

        if ($request->password) {
            $update_user->password = $request->password;
        }

        $update_user->update();


        return redirect()->route('users.index')
                ->with('success', 'User updated successfully.');
    }

    public function destroyUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $user = User::find($request->user_id);

        $user->delete();

        return redirect()->route('users.index')
                ->with('success', 'User deleted successfully.');
    }

    //mobileInterfaceLogin
       //mobileInterfaceLogin
       public function mobileInterfaceLogin(Request $request)
       {
           //Input Validation
           $this->validate($request,
                   [
                       'smartPhoneId' => 'required',
                       'username' => 'required',
                       'password' => 'required'
                   ]);
   
            
            $user = User::where('email', $request->username)->get()->toArray();

            if (sizeof($user) == 1) {

                if (Auth::attempt(array(
                    'email' => $request->username, 
                    'password' => $request->password))) {

                    //Valid User Then Verify Device ID
                    $device = Device::where([
                        ['user_id', '=', $user['0']['id'] ],
                        ])->get()->toArray();

                    if (sizeof($device) != 0) {

                        //Get API Keys
                        $apiKeyQ = SMSAPIKey::where([
                                ['user_id', '=', $user['0']['id'] ],
                                ['device_id', '=', $device['0']['id'] ]
                                ])->get()->toArray();
                        
                        if (sizeof($apiKeyQ) == 1) {
                            return response()->json(
                                array('status' => True, 
                                'apiKey' => $apiKeyQ['0']['api_key']), 
                                200);
                        }else {
                            return response()->json(array(
                                'status' => False, 
                                'message_code' => 'No API Key Generated'), 
                                200);
                        }

                    }else {
                        return response()->json(array(
                            'status' => False, 
                            'message_code' => 'INVALID_DEVICE_ID'), 
                        200);
                    }

                }else {
                    return response()->json(array(
                        'status' => False, 
                        'message_code' => 'INVALID_CRED'), 
                    200);
                }

            }else {
                return response()->json(array(
                    'status' => False, 
                    'message_code' => 'INVALID_CRED'), 
                200);

            }
         
       }
}
