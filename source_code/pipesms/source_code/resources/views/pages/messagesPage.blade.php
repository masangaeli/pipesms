@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                <div class="row container-fluid">
                    <div class="col-6"> 
                        <h3>Messages ({{ $total_messages }})</h3>
                    </div>
            
                    <div class="col-6 text-align-right"> 
                        <button class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#newSingleMessageModal">New Single Message</button>

                        <button class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#newGroupMessageModal">New Group Message</button>
                    </div>
                </div>
                <hr/>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Full Name</td>
                            <td>Message Content</td>
                            <td>Sent Status</td>
                            <td>Delivery Report Status</td>
                        </tr>
                    </thead>

                    <tbody>
                        @php $id = 0; @endphp
                        @foreach($messages as $message)
                        <tr>
                            <td>{{ $id += 1 }}</td>
                            <td>{{ @$message->contact->first_name }} {{ @$message->contact->last_name }}</td>
                            <td>{{ $message->message_data }}</td>
                            <td>{{ $message->sent_status == "0" ? "Sent" : "Not Sent" }}</td>
                            <td>{{ $message->dlr_report == "0" ? "Delivered" : "Not Delivered" }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $messages->links()}}
                </div>
            </div>
        </div>
    </div>
</div>


 <!-- New Single Message Modal -->
 <div class="modal fade" id="newSingleMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Single Message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('messages.new_single') }}" method="POST">
                @csrf
        
                <div>
                    <strong>Phone Contact:</strong>
                    <select name="contact_id" class="form-control">
                        @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}">
                            {{ $contact->first_name }} {{ $contact->last_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
        
                <br/>

                <div>
                    <strong>Message Content:</strong>
                    <textarea name="message_content" class="form-control">{{ old('message_content') }}</textarea>
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



   <!-- New Multiple Messages Modal -->
 <div class="modal fade" id="newGroupMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Group Message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('messages.new_single') }}" method="POST">
                @csrf
        
                <div>
                    <strong>Group Title:</strong>
                    <select name="group_id" class="form-control">
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">
                            {{ $group->group_title }}
                        </option>
                        @endforeach
                    </select>
                </div>
        
                <br/>

                <div>
                    <strong>Message Content:</strong>
                    <textarea name="message_content" class="form-control">{{ old('message_content') }}</textarea>
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

@endsection
