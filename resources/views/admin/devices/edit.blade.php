@extends('layouts.admin')

@section('title')
Edit Device
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header">Edit Device</div>
  
                  <div class="card-body">
                    <form action="{{ url('admin/device/update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $device->id }}">
                        <label>Name</label>
                        <input required="" type="text" name="name" value="{{ $device->name }}" class="form-control">
                        <br>
                        <label>Path</label>
                        <input required="" type="text" name="path" value="{{ unserialize($device->path) }}" class="form-control">
                        <br>
                        <label>Graph Title</label>
                        <input required="" type="text" name="graph_title" value="{{ $device->graph_title }}" class="form-control">
                        <br>
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="1" @if($device->status == 1)selected @endif>Active</option>
                            <option value="0" @if($device->status == 0)selected @endif>Inactive</option>
                        </select>
                        <br>
                        <a href="{{url('admin/device/list')}}" class="btn btn-primary"> Cancel </a>
                        <button class="btn btn-success"> Update </button>

                        

                    </form>
  
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