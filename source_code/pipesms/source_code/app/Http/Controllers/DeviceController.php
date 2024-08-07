<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Device;
use App\Models\User;
use App\Models\SMSAPIKey;

class DeviceController extends Controller
{
    //devicesPage
    public function devicesPage(Request $request)
    {
        $total_devices = Device::all()->count();
        $devicesList = Device::orderBy('created_at', 'desc')->paginate(24);
        $level3Users = User::where('level', 3)->get();


        if ($request->user_id) {
            $total_devices = Device::where('user_id', $request->user_id)->count();

            $devicesList = Device::where('user_id', $request->user_id)
                        ->orderBy('created_at', 'desc')->paginate(24);
        }


        return view('pages.devicesPage', [
            'level3Users' => $level3Users,
            'devices' => $devicesList,
            'total_devices' => $total_devices,
        ]);
    }

    public function storeDevice(Request $request)
    {
        $request->validate([
            'device_title' => 'required',
            'device_info' => 'nullable'
        ]);

        $device = Device::create($request->all());

        //generateApiKey
    
        //Check if APi Key Exists
        $checkAPIKey = SMSAPIKey::where([
                    ['user_id', $request->user_id],
                    ['device_id', $device->id]
                    ])->get()->toArray();

        if (sizeof($checkAPIKey) == 1) {
            //Regenerate
            $updateApiKey = SMSAPIKey::find($checkAPIKey['0']['id']);
            $updateApiKey->apiKey = substr(bcrypt($request->user_id . random_int(100, 9999) ), 10, 26);
            $updateApiKey->update();

        }else {
            //Generate New
            $newApiKey = new SMSAPIKey();
            $newApiKey->user_id = $request->user_id;
            $newApiKey->device_id = $device->id;
            $newApiKey->api_key = substr(bcrypt($request->user_id . random_int(100, 9999) ), 10, 16);
            $newApiKey->save();
        }


        return redirect()->route('devices.index')
                ->with('success', 'Device created successfully.');
    }


    public function updateDevice(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'device_title' => 'required',
            'device_info' => 'nullable'
        ]);

        $device = Device::find($request->device_id);

        $device->update($request->all());

        return redirect()->route('devices.index')
                ->with('success', 'Device updated successfully.');
    }

    public function destroyDevice(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
        ]);

        $device = Device::find($request->device_id);

        $device->delete();

        return redirect()->route('devices.index')
                ->with('success', 'Device deleted successfully.');
    }
}
