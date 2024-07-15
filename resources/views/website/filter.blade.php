@extends('layouts.master')

@section('body')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- inner banner Start -->
    <section class="inner-slider ">
        <div class="container">
            <h2 class="title">Weather Info</h2>
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
        tbody tr:hover{
            background-color: #b3c7d6ad;
            box-shadow: #D3D3D3 -1px 1px, #D3D3D3 -2px 2px, #D3D3D3 -3px 3px, #D3D3D3 -4px 4px, #D3D3D3 -5px 5px, #D3D3D3 -6px 6px;
            transform: translate3d(6px, -6px, 0);
            transition-delay: 0s;
            transition-duration: 0.4s;
            transition-property: all;
        }
    </style>

    <!-- Contact area Start -->
    <section class="contact p-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="contact-block bg-white-1">
                    <form action="{{route('filter')}}" id="filterform" method="GET">
                   
                        <div class="row mb-4">

                                <div class="col-lg-3 col-12">
                                    <div class="form-group">
                                        <label class="text-dark">Select Start Date</label>
                                        <input type="datetime-local" class="form-control p-2" id="start_date" placeholder="Select start date" name="start_date" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <div class="form-group">
                                        <label class="text-dark">Select End Date</label>
                                        <input type="datetime-local" class="form-control p-2" id="end_date" placeholder="Select end date" name="end_date" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="col-lg-2 col-12">
                                    <div class="form-group">
                                        <label class="text-dark">Select Location</label>
                                        <select class="form-select" id="location" name="location">
                                            <option value="">Select All</option>
                                            @foreach($locations as $location)
                                            <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12">
                                    {{-- <div style="visibility: hidden"></div> --}}
                                    <div class="d-flex mt-4">
                                        <button type='button' class="btn btn-primary" id="search">Search</button>
                                        &nbsp;
                                        <button type='button' class="btn btn-success" id="export">Export As Excel</button>
                                        &nbsp;
                                        <button type='button' class="btn btn-warning text-white" id="pdf">PDF</button>
                                    </div>
                                </div>

                        </div>
                    </form>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center" id="datatable">
                                <thead class="table-info">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Rain</th>
                                        <th>Wind Speed</th>
                                        <th>Temperature</th>
                                        <th>Low Temperature</th>
                                        <th>Hi Temperature</th>
                                        <th>Humidity</th>
                                        <th>Progressive Rain(From 8:30 AM)</th>
                                        <th>Last 24 Hours Rain</th>
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

            // $("#start_date").datepicker({
            //     dateFormat: "dd-mm-yy",
            //     maxDate: 0,
            //     onSelect: function (date) {
            //         var date2 = $('#start_date').datepicker('getDate');
            //         date2.setDate(date2.getDate());
            //         var start_date = $('#start_date').val();
            //         var end_date = $('#end_date').val();
            //         if(start_date > end_date)
            //         {
            //             $('#end_date').datepicker('setDate', date2);
            //         }
            //         //sets minDate to start_date date + 1
            //         $('#end_date').datepicker('option', 'minDate', date2);
            //     }
            // });
            // $('#end_date').datepicker({
            //     dateFormat: "dd-mm-yy",
            //     onClose: function () {
            //         var start_date = $('#start_date').datepicker('getDate');
            //         var end_date = $('#end_date').datepicker('getDate');
            //         //check to prevent a user from entering a date below date of start_date
            //         if (end_date < start_date) {
            //             var minDate = $('#end_date').datepicker('option', 'minDate');
            //             $('#end_date').datepicker('setDate', minDate);
            //         }
            //     }
            // });

            $('#search').click(function(){
                let startDate = $('#start_date').val()
                let endDate = $('#end_date').val()
                let location = $('#location').val()
                $('#datatable').DataTable().destroy();
                
                getWeatherDetails(startDate, endDate, location)
            });

            $('#export').click(function(){
                let startDate = $('#start_date').val()
                let endDate = $('#end_date').val()
                let location = $('#location').val()
                let filter = $('#filterform').serialize();
                window.location.href = "{{ url('export') }}?"+filter;
            });

            $('#pdf').click(function(){
                let startDate = $('#start_date').val()
                let endDate = $('#end_date').val()
                let location = $('#location').val()
                let filter = $('#filterform').serialize();
                window.open("{{ url('weather-pdf') }}?" + filter, '_blank');
                // window.location.href = "{{ url('weather-pdf') }}?"+filter;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatablenew').dataTable({
                pageLength: 10,
                // info: false,
                lengthChange: false,
                filter: false
            });
            function getWeatherDetails(start_date, end_date, location){
                $('#datatable').dataTable({
                    pageLength: 10,
                    // info: false,
                    lengthChange: false,
                    filter: false,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('/filter') }}",
                        method: "post",
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
                            name: 'locations.name',
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
                            data: 'time',
                            name: 'weathers.time',
                            render: function(data, type, row){
                                 return data;
                            },
                        },
                        {
                            data: 'rain',
                            name: 'weathers.rain',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        },
                        {
                            data: 'wind_speed',
                            name: 'weathers.wind_speed',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        },
                        {
                            data: 'in_temp',
                            name: 'weathers.in_temp',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        },
                        {
                            data: 'low_temp',
                            name: 'weathers.low_temp',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        },
                        {
                            data: 'hi_temp',
                            name: 'weathers.hi_temp',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        },
                        {
                            data: 'in_hum',
                            name: 'weathers.in_hum',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        },
                        {
                            data: 'prograsive_rain',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        },
                        {
                            data: 'lastday',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        }
                    ]
                });
            }

            getWeatherDetails($('#start_date').val(), $('#end_date').val(), "")
        })
    </script>
@endpush
