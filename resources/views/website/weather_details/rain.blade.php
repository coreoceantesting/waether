@php 
$last15min = round($location->weathers->where('datetime', '>', date('Y-m-d H:i:s', strtotime('-15 min')))->where('datetime', '<=', date('Y-m-d H:i:s'))->value('rain'), 2);

if(date('H:i:s') >= '00:00:00' && date('H:i:s') <= '08:15:00'){
    $prograsiveRain = round($location->weathers->where('datetime', '<=', date('Y-m-d H:i:s'))
        ->where('datetime', '>=', date('Y-m-d H:i:s', strtotime('-1 days', strtotime(date('Y-m-d').' 08:30:00'))))->sum('rain'), 2);
}else{
    $prograsiveRain = round($location->weathers->where('datetime', '>=', date('Y-m-d H:i:s', strtotime($search)))->where('datetime', '<', date('Y-m-d H:i:s'))->sum('rain'), 2);
}
@endphp
<div class="detail p-5 text-center" style="background-image: url('{{ asset('storage/'.$setting->background_image) }}');background-repeat: no-repeat;background-size: cover;">
    <div class="d-flex align-items-center justify-content-around mb-32">
        <h4 style="color: white" class="fw-6 color-dark m-0">{{ $location->name }}</h4>
        <img src="{{ asset('storage/'.$setting->icon) }}" style="height: 42px;width: 57px;" alt="">
    </div>
    <h5 style="color: white" class="fw-5 fs-23 color-dark">{{ date('D, d F') }}</h5>
    {{-- <p class="fw-6 fs-95 lh-120 color-dark m-0">0 mm Last 1 Hour</p> --}}
    {{-- <p class="fw-6 mb-32 color-dark">Sunny</p> --}}

    <div class="text"><p style="color: white" class="color-dark">{{$last15min}} mm <span style="font-size: 12px; color: white">Last 15 min</span></p></div>
    <p style="font-size: 15px; color: white">Progressive Rain (From 8:30 AM) : {{$prograsiveRain}} mm</p>
    @php
        $last24hours = DB::table('weathers')->where('location_id', $location->id)->where('datetime', '>=', date('Y-m-d H:i:s', strtotime('-1 days', strtotime($search))))->where('datetime', '<=', date('Y-m-d H:i:s', strtotime($search)))->avg('rain');
    @endphp
    <p style="font-size: 15px; color: white"  class="color-dark">Last 24 Hours Rain : {{round($last24hours, 2)}} mm</p>


    <div class="d-flex align-items-center justify-content-center mb-24">
        <span  style="color: white" class="color-dark text-start">Temperature</span>
        <span  style="color: white" class="color-dark text-end">{{ round($location->weathers->avg('hi_temp'), 2) }}<b style="top: -0.6em;font-size: 10px;position: relative;">o</b>C</span>
    </div>
    <div class="d-flex align-items-center justify-content-center mb-24">
        <span  style="color: white" class="color-dark text-start">Humidity</span>
        <span  style="color: white" class="color-dark text-end">{{ round($location->weathers->avg('in_hum'), 2) }}%</span>
    </div>
    <div class="d-flex align-items-center justify-content-center">
        <span  style="color: white" class="color-dark text-start">Wind Speed</span>
        <span  style="color: white" class="color-dark text-end">{{ round($location->weathers->avg('wind_speed'), 2) }}km/h</span>
    </div>

</div>