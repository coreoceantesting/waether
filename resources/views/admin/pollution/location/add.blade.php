@extends('layouts.admin')

@section('title')
Add Pollution Location
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header">Add Pollution Location</div>
  
                <div class="card-body">
                    <form action="{{ url('admin/pollution/location/store') }}" method="POST">
                        @csrf
                        <label>Location</label>
                        <input required="" type="text" name="name" class="form-control">
                        <br>
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <br>
                        <a href="{{url('admin/pollution/location/list')}}" class="btn btn-primary"> Cancel </a>
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