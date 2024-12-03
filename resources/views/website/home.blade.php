@extends('layouts/master')

@section('body')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <section class="weather-banner-2" style="background: url(@if($bannerImage) {{ asset('storage/'.$bannerImage) }} @endif);background-size: cover;background-repeat: no-repeat;">
        <div class="container">
            <div class="content">
                <div class="row justify-content-between">
                    <div class="col-xl-8 col-lg-6 mb-lg-0 mb-4">
                        <div class="text">
                            <h5 class="fw-4 fs-23" style="color: #252222;">Weather and Information </h5>
                            <h2 class="fw-4 lh-120">Daily Weather Information <br> Update News</h2>
                            <p class="fs-19 fw-5 lh-150 bottom-space pt-0">Get the latest weather information for today with
                                up-to-date <br> information on temperature, precipitation, and more.</p>
                            <div class="col-xl-9">
                                <form action="{{route('filterweatherinfo')}}">
                                    <div class="input-group m-0">
                                        <input type="text" class="form-control" id="datepicker" autocomplete="off" name="start_date" required
                                            placeholder="Filter by date..." value="{{(Request()->search) ? date('d-m-Y', strtotime(Request()->search)) : date('d-m-Y')}}">

                                            <button type="submit"><i class="fal fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 ">
                        <div class="detail p-100 text-center">
                            @if($setting->config_name == "rainy_day")
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Total Rain</span>
                                    <span class="color-dark text-end">{{($totalRain) ? round($totalRain, 2) : 0}}mm</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Last 24 Hrs Rain(till 8.30 AM)</span>
                                    <span class="color-dark text-end">{{($lastdayRain) ? round($lastdayRain, 2) : 0}}mm</span>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Last 24 Hrs Rain(Avg 15min)</span>
                                    <span class="color-dark text-end">{{($lastDayTotalRainAvg) ? round($lastDayTotalRainAvg, 2) : 0}}mm</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Current Rain</span>
                                    <span class="color-dark text-end">{{($currentRain) ? round($currentRain, 2) : 0}} mm</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Progressive Rain (from 8:30 AM)</span>
                                    <span class="color-dark text-end">{{($prograsiveRain) ? round($prograsiveRain, 2) : 0}} mm</span>
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Max Temp Out</span>
                                    <span class="color-dark text-end">{{($maxTempOut) ? round($maxTempOut, 2) : 0}}<b style="top: -1em;font-size: 10px;position: relative;">o</b>C</span></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Min Temp Out</span>
                                    <span class="color-dark text-end">{{($minTempOut) ? round($minTempOut, 2) : 0}}<b style="top: -1em;font-size: 10px;position: relative;">o</b>C</span></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Max Heat Index</span>
                                    <span class="color-dark text-end">{{($maxHeatIndex) ? round($maxHeatIndex, 2) : 0}}<b style="top: -1em;font-size: 10px;position: relative;">o</b>C</span></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-24">
                                    <span class="color-dark text-start">Min Heat Index</span>
                                    <span class="color-dark text-end">{{($minHeatIndex) ? round($minHeatIndex, 2) : 0}}<b style="top: -1em;font-size: 10px;position: relative;">o</b>C</span></span>
                                </div>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
<!-- Weather banner End -->

{{-- <section class="hourly pt-5">
    <div class="container">
        <div class="row title text-center border pt-3">
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <p class="color-dark">Total Rain</p>
                <p class="color-gray">{{($totalRain) ? round($totalRain, 2) : 0}} mm</p>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <p class="color-dark">Last 24 Hrs Rain(till 8.30 AM)</p>
                <p class="color-gray">{{($lastdayRain) ? round($lastdayRain, 2) : 0}} mm</p>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <p class="color-dark">Current Rain</p>
                <p class="color-gray">{{($currentRain) ? round($currentRain, 2) : 0}} mm</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <p class="color-dark">Progressive Rain (from 8:30 AM)</p>
                <p class="color-gray">{{($prograsiveRain) ? round($prograsiveRain, 2) : 0}} mm</p>
            </div>
        </div>
    </div>
</section> --}}



<!-- Today Detail area start -->
<section class="toady-detail pt-5">
    <div class="container">
        <div class="title text-center">
            <h2 class="fw-5 fs-40 lh-120 ls-5 color-dark mb-16">Weather Details</h2>
            <p class=" fw-4 fs-16 lh-160 ls-2 color-gray mb-16">The 'Recent Search Weather' section displays the latest
                weather information for the cities you have recently <br> searched. Stay up-to-date with the weather
                conditions of your preferred cities with this section. <a href="{{url('filter')}}" id="filterWeather">Filter Here</a></p>
                
                
        </div>


        <div class="row">
            @php $search = date('Y-m-d').' 08:30:00'; @endphp
            @php $i = 1; @endphp
            @foreach ($locations as $location)
                <div class="col-xl-4 col-md-6 col-12 mb-xl-0">
                @if($setting->config_name == "rainy_day")
                    @include('website.weather_details.rain')
                @else
                    @include('website.weather_details.sunny')
                @endif
                <div id="container{{$i++}}" style="height: 300px"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Today Detail area End -->


<!-- Hourly area Start -->

<section class="hourly pt-5">
    <div class="container">
        <div class="title text-center">
            <h2 class="fw-5 fs-40 lh-120 ls-5 color-dark mb-16">Weather Data </h2>
            <!--<p class="fw-4 fs-16 lh-160 ls-2 color-gray mb-48">The 'Recent Search Weather' section displays the latest weather information for the cities you have recently <br> searched. Stay up-to-date with the weather conditions of your preferred cities with this section.</p>-->
        </div>
        <div class="hourly-slider">
            
            <div class="slider-block">
                <div class="content text-center" style="background: linear-gradient(180deg, #2250ad 0%, rgba(240, 245, 255, 0.22) 100%);">
                    <i class="fas fa-sun"></i>
                    <p class="fs-28 fw-4 mb-1">{{$data->value('temp_out') ?? 0}}<b style="top: -0.6em;font-size: 13px;position: relative;">o</b>C</p>
                    <h2 class="fw-5 fs-19 mb-0">Temperature</h2>
                    <div class="line"></div> 
                    <div class="d-flex justify-content-center align-items-center mb-1">
                        <div class="weather-detail left-line">
                            <i>Min</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->min('temp_out') ?? 0}}<b style="top: -0.5em;font-size: 13px;position: relative;color:#252222">o</b>C&nbsp;</p>
                        </div>
                        <div class="weather-detail">
                            <i>Max</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->min('temp_out') ?? 0}}<b style="top: -0.5em;font-size: 13px;position: relative;color:#252222">o</b>C&nbsp;</p>
                        </div>
                    </div>
                    <h2 class="fw-4 fs-19 m-0">{{date('l')}}</h2>
                </div>
            </div>
            
            <div class="slider-block">
                <div class="content text-center" style="background: linear-gradient(180deg, #2250ad 0%, rgba(240, 245, 255, 0.22) 100%);">
                    <i class="fas fa-humidity"></i>
                    <p class="fs-28 fw-4 mb-1">{{$data->value('in_hum') ?? 0}}%</p>
                    <h2 class="fw-5 fs-19 mb-0">Humidity</h2>
                    <div class="line"></div> 
                    <div class="d-flex justify-content-center align-items-center mb-1">
                        <div class="weather-detail left-line">
                            <i>Min</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->min('in_hum') ?? 0}}%</p>
                        </div>
                        <div class="weather-detail">
                            <i>Max</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->max('in_hum') ?? 0}}%</p>
                        </div>
                    </div>
                    <h2 class="fw-4 fs-19 m-0">{{date('l')}}</h2>
                </div>
            </div>
            
            <div class="slider-block">
                <div class="content text-center" style="background: linear-gradient(180deg, #2250ad 0%, rgba(240, 245, 255, 0.22) 100%);">
                    <i class="fas fa-sun"></i>
                    <p class="fs-28 fw-4 mb-1">{{$data->value('hi_temp') ?? 0}}<b style="top: -0.6em;font-size: 13px;position: relative;">o</b>C</p>
                    <h2 class="fw-5 fs-19 mb-0">Heat Index</h2>
                    <div class="line"></div> 
                    <div class="d-flex justify-content-center align-items-center mb-1">
                        <div class="weather-detail left-line">
                            <i>Min</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->value('hi_temp') ?? 0}}<b style="top: -0.5em;font-size: 13px;position: relative;color:#252222">o</b>C&nbsp;</p>
                        </div>
                        <div class="weather-detail">
                            <i>Max</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->value('hi_temp') ?? 0}}<b style="top: -0.5em;font-size: 13px;position: relative;color:#252222">o</b>C&nbsp;</p>
                        </div>
                    </div>
                    <h2 class="fw-4 fs-19 m-0">{{date('l')}}</h2>
                </div>
            </div>
            
            <div class="slider-block">
                <div class="content text-center" style="background: linear-gradient(180deg, #2250ad 0%, rgba(240, 245, 255, 0.22) 100%);">
                    <img src="https://www.pcctmc.com/assets/front/images/gauge.png" style="margin-left: 34%;filter: grayscale(100%);width: 34px;" />
                    <p class="fs-28 fw-4 mb-1 mt-3">{{$data->value('thw_index') ?? 0}}</p>
                    <h2 class="fw-5 fs-19 mb-0">THW Index</h2>
                    <div class="line"></div> 
                    <div class="d-flex justify-content-center align-items-center mb-1">
                        <div class="weather-detail left-line">
                            <i>Min</i><br>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->min('thw_index') ?? 0}}</p>
                        </div>
                        <div class="weather-detail">
                            <i>Max</i><br>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->max('thw_index') ?? 0}}</p>
                        </div>
                    </div>
                    <h2 class="fw-4 fs-19 m-0">{{date('l')}}</h2>
                </div>
            </div>
            
            
            
            <div class="slider-block">
                <div class="content text-center" style="background: linear-gradient(180deg, #2250ad 0%, rgba(240, 245, 255, 0.22) 100%);">
                    <i class="far fa-wind fa-flip-vertical"></i>
                    <p class="fs-28 fw-4 mb-1">{{$data->value('wind_speed') ?? 0}}km/hr</p>
                    <h2 class="fw-5 fs-19 mb-0">Wind</h2>
                    <div class="line"></div> 
                    <div class="d-flex justify-content-center align-items-center mb-1">
                        <div class="weather-detail left-line">
                            <i>Min</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->value('wind_speed') ?? 0}}km/hr</p>
                        </div>
                        <div class="weather-detail">
                            <i>Max</i>
                            <p class="fs-16 fw-4 lh-160 m-0">{{$data->value('wind_speed') ?? 0}}km/hr</p>
                        </div>
                    </div>
                    <h2 class="fw-4 fs-19 m-0">{{date('l')}}</h2>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- Hourly area End -->
            

@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script>
        $(document).ready(function(){
            $( "#datepicker" ).datepicker({
                dateFormat: 'dd-mm-yy',
                maxDate: 0
            });
            @php $i = 1; @endphp
            @foreach ($locations as $location)
            var xaxis = [];
            var yaxis = [];
            var tempMM = "";
            var tempMessage = "";
            @foreach($location->weathers as $weather)
            xaxis.push("{{($weather->time) ? date('H:i', strtotime(str_replace(' ', '', $weather->time))) : date('H:i')}}")
            @if($setting->config_name == "rainy_day")
                yaxis.push({{($weather->rain) ? $weather->rain : 0}})
                tempMM = "mm";
                tempMessage = "Rain Fall";
            @else
                yaxis.push({{($weather->temp_out) ? $weather->temp_out : 0}})
                tempMM = "ºC";
                tempMessage = "Temparature";
            @endif
            @endforeach
            
            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container{{$i++}}',
                    marginBottom: 80
                },
                title:{
                    text:'{{$location->graph_title}}'
                },
                xAxis: {
                    categories: xaxis,
                    labels: {
                        rotation: 50,
                    },
                },
                yAxis: {
                    labels: {
                        formatter: function() {
                            return this.value+''+tempMM;
                        }
                    }
                },
                accessibility: {
                    enabled: false
                },
                series: [ {
                    name: tempMessage,
                    type: 'spline',
                    data: yaxis,
                    tooltip: {
                        valueSuffix: tempMM
                    }
                }]
            });
            chart.yAxis[0].axisTitle.attr({
                text: tempMessage
            });
            @endforeach
        })

    </script>

<script type="text/javascript">
    setInterval("my_function();",600000); //reload after 10 minute

      function my_function(){
          window.location = location.href;
      }
  </script>
@endpush
