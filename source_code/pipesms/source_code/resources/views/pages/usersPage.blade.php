@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                <div class="row container-fluid">
                    <div class="col-6"> 
                        <h3>Users ({{ $total_users }})</h3>
                    </div>
            
                    <div class="col-6 text-align-right"> 
                        <button class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#newUserModal">New User</button>
                    </div>
                </div>
                <hr/>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>First Name</td>
                            <td>Last Name</td>
                            <td>Email</td>
                            <td>Level</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    <tbody>
                        @php $id = 0; @endphp
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $id += 1 }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->level }}</td>
                            <td>
                                <div class="container-fluid row">
                                    <div class="col-4">
                                        <a href="{{ route('devices.index', ['user_id' => $user->id]) }}" target="_blank">
                                        <button class="btn btn-primary form-control">Manage Devices</button>
                                        </a>
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-success form-control" 
                                        onclick="showEditModal('{{ $user->id }}', '{{ $user->first_name }}',
                                        '{{ $user->last_name }}', '{{ $user->email }}')">Edit</button>
                                    </div>


                                    <div class="col-4">
                                        <form action="{{ route('users.destroy') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
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
                    {{ $users->links()}}
                </div>
            </div>
        </div>
    </div>
</div>



  <!-- New User Modal -->
  <div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
        
                <div>
                    <strong>First Name:</strong>
                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                </div>
        
                <br/>

                <div>
                    <strong>Last Name:</strong>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                </div>
        
                <br/>

                <div>
                    <strong>Email:</strong>
                    <input type="email" name="email" class="form-control">{{ old('email') }}</input>
                </div>

                <br/>

                <div>
                    <strong>Password:</strong>
                    <input type="text" name="password" class="form-control">{{ old('password') }}</input>
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


   <!-- Edit User Modal -->
   <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('users.update') }}" method="POST">
                @csrf
        
                <div>
                    <strong>First Name:</strong>
                    <input type="text" class="form-control" id="edit_first_name" name="first_name" value="{{ old('first_name') }}">
                </div>
        
                <br/>

                <div>
                    <strong>Last Name:</strong>
                    <input type="text" class="form-control" id="edit_last_name" name="last_name" value="{{ old('last_name') }}">
                </div>
        
                <br/>

                <div>
                    <strong>Email:</strong>
                    <input type="email" name="email" id="edit_email" class="form-control">{{ old('email') }}</input>
                </div>

                <br/>

                <div>
                    <strong>Password:</strong>
                    <input type="text" name="password" class="form-control">{{ old('password') }}</input>
                </div>

                </br/>
        
                <div>
                    <input type="hidden" name="user_id" id="user_id_update" value="">
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

    function showEditModal(userId, firstName, lastName, email)
    {
        $("#user_id_update").val(userId)
        $("#edit_first_name").val(firstName)
        $("#edit_last_name").val(lastName)
        $("#edit_email").val(email)

        $("#editUserModal").modal('show');
    }

  </script>


@endsection

