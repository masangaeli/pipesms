@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                <div class="row container-fluid">
                    <div class="col-6"> 
                        <h3>Contacts ({{ $total_contacts }})</h3>
                    </div>
            
                    <div class="col-6 text-align-right"> 
                        <button class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#newContactModal">New Contact</button>
                    </div>
                </div>

                <hr/>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>First Name</td>
                            <td>Last Name</td>
                            <td>Phone Number</td>
                            <td>Actions</td>
                        </tr>
                    </thead>

                    <tbody>
                        @php $id = 0; @endphp
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $id += 1 }}</td>
                            <td>{{ $contact->first_name }}</td>
                            <td>{{ $contact->last_name }}</td>
                            <td>{{ $contact->phone_number }}</td>
                            <td>
                                <div class="row container">      
                                    <div class="col-md-4">
                                        <button class="btn btn-primary form-control"
                                        onclick="set_contact_data('{{ $contact->id }}')"
                                        data-bs-toggle="modal" data-bs-target="#addToGroupModal">Add to Group</button>
                                    </div>  
                                    <div class="col-md-4">
                                        <button class="btn btn-success form-control" 
                                        onclick="showEditModal('{{ $contact->id }}', '{{ $contact->contact_title }}',
                                        '{{ $contact->contact_info }}')">Edit</button>
                                    </div>
            
                                    <div class="col-md-4">
                                        <form action="{{ route('contacts.destroy') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="contact_id" value="{{ $contact->id }}">
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
                    {{ $contacts->links()}}
                </div>
            </div>
        </div>
    </div>
</div>



  <!-- New Contact Modal -->
  <div class="modal fade" id="newContactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Contact</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
        
                <div>
                    <strong>First Name: <span class="required">*</span></strong>
                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                </div>
        
                <br/>


                <div>
                    <strong>Last Name: <span class="required">*</span></strong>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                </div>
        
                <br/>

                <div>
                    <strong>Phone Number: <span class="required">*</span></strong>
                    <input type="number" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                </div>
        
                <br/>


                <div>
                    <strong>Default Group:</strong>
                    <select name="default_group" class="form-control">
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->group_title }}</option>
                        @endforeach
                    </select>
                </div>
        
                <br/>

                
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



   <!-- Add Contact to Group Modal -->
   <div class="modal fade" id="addToGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Contact to Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Group Name</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="add_contact_to_group">

                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">

var add_to_group_contact_id = "";

function set_contact_data(contact_id) {
    add_to_group_contact_id = contact_id

    //Pull This User Groups List to Modal
    $.get("/api/v1/pull/user/groups?user_id={{ Auth::User()->id }}&contact_id="+contact_id, function (data) {
        var jsonData = JSON.parse(JSON.stringify(data));

        var groupsList = jsonData["groupsList"];

        $("#add_contact_to_group").html("");

        var id = 1;
        groupsList.forEach(function(group) {

            $('#add_contact_to_group').append(`
            
            <tr id='add_to_group_row_`+id+`'>
                <th>`+id+`</th>
                <th>`+group.group_title+`</th>
                <th>
                    <button class="btn btn-primary form-control"
                    onclick="add_contact_data_to_group('`+group.id+`', '`+contact_id+`', 'add_to_group_row_`+id+`')">
                        Add Contact
                    </button>
                </th>
            </tr>

            `);

            id += 1;
        })
    })
}


function add_contact_data_to_group(group_id, contact_id, data_id) {
    $.get('/api/v1/add/contact/to/group?user_id={{Auth::User()->id}}&group_id='+group_id+'&contact_id='+contact_id, function(data) {

        var jsonData = JSON.parse(JSON.stringify(data));
        
        if (jsonData['status'] == true) {
            
            $("#"+data_id).hide();
        }

    })
    
}

</script>

@endsection
