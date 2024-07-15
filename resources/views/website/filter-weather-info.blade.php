@extends('layouts.master')

@section('body')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <style>
        #datatablenew_paginate{
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
    <!-- inner banner Start -->
    <section class="inner-slider ">
        <div class="container">
            <h2 class="title">Avarage Weather Info</h2>
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
                        <form action="" method="GET">
                        
                            <div class="row mb-4">

                                    <div class="col-lg-3 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{isset(Request()->start_date) ? date('d-m-Y', strtotime(Request()->start_date)) : date('d-m-Y')}}" autocomplete="off"  id="start_date" placeholder="Select start date" name="start_date" />
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-2 col-12">
                                        <button type='submit' class="btn btn-primary" id="search">Search</button>
                                    </div>

                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-striped" id="datatablenew">
                                <thead class="table-info">
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Total Rain</th>
                                        <th>Current Rain</th>
                                        <th>Prograsive Rain(From 8.30 AM)</th>
                                        <th>Last 24 Hours Rain</th>
                                        @foreach($locations as $location)
                                        <th>{{ $location->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; $sum = $totalRain;$locationData = []; @endphp
                                    @foreach($weatherLocations as $key => $weather)

                                    @php $i = 0;$current = 0;$decrement = count($locations); @endphp
                                    @foreach($weather as $data)
                                    @php $locationData[$i] = round($data->rain, 2); @endphp
                                    @if($i == count($locations))
                                        @break
                                    @endif
                                    @php 
                                        $sum = $sum + $data->rain; 
                                        $current = $current + $data->rain; 
                                        $i = $i + 1; 
                                        $decrement = $decrement - 1;
                                    @endphp
                                    @endforeach


                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ date('d-m-Y', strtotime($key)) }}</td>
                                        <td>{{ date('h:i A', strtotime($key)) }}</td>
                                        <td>{{ $sum }}mm</td>
                                        <td>{{ round($current/count($locations), 2) }}mm</td>
                                        <td>{{ round($weathers->where('datetime', '>=', date('Y-m-d H:i:s', strtotime(Request()->start_date.' 08:30:00')))->where('datetime', '<=', date('Y-m-d H:i:s', strtotime($key)))->avg('rain'), 2) }}mm</td>
                                        <td>{{ round($lastDay, 2) }}mm</td>
                                        


                                        @for($k=0;$k<$i;$k++)
                                        <td>{{ $locationData[$k] }}</td>
                                        @endfor


                                        @for($j=1; $j < $decrement+1; $j++)
                                        <td>0mm</td>
                                        @endfor

                                    </tr>
                                    @endforeach
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
        });

        $("#start_date").datepicker({
            dateFormat: "dd-mm-yy",
            maxDate: 0
        });

        $('#datatablenew').dataTable({
            pageLength: 15,
            sorting: false,
            lengthChange: false,
            filter: false
        });
    </script>
@endpush
