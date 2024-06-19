<div class="detail p-5 text-center" style="background-image: url('{{ asset('storage/'.$setting->background_image) }}');background-repeat: no-repeat;background-size: cover;">
    <div class="d-flex align-items-center justify-content-around mb-32">
        <h4 style="color: #000" class="fw-6 color-dark m-0">{{ $location->name }}</h4>
        <img src="{{ asset('storage/'.$setting->icon) }}" style="height: 42px;width: 57px;" alt="">
    </div>
    <h5 style="color: #000" class="fw-5 fs-23 color-dark">{{ date('D, d F') }}</h5>
    
    <p style="font-size: 16px; color: #000">Last 24 Hour Tempature</p>
    <div class="d-flex align-items-center justify-content-center mb-24">
        <span  style="color: #000" class="color-dark text-start">Min : {{ (isset($lastDayTemp[$location->id])) ? round($lastDayTemp[$location->id]->weathers->avg('low_temp'), 2) : 0 }}<b style="top: -0.6em;font-size: 10px;position: relative;">o</b>C</span>
        <span  style="color: #000" class="color-dark text-end">Max : {{ (isset($lastDayTemp[$location->id])) ? round($lastDayTemp[$location->id]->weathers->avg('hi_temp'), 2) : 0 }}<b style="top: -0.6em;font-size: 10px;position: relative;">o</b>C</span>
    </div>


    <p style="font-size: 15px; color: #000">Prograssive Tempature(from 12.00 AM)</p>
    <div class="d-flex align-items-center justify-content-center mb-24">
        <span  style="color: #000" class="color-dark text-start">Min : {{ round($location->weathers->where('datetime', '>=', date('Y-m-d H:i:s'))->min('low_temp'), 2) }}<b style="top: -0.6em;font-size: 10px;position: relative;">o</b>C</span>
        <span  style="color: #000" class="color-dark text-end">Max : {{ round($location->weathers->where('datetime', '>=', date('Y-m-d H:i:s'))->max('hi_temp'), 2) }}<b style="top: -0.6em;font-size: 10px;position: relative;">o</b>C</span>
    </div>

    <p style="font-size: 16px; color: #000">Current Tempature</p>
    <div class="d-flex align-items-center justify-content-center mb-24">
        <span  style="color: #000" class="color-dark text-start">Min : {{ round($location->weathers->value('low_temp'), 2) }}<b style="top: -0.6em;font-size: 10px;position: relative;">o</b>C</span>
        <span  style="color: #000" class="color-dark text-end">Max : {{ round($location->weathers->value('hi_temp'), 2) }}<b style="top: -0.6em;font-size: 10px;position: relative;">o</b>C</span>
    </div>



    <p style="font-size: 16px; color: #000">Weather Data</p>
    <div class="d-flex align-items-center justify-content-center mb-24">
        <span  style="color: #000" class="color-dark text-start">Humidity</span>
        <span  style="color: #000" class="color-dark text-end">{{ round($location->weathers->avg('in_hum'), 2) }}%</span>
    </div>
    
    <div class="d-flex align-items-center justify-content-center">
        <span  style="color: #000" class="color-dark text-start">Wind Speed</span>
        <span  style="color: #000" class="color-dark text-end">{{ round($location->weathers->avg('wind_speed'), 2) }}km/h {{ $i }}</span>
    </div>

</div>