@extends('layouts.admin')

@section('title')
Send Message
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header">Send Message</div>
  
                <div class="card-body">
                    @include('admin.message')
  
                  <div class="card-body">
                    <form action="{{ url('admin/contact/send-message') }}" method="POST">
                        @csrf
                        <label>Subject</label>
                        <input required="" type="text" rows="5" name="subject" class="form-control">
                        <br>
                        <label>Message</label>
                        <textarea required="" rows="5" name="message" class="form-control"></textarea>
                        <br>
                        <button class="btn btn-success"> Send </button>
                    </form>
                 </div>
  
                </div>
            </div>
       <!--  </div> -->
    </div>
    </div>
</div>
  @endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js" defer></script>



@stop