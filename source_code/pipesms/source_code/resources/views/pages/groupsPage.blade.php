@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row container-fluid">
        <div class="col-6"> 
            <h3>Groups ({{ $total_groups }})</h3>
        </div>

        <div class="col-6 text-align-right"> 
            <button class="btn btn-primary"
            data-bs-toggle="modal" data-bs-target="#newGroupModal">New Group</button>
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
                            <td>Group Title</td>
                            <td>Group Info</td>
                            <td>Group Contacts</td>
                            <td>Actions</td>
                        </tr>
                    </thead>

                    <tbody>
                        @php $id = 0; @endphp
                        @foreach($groups as $group)
                        <tr>
                            <td>{{ $id += 1 }}</td>
                            <td>{{ $group->group_title }}</td>
                            <td>{{ $group->group_info }}</td>
                            <td>
                                <button class="btn btn-primary form-control"
                                data-bs-toggle="modal" data-bs-target="#groupContactsModal"
                                >Group Contacts</button>
                            </td>
                            <td>
                                <div class="row container">    
                                    <div class="col-md-6">
                                        <button class="btn btn-success form-control" 
                                        onclick="showEditModal('{{ $group->id }}', '{{ $group->group_title }}',
                                        '{{ $group->group_info }}')">Edit</button>
                                    </div>
            
                                    <div class="col-md-6">
                                        <form action="{{ route('groups.destroy') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="group_id" value="{{ $group->id }}">
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
                    {{ $groups->links()}}
                </div>
            </div>
        </div>
    </div>

</div>





  <!-- Group Contacts Modal -->
  <div class="modal fade" id="groupContactsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Group Contacts</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- New Group Modal -->
  <div class="modal fade" id="newGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('groups.store') }}" method="POST">
                @csrf
        
                <div>
                    <strong>Group Title:</strong>
                    <input type="text" class="form-control" name="group_title" value="{{ old('group_title') }}">
                </div>
        
                <br/>

                <div>
                    <strong>Group Info:</strong>
                    <textarea name="group_info" class="form-control">{{ old('group_info') }}</textarea>
                </div>

                </br/>
        
                <div>
                    <input type="hidden" name="user_id" value="{{ Auth::User()->id }}">
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


    <!-- Edit Group Modal -->
    <div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('groups.update') }}" method="POST">
                    @csrf
            
                    <div>
                        <strong>Group Title:</strong>
                        <input type="text" class="form-control" id="editGroupTitle" name="group_title" value="{{ old('group_title') }}">
                    </div>
            
                    <br/>
    
                    <div>
                        <strong>Group Info:</strong>
                        <textarea name="group_info" id="editGroupInfo" class="form-control">{{ old('group_info') }}</textarea>
                    </div>
    
                    </br/>
            
                    <div>
                        <input type="hidden" name="group_id" id="group_id_update" value="">
                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}">
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

    function showEditModal(groupId, groupTitle, groupInfo)
    {
        $("#group_id_update").val(groupId)
        $("#editGroupTitle").val(groupTitle)
        $("#editGroupInfo").val(groupInfo)

        $("#editGroupModal").modal('show');
    }

  </script>

@endsection
