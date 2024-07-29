@extends('layouts.admin_lte')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Messages</div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Full Name</td>
                            <td>Message Content</td>
                            <td>Message Status</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{ $id += 1 }}</td>
                            <td>{{ $message->fullName }}</td>
                            <td>{{ $message->messageContent }}</td>
                            <td>{{ $message->messageStatus }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $messages->paginate()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
