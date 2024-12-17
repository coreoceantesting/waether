@extends('layouts.master')

@section('body')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- inner banner Start -->
    <section class="inner-slider py-3">
        <div class="container">
            <h2 class="title">Pollution Control Cell(PCC)</h2>
        </div>
        <div class='clouds'>
            <div class='clouds-1'></div>
            <div class='clouds-2'></div>
            <div class='clouds-3'></div>
        </div>
    </section>
    <!-- inner banner End -->
    <br>

    <!-- Contact area Start -->
    <section class="contact pb-100">

        
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8">
                    <h2>Graph</h2>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Air Monitoring Location</label>
                                <select class="form-control" id="airMonitoring">
                                    @foreach($locations as $location)
                                    <option value="{{$location->id}}">{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Select Pollutant</label>
                                <select class="form-control" id="selectPollutant">
                                    <option value='so2'>SO2</option>
                                    <option value='nox'>NOX</option>
                                    <option value='pm2'>PM2.5</option>
                                    <option value='rspm'>PM10</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="text-dark">Start Date</label>
                                <input type="text" class="form-control" value="{{date('d-m-Y', strtotime('-365 days'))}}"  id="start_date" placeholder="Select start date" name="start_date" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="text-dark">End Date</label>
                                <input type="text" class="form-control" value="{{date('d-m-Y')}}" id="end_date" placeholder="Select end date" name="end_date" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>&nbsp;</div>
                            <button class="btn btn-primary" id="searchGraph">Search</button>
                        </div>
                    </div>
                    <div id="aqigraph" style="width: 100%; height: 600px;"></div>
                </div>
                <div class="col-lg-4">
                    <h5>AQI Table</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background-color: skyblue;">
                                <th>AQI</th>
                                <th>Quality Classification</th>
                                <th>Remarks</th>
                                <th>Colour Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0-50</td>
                                <td>Minimal Impact</td>
                                <td>Good</td>
                                <td><div style="width: 50px;height: 20px;background: #0EB409;"></div></td>
                            </tr>
                            <tr>
                                <td>51-100</td>
                                <td>Minor breathing discomfort to sensitive people</td>
                                <td>Satisfactory</td>
                                <td><div style="width: 50px;height: 20px;background: #6AD067;"></div></td>
                            </tr>
                            <tr>
                                <td>101-200</td>
                                <td>Breathing discomfort to the people with lung, heart disease, children and older adults</td>
                                <td>Moderate</td>
                                <td><div style="width: 50px;height: 20px;background: #ffff00;"></div></td>
                            </tr>
                            <tr>
                                <td>201-300</td>
                                <td>Breathing discomfort to people on prolonged exposure</td>
                                <td>Poor</td>
                                <td><div style="width: 50px;height: 20px;background: #EF8B06;"></div></td>
                            </tr>
                            <tr>
                                <td>301-400</td>
                                <td>Respiratory illness to the people on prolonged exposure</td>
                                <td>Very Poor</td>
                                <td><div style="width: 50px;height: 20px;background: #F41212;"></div></td>
                            </tr>
                            <tr>
                                <td>>401</td>
                                <td>Respiratory effects even on healthy people</td>
                                <td>Severe</td>
                                <td><div style="width: 50px;height: 20px;background: #B60E0E;"></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-5">
                <h2>GOOD & BAD DAY</h2>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-dark">Start Date</label>
                        <input type="text" class="form-control" value="{{date('d-m-Y', strtotime('-365 days'))}}"  id="pie_start_date" placeholder="Select start date" name="start_date" autocomplete="off" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="text-dark">End Date</label>
                        <input type="text" class="form-control" value="{{date('d-m-Y')}}" id="pie_end_date" placeholder="Select end date" name="end_date" autocomplete="off" />
                    </div>
                </div>
                <div class="col-lg-3">
                    <div>&nbsp;</div>
                    <button class="btn btn-primary" id="searchPieGraph">Search</button>
                </div>
                <div class="col-lg-7">
                    <div id="piechart"></div>
                </div>
                <div class="col-lg-5">
                    <div id="aqiMonthWiseAverage" class="mt-5"></div>
                </div>
            </div>
            <div class="row">
                {{-- <div class="col-md-6">
                    <h5>AQI (Air Quality Index) Details:</h5>           
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background-color: cadetblue;">
                                <th>Parameters</th>
                                <th>Current</th>
                                <th>Avg 24 Hrs.</th>
                                <th>Limit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="warning">
                                <td>SO2(μg/m3)</td>
                                <td>{{ $climateMinMax->avg('so2') }}</td>
                                <td>{{ $climateMinMax->avg('so2') }}</td>
                                <td>80 μg/m3</td>
                            </tr>
                            <tr class="warning">
                                <td>NOx(μg/m3)</td>
                                <td>{{ $climateMinMax->avg('nox') }}</td>
                                <td>{{ $climateMinMax->avg('nox') }}</td>
                                <td>80 μg/m3</td>
                            </tr>
                            <tr class="warning">
                                <td>RSPM(μg/m3)</td>
                                <td>{{ $climateMinMax->avg('rspm') }}</td>
                                <td>{{ $climateMinMax->avg('rspm') }}</td>
                                <td>100 μg/m3</td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}
                
                {{-- <div class="col-md-6">
                    <h5>Today's Thane City - AQI: 34.63%</h5>           
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background-color: cadetblue;">
                                <th>Parameters</th>
                                <th>24hrs.Min</th>
                                <th>24Hrs Max</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="warning">
                                <td>SO2(μg/m3)</td>
                                <td>{{ $climateMinMax->min('so2') }}</td>
                                <td>{{ $climateMinMax->max('so2') }}</td>
                            </tr>
                            <tr class="warning">
                                <td>NOx(μg/m3)</td>
                                <td>{{ $climateMinMax->min('nox') }}</td>
                                <td>{{ $climateMinMax->max('nox') }}</td>
                            </tr>
                            <tr class="warning">
                                <td>RSPM(μg/m3)</td>
                                <td>{{ $climateMinMax->min('rspm') }}</td>
                                <td>{{ $climateMinMax->max('rspm') }}</td>
                            </tr>
                        </tbody>
                    </table>
                        
                </div> --}}
                <div class="col-12"><h5>Area Wise AQI Details:</h5></div>

                @foreach($climateMonitorings as $climateMonitoring)
                <div class="col-md-6">  
                    <div class="table-responsive">   
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-info">
                                    <th colspan="7">{{ $climateMonitoring['name'] }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: coral;">
                                    <th>Sr.No</th>
                                    <th>Date</th>
                                    <th>SO2 (μg/m3)</th>
                                    <th>NOx (μg/m3)</th>
                                    <th>PM2.5 (µg/m3)</th>
                                    <th>PM10 (μg/m3)</th>
                                    <th>AQI</th>
                                </tr>
                                
                                @php $count = 1; @endphp
                                @foreach($climateMonitoring['aqi'] as $airQuality)
                                <tr class="warning">
                                    <td>{{ $count++ }}</td>
                                    <td>{{ date('d-m-Y', strtotime($airQuality['date'])) }}</td>
                                    <td>{{ $airQuality['so2'] ?? 0 }}</td>
                                    <td>{{ $airQuality['nox'] ?? 0 }}</td>
                                    <td>{{ $airQuality['pm2'] ?? 0 }}</td>
                                    <td>{{ $airQuality['rspm'] ?? 0 }}</td>
                                    <td>{{ round($airQuality['aqi'], 2) ?? 0 }}</td>
                                </tr>
                                @endforeach
                                <tfoot>
                                    <tr align="right">
                                        <th colspan="7">
                                            <a href="{{ url('pollution-air-quality') }}?id={{ base64_encode($climateMonitoring['id']) }}" class="btn btn-sm btn-primary">Click for Details</a>
                                        </th>
                                    </tr>
                                </tfoot>
                            </tbody>
                        </table> 
                    </div>                              
                </div>
                @endforeach
                
            </div>
        </div>
    </section>
    <!-- Contact area End -->
@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

            $("#pie_start_date").datepicker({
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
            $('#pie_end_date').datepicker({
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

            $('#searchGraph').click(function(){
                let airMonitoring = $('#airMonitoring').val();
                let selectPollutant = $('#selectPollutant').val();
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();

                filterAQiGraph(airMonitoring, selectPollutant, start_date, end_date)
            })
            filterAQiGraph($('#airMonitoring').val(), $('#selectPollutant').val(), $('#start_date').val(), $('#end_date').val())
            function filterAQiGraph(airMonitoring, selectPollutant, start_date, end_date){
                $.ajax({
                    url: "{{url('pollution-update/chart')}}",
                    method: "get",
                    data:{airMonitoring:airMonitoring, selectPollutant:selectPollutant, start_date:start_date, end_date:end_date},
                    success: function (result) {
                        let xaxis = [];
                        let yaxis = [];
                        $.each(result.data, function(key, value){
                            xaxis.push(value['date'])
                            yaxis.push(value['aqi'])
                        })
                        var chart = new Highcharts.Chart({
                            chart: {
                                renderTo: 'aqigraph',
                                marginBottom: 80
                            },
                            title:{
                                text: $('#airMonitoring option:selected').text()
                            },
                            xAxis: {
                                categories: xaxis,
                                labels: {
                                    rotation: 25,
                                },
                            },
                            yAxis: {
                                labels: {
                                    formatter: function() {
                                        return this.value;
                                    }
                                }
                            },
                            accessibility: {
                                enabled: false
                            },
                            series: [ {
                                name: 'Current Value',
                                type: 'spline',
                                data: yaxis,
                                tooltip: {
                                    valueSuffix: ''
                                }
                            }]
                        });
                        chart.yAxis[0].axisTitle.attr({
                            text: 'Value'
                        });
                    }
                });
                
            }



            // click on pie chart graph
            $('#searchPieGraph').click(function(){
                let startDate = $('#pie_start_date').val();
                let endDate = $('#pie_end_date').val();
                filterPieGraph(startDate, endDate)
            })
            filterPieGraph($('#pie_start_date').val(), $('#pie_end_date').val())
            function filterPieGraph(start_date, end_date){
               
                $.ajax({
                    url: "{{url('pollution-update/pie-chart')}}",
                    method: "get",
                    data:{start_date:start_date, end_date:end_date},
                    success: function (result) {
                        var analytics = result.data;
                        var chartColor = result.color;
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable(analytics);

                            // Optional; add a title and set the width and height of the chart
                            var options = {'title':'', 'width':750, 'height':500, colors: chartColor};

                            // Display the chart inside the <div> element with id="piechart"
                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                            chart.draw(data, options);
                        }

                        let html = `<table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>Year</th>
                                            <th>Month</th>
                                            <th>Average</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                        let count = 0;
                        $.each(result.aqimonth, function(key, value){
                            let color = '';
                            if(value['aqi'] <= 50){
                                color = "#0EB409";
                            }else if(value['aqi'] >= 51 && value['aqi'] <= 100){
                                color = "#6AD067";
                            }else if(value['aqi'] >= 101 && value['aqi'] <= 200){
                                color = "#ffff00";
                            }else if(value['aqi'] >= 201 && value['aqi'] <= 300){
                                color = "#EF8B06";
                            }else if(value['aqi'] >= 301 && value['aqi'] <= 400){
                                color = "#F41212";
                            }else if(value['aqi'] > 400){
                                color = "#B60E0E";
                            }


                            html += `<tr>
                                <td>${value['year']}</td>
                                <td>${value['month']}</td>
                                <td style="background-color:${color}">${value['aqi']}</td>
                            </tr>`;
                            count = count + 1;
                        })
                        if(count == 0){
                            html += `<tr align="center"><td colspan="3">No Data Found.</td></tr>`;
                        }
                        html += `<tbody></table>`;

                        $('#aqiMonthWiseAverage').html(html)
                    }
                });
            }
        })
    </script>
@endpush