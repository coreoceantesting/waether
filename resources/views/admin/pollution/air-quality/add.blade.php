@extends('layouts.admin')

@section('title')
{{ $locationName }} / Add Air Quality
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header"><a href="{{ url('admin/pollution/location/'.Request()->location.'/air-quality/list') }}">{{ $locationName }}</a> / Add Air Quality</div>
  
                <div class="card-body">
                    <form action="{{ url('/admin/pollution/location/air-quality/store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="location_id" value="{{ Request()->location }}">
                        <label>Date</label>
                        <input required="" type="date" name="date" class="form-control">
                        <br>

                        <label>SO2(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" name="so2" class="form-control">
                        <br>

                        <label>NOx(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" name="nox" class="form-control">
                        <br>

                        <label>PM2.5(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" name="pm2" class="form-control">
                        <br>

                        <label>RSPM(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" name="rspm" class="form-control">
                        <br>

                        <label>CO(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" name="co" class="form-control">
                        <br>

                        <label>O3(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" name="o3" class="form-control">
                        <br>

                        <label>NH3(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" name="nh3" class="form-control">
                        <br>
                        <a href="{{url('/admin/pollution/location/'.Request()->location.'/air-quality/list')}}" class="btn btn-primary"> Cancel </a>
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