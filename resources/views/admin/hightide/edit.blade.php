@extends('layouts.admin')

@section('title')
Edit Hightide
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header">Edit Hightide</div>
  
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  
                  <div class="card-body">
                    <form action="{{ url('/admin/hightide/update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $hightide->id }}">
                        <label>Date</label>
                        <input required="" type="date" value="{{ date('Y-m-d', strtotime($hightide->date)) }}" name="date" class="form-control">
                        <br>
                        <label>Time</label>
                        <input required="" type="time" value="{{ date('H:i', strtotime($hightide->time)) }}" name="time" class="form-control">
                        <br>
                        <label>Height</label>
                        <input required="" type="number" value="{{ $hightide->height }}" name="height" class="form-control">
                        <br>
                        <label>Message</label>
                        <textarea required="" name="message" class="form-control">{{ $hightide->message }}</textarea>
                        <br>
                        <a href="{{url('admin/dashboard')}}" class="btn btn-primary"> Cancel </a>
                        <button class="btn btn-success"> Update </button>

                        

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