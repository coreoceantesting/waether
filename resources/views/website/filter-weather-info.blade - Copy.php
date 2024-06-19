@extends('layouts.master')

@section('body')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <style>
        #datatablenew_paginate{
            display: flex;
            justify-content: end;
        }
    </style>
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

    <!-- Contact area Start -->
    <section class="contact p-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="contact-block bg-white-1">
                    <form action="{{route('filterweatherinfo')}}" method="GET">
                    <!-- @csrf -->
                        <div class="row mb-4">

                                <div class="col-lg-3 col-12">
                                    <div class="form-group">
                                        <center><input type="text" class="form-control" 
                                        value="{{isset(Request()->start_date) ? date('d-m-Y', strtotime(Request()->start_date)) : date('d-m-Y')}}" autocomplete="off"  id="start_date" placeholder="Select start date" name="start_date" />
                                      </center>
                                    </div>
                                </div>
                               
                                <div class="col-lg-2 col-12">
                                    <button type='submit' class="btn btn-primary" id="search">Search</button>
                                </div>

                        </div>
                    </form>
                        <div>
                            <table class="table table-bordered overflow-hidden" id="datatablenew">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <!-- <th>Rain</th> -->
                                        <!-- <th>Wind Speed</th> -->
                                        <th>Total</th>
                                        <th>Rain</th>
                                        <th>Current</th>
                                        <th>Progressive Rain(From 8:30 AM)</th>
                                        <th>Last 24 Hours Rain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($weathers))
                                   @php  $sum=0; @endphp
                                   @php $lasthour = round(DB::table('weathers')->where('date', date('Y-m-d', strtotime('-1 days', strtotime(Request()->start_date))))->avg('rain'), 2);
                                        $totalRain = round(DB::table('weathers')->whereYear('date', date('Y'))->avg('rain'), 2);
                                    @endphp
                                    @foreach($weathers as $data)
                                     <tr>
                                        <th>{{ date('d-m-Y', strtotime($data->date))  }}</th>
                                        <th>{{ date('h:i A', strtotime($data->time))  }}</th>
                                        <td>
                                            @php $sum += $data->rain; @endphp
                                             {{ $totalRain }}
                                        </td>    
                                        
                                        <td> {{ $data->rain  }}</td>
                                        <td> {{ round($data->current_rain,3)  }}</td>
                                        <td> {{ round($data->current_rain,3) }} </td>     
                                        
                                        <td>
                                           {{$lasthour}}
                                        </td>
                                     </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">There are no data.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{-- {!! $weathers->links() !!} --}}
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
                $('#datatable').DataTable().destroy();
                getWeatherDetails(startDate, endDate, location)
            })
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('#datatablenew').dataTable({
                pageLength: 20,
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
                            data: 'in_hum',
                            name: 'weathers.in_hum',
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
                            data: 'in_hum',
                            name: 'weathers.in_hum',
                            render: function(data, type, row){
                                 return data+"mm";
                            },
                        }
                    ]
                });
            }

            // getWeatherDetails({{date('Y-m-d')}}, {{date('Y-m-d')}}, "")
        })
    </script>
@endpush
