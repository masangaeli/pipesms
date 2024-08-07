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
                                        <button class="btn btn-primary form-control">Add to Group</button>
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

@endsection
