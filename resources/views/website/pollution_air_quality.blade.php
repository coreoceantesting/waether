@extends('layouts.master')

@section('body')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- inner banner Start -->
    <section class="inner-slider ">
        <div class="container">
            <h2 class="title">Air Quality Index</h2>
        </div>
        <div class='clouds'>
            <div class='clouds-1'></div>
            <div class='clouds-2'></div>
            <div class='clouds-3'></div>
        </div>
    </section>
    <!-- inner banner End -->
    
    <style>
        #datatable_paginate{
            display: flex;
            justify-content: end;
        }
        #datatable tbody tr:hover{
            background-color: #b3c7d6ad;
            box-shadow: #D3D3D3 -1px 1px, #D3D3D3 -2px 2px, #D3D3D3 -3px 3px, #D3D3D3 -4px 4px, #D3D3D3 -5px 5px, #D3D3D3 -6px 6px;
            transform: translate3d(6px, -6px, 0);
            transition-delay: 0s;
            transition-duration: 0.4s;
            transition-property: all;
        }
    </style>

    <!-- Contact area Start -->
    <section class="contact p-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="contact-block bg-white-1">
                    <form action="{{route('filter')}}" method="GET">
                   
                        <div class="row mb-4">

                                <div class="col-lg-3 col-12">
                                    <div class="form-group">
                                        <label class="text-dark">Select Start Date</label>
                                        <input type="text" class="form-control" value=""  id="start_date" placeholder="Select start date" name="start_date" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <div class="form-group">
                                        <label class="text-dark">Select End Date</label>
                                        <input type="text" class="form-control" value="" id="end_date" placeholder="Select end date" name="end_date" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="col-lg-3 col-12">
                                    <div class="form-group">
                                        <label class="text-dark">Select Location</label>
                                        <select class="form-select" id="location" name="location">
                                            <option value="">Select All</option>
                                            @foreach($locations as $location)
                                            <option @if($location->id == base64_decode(Request()->id))selected @endif value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-12">
                                    <div style="visibility: hidden;">Filter</div>
                                    <button type='button' class="btn btn-primary" id="search">Search</button>
                                </div>

                        </div>
                    </form>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead class="table-info">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>SO2(ug/m3)</th>
                                        <th>Nox(ug/m3)</th>
                                        <th>PM10(ug/m3)</th>
                                        <th>PM2.5(ug/m3)</th>
                                        <th>AQI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact area End -->

@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function(){

            $("#start_date").datepicker({
                dateFormat: "dd-mm-yy",
                maxDate: 0,
                onSelect: function (date) {
                    var date2 = $('#start_date').datepicker('getDate');
                    date2.setDate(date2.getDate());
                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                    if(start_date > end_date)
                    {
                        $('#end_date').datepicker('setDate', date2);
                    }
                    //sets minDate to start_date date + 1
                    $('#end_date').datepicker('option', 'minDate', date2);
                }
            });
            $('#end_date').datepicker({
                dateFormat: "dd-mm-yy",
                onClose: function () {
                    var start_date = $('#start_date').datepicker('getDate');
                    var end_date = $('#end_date').datepicker('getDate');
                    //check to prevent a user from entering a date below date of start_date
                    if (end_date < start_date) {
                        var minDate = $('#end_date').datepicker('option', 'minDate');
                        $('#end_date').datepicker('setDate', minDate);
                    }
                }
            });

            $('#search').click(function(){
                let startDate = $('#start_date').val()
                let endDate = $('#end_date').val()
                let location = $('#location').val()
                // let id = "{{ Request()->id }}"
                $('#datatable').DataTable().destroy();
                
                getPollutionAirQuality(startDate, endDate, location)
            })
            function getPollutionAirQuality(start_date, end_date, location){
                // alert(start_date)
                // alert(end_date)
                $('#datatable').dataTable({
                    pageLength: 10,
                    // info: false,
                    lengthChange: false,
                    filter: false,
                    processing: true,
                    serverSide: true,
                    'bAutoWidth' : false,
                    ajax: {
                        url: "{{ url('/pollution-air-quality') }}",
                        method: "get",
                        data:{start_date:start_date, end_date:end_date, location:location},
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'name',
                            name: 'pollution_locations.name',
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'date',
                            name: 'weathers.date',
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'so2',
                            name: 'so2',
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'nox',
                            name: 'nox',
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'pm10',
                            name: 'pm10',
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'pm2',
                            name: 'pm2',
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'aqi',
                            name: 'aqi',
                            render: function(data, type, row){
                                 return data;
                            },
                        }
                    ]
                });
            }

            getPollutionAirQuality($('#start_date').val(), $('#end_date').val(), $('#location').val())
        })
    </script>
@endpush
