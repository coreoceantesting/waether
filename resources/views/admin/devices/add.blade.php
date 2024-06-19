@extends('layouts.admin')

@section('title')
Add Device
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header">Add Device</div>
  
                <div class="card-body">
                    <form action="{{ url('admin/device/store') }}" method="POST">
                        @csrf
                        <label>Name</label>
                        <input required="" type="text" name="name" class="form-control">
                        <br>
                        <label>Path</label>
                        <input required="" type="text" name="path" class="form-control">
                        <br>
                        <label>Graph Title</label>
                        <input required="" type="text" name="graph_title" class="form-control">
                        <br>
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <br>
                        <a href="{{url('admin/device/list')}}" class="btn btn-primary"> Cancel </a>
                        <button class="btn btn-success"> Save </button>
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