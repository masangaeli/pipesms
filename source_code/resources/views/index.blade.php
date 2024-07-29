@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-align-center">
            
            <div class="flex lg:justify-center lg:col-start-2">
                <img src="{{ asset('pics/pipesms_logo.webp') }}" style="width: 300px;" alt="Pipe SMS">
            
                <hr/>
                    <h3>Pipe SMS</h3>
                    <p>Welcome to the PipeSMS platform. This platform allows you to send SMS messages to multiple groups at once and monitor their delivery status.</p>

                    <br/><br/>
                    <code>Platform Version: 1.0.0</code>
            </div>

        </div>
    </div>
</div>
@endsection
