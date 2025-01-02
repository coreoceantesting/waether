@extends('layouts.admin')

@section('title')
{{ $locationName }} / Edit Air Quality
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header"><a href="{{ url('admin/pollution/location/'.Request()->location.'/air-quality/list') }}">{{ $locationName }}</a> / Edit Air Quality</div>
  
                <div class="card-body">
                    <form action="{{ url('/admin/pollution/location/air-quality/update') }}" method="POST">
                        @csrf

                        <input type="hidden" name="location_id" value="{{ Request()->location }}">
                        <input type="hidden" name="id" value="{{ $airQuality->id }}">
                        <label>Date</label>
                        <input required="" type="date" name="date" value="{{ $airQuality->date }}" class="form-control">
                        <br>

                        <label>SO2(μg/m3)</label>
                        <input required="" type="number" value="{{ $airQuality->so2 }}" min="0" step="any" name="so2" class="form-control">
                        <br>

                        <label>NOx(μg/m3)</label>
                        <input required="" type="number" value="{{ $airQuality->nox }}" min="0" step="any" name="nox" class="form-control">
                        <br>

                        <label>PM2.5(μg/m3)</label>
                        <input required="" type="number" min="0" step="any" value="{{ $airQuality->pm2 }}" name="pm2" class="form-control">
                        <br>

                        <label>PM10(μg/m3)</label>
                        <input required="" type="number" value="{{ $airQuality->pm10 }}" min="0" step="any" name="pm10" class="form-control">
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