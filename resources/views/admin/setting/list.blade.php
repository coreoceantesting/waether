@extends('layouts.admin')

@section('title')
Setting
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" id="accordion">
            @include('admin.message')
            <div class="card">
                <div class="card-header" style="cursor: pointer;" data-toggle="collapse" href="#collapseOne">Weather Image</div>
  
                <div class="card-body collapse show" id="collapseOne" data-parent="#accordion">
                    
  
                    <form action="{{ url('/admin/setting') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Weather icon</th>
                                    <th>Weather Background Image</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Sunny Day
                                    </td>
                                    <td>
                                        <input type="hidden" name="config_name[]" value="sunny_day">
                                        <input type="file" name="icon[]" class="form-control" accept="image/*" />
                                    </td>
                                    <td>
                                        <input type="file" name="background_image[]" class="form-control" accept="image/*" />
                                    </td>
                                    <td>
                                        <select class="form-control" name="from[]">
                                            <option value="">Select Month</option>
                                            @foreach($months as $key => $month)
                                            <option @if(isset($setting[0]) && $setting[0]->from == $key)selected @endif value="{{ $key }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="to[]">
                                            <option value="">Select Month</option>
                                            @foreach($months as $key => $month)
                                            <option @if(isset($setting[0]) && $setting[0]->to == $key)selected @endif value="{{ $key }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Rainy Day
                                    </td>
                                    <td>
                                        <input type="hidden" name="config_name[]" value="rainy_day">
                                        <input type="file" name="icon[]" class="form-control" accept="image/*" />
                                    </td>
                                    <td>
                                        <input type="file" name="background_image[]" class="form-control" accept="image/*" />
                                    </td>
                                    <td>
                                        <select class="form-control" name="from[]">
                                            <option value="">Select Month</option>
                                            @foreach($months as $key => $month)
                                            <option @if(isset($setting[1]) && $setting[1]->from == $key)selected @endif value="{{ $key }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="to[]">
                                            <option value="">Select Month</option>
                                            @foreach($months as $key => $month)
                                            <option @if(isset($setting[1]) && $setting[1]->to == $key)selected @endif value="{{ $key }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Winter Day
                                    </td>
                                    <td>
                                        <input type="hidden" name="config_name[]" value="winter_day">
                                        <input type="file" name="icon[]" class="form-control" accept="image/*" />
                                    </td>
                                    <td>
                                        <input type="file" name="background_image[]" class="form-control" accept="image/*" />
                                    </td>
                                    <td>
                                        <select class="form-control" name="from[]">
                                            <option value="">Select Month</option>
                                            @foreach($months as $key => $month)
                                            <option @if(isset($setting[2]) && $setting[2]->from == $key)selected @endif value="{{ $key }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="to[]">
                                            <option value="">Select Month</option>
                                            @foreach($months as $key => $month)
                                            <option @if(isset($setting[2]) && $setting[2]->to == $key)selected @endif value="{{ $key }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" align="right">
                                        <a href="{{ url('admin/dashboard') }}" class="btn btn-danger">Cancel</a>
                                        <button class="btn btn-primary">Update</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </form>
  
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="cursor: pointer;" data-toggle="collapse" href="#collapseTwo">Dashboard Banner</div>
  
                <div class="card-body collapse" id="collapseTwo" data-parent="#accordion">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  
                    <form action="{{ url('/admin/setting/dashboard-banner') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="dashboard_banner" name="config_name">
                        <input type="file" class="form-control" required name="banner_image" />
                        <br>
                        <a href="{{ url('admin/dashboard') }}" class="btn btn-danger">Cancel</a>
                        <button class="btn btn-primary">Save</button>

                    </form>
  
                </div>

            </div>

        </div>
    </div>
</div>
  @endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js" defer></script>



@stop