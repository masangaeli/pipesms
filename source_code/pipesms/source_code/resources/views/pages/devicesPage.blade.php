@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row container-fluid">
        <div class="col-6"> 
            <h3>Devices ({{ $total_devices }})</h3>
        </div>

        <div class="col-6 text-align-right"> 
            <button class="btn btn-primary"
            data-bs-toggle="modal" data-bs-target="#newDeviceModal">New Device</button>
        </div>
    </div>
    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Device ID</td>
                            <td>Device User</td>
                            <td>Device Title</td>
                            <td>Device Info</td>
                            <td>Actions</td>
                        </tr>
                    </thead>

                    <tbody>
                        @php $id = 0; @endphp
                        @foreach($devices as $device)
                        <tr>
                            <td>{{ $id += 1 }}</td>
                            <td>{{ $device->id }}</td>
                            <td>{{ @$device->user->first_name }} {{ @$device->user->last_name }}</td>
                            <td>{{ $device->device_title }}</td>
                            <td>{{ $device->device_info }}</td>
                          
                            <td>
                                <div class="row container">    
                                    <div class="col-md-6">
                                        <button class="btn btn-success form-control" 
                                        onclick="showEditModal('{{ $device->id }}', '{{ $device->device_title }}',
                                        '{{ $device->device_info }}')">Edit</button>
                                    </div>
            
                                    <div class="col-md-6">
                                        <form action="{{ route('devices.destroy') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="device_id" value="{{ $device->id }}">
                                            <button class="btn btn-danger form-control" type="submit">Delete</button>
                                        </form>
                                    </div>
            
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $devices->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





  <!-- New Device Modal -->
  <div class="modal fade" id="newDeviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Device</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('devices.store') }}" method="POST">
                @csrf


                <div>
                    <strong>Device User:</strong>
                    <select class="form-select" name="user_id">
                        @foreach($level3Users as $level3User)
                        <option value="{{ $level3User->id }}">
                            {{ $level3User->first_name }} {{ $level3User->last_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <br/>
        
                <div>
                    <strong>Device Title:</strong>
                    <input type="text" class="form-control" name="device_title" value="{{ old('device_title') }}">
                </div>
        
                <br/>

                <div>
                    <strong>Device Info:</strong>
                    <textarea name="device_info" class="form-control">{{ old('device_info') }}</textarea>
                </div>

                </br/>
        
                <div>
                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


    <!-- Edit Device Modal -->
    <div class="modal fade" id="editDeviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Device</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('devices.update') }}" method="POST">
                    @csrf
                    
                    <div>
                        <strong>Device User:</strong>
                        <select class="form-select" name="user_id">
                            @foreach($level3Users as $level3User)
                            <option value="{{ $level3User->id }}">
                                {{ $level3User->first_name }} {{ $level3User->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <br/>

                    <div>
                        <strong>Device Title:</strong>
                        <input type="text" class="form-control" id="editDeviceTitle" name="device_title" value="{{ old('device_title') }}">
                    </div>
            
                    <br/>
    
                    <div>
                        <strong>Group Info:</strong>
                        <textarea name="device_info" id="editDeviceInfo" class="form-control">{{ old('device_info') }}</textarea>
                    </div>
    
                    </br/>
            
                    <div>
                        <input type="hidden" name="device_id" id="device_id_update" value="">
                        <button type="submit" class="btn btn-primary form-control">Submit</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>




  <script type="text/javascript">

    function showEditModal(deviceId, deviceTitle, deviceInfo)
    {
        $("#device_id_update").val(deviceId)
        $("#editDeviceTitle").val(deviceTitle)
        $("#editDeviceInfo").val(deviceInfo)

        $("#editDeviceModal").modal('show');
    }

  </script>

@endsection
