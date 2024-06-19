<!DOCTYPE html>
<html lang="en">


<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1,
            shrink-to-fit=no">
        <meta name="description" content="Bytez HTML5 Template">

        <title>TMC Weather Information </title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon"
            href="{{ asset('fav.png') }}">

        <!-- All CSS files -->
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
        <style>
            .highcharts-credits{
                display: none;
            }
            .toady-detail .detail span{
                font-size: 16px;
            }

            .highcharts-legend-item{
                display: none;
            }
            #filterWeather{
                font-size:18px;color: #0c27e5;
            }
            #filterWeather:hover{
                color: #FFAD51;
            }
            .blink {
                animation: blink 1s infinite;
            }
            @keyframes blink {
                0% {
                    opacity: 1;
                }
                50% {
                    opacity: 0;
                }
                100% {
                    opacity: 1;
                }
            }
            
            .load-wrapper {display: flex;align-items: center;justify-content: center;height: 100dvh;flex-direction: column;}
            .box-wrapper {width: 10vw;height: 10vw;position: relative;transform: rotate(48deg) skew(-200deg, -24deg);transform-origin: center center;}
            .box-wrapper div {position: absolute;left: 50%;top: 25%;width: 25%;height: 25%;background: transparent;display: block;transform-origin: left bottom;}
            .box-wrapper > div:nth-child(2) {transform: rotate(90deg);}
            .box-wrapper > div:nth-child(3) {transform: rotate(180deg);}
            .box-wrapper > div:nth-child(4) {transform: rotate(270deg);}
            .box-wrapper div > span {position: absolute;display: block;border: 2px solid #000;animation: move 12s ease-in-out infinite;box-shadow: inset 10px 10px 10px 2px rgb(9 121 231 / 30%);border-radius: 5px;}
            .box-wrapper div:nth-child(2) > span {box-shadow: inset 10px -10px 10px 2px ##dee2e6;}
            .box-wrapper div:nth-child(3) > span {box-shadow: inset -10px -10px 10px 2px ##dee2e6;}
            .box-wrapper div:nth-child(4) > span {box-shadow: inset -10px 10px 10px 2px ##dee2e6;}
            .load-wrapper p {font-size: 2rem;line-height: 1;color: #000;letter-spacing: 0.2rem;text-transform: capitalize;font-family: Verdana, Geneva, Tahoma, sans-serif;text-shadow: 0px 2px 2px rgba(255, 255, 255, 0.6);font-style: italic;}
            @keyframes move {
              0%,100% {left: 0%;top: 0%;width: 100%;height: 100%;}
              4.16% {left: 0%;top: 0%;width: 200%;height: 100%;}
              8.33% {left: 100%;top: 0%;width: 100%;height: 100%;}
              12.5% {left: 100%;top: 0%;width: 100%;height: 200%;}
              16.66% {left: 100%;top: 100%;width: 100%;height: 100%;}
              20.83% {left: 0%;top: 100%;width: 200%;height: 100%;}
              25% {left: 0%;top: 100%;width: 100%;height: 100%;}
              29.16% {left: 0%;top: 100%;width: 100%;height: 200%;}
              33.33% {left: 0%;top: 200%;width: 100%;height: 100%;}
              37.5% {left: -100%;top: 200%;width: 200%;height: 100%;}
              41.66% {left: -100%;top: 200%;width: 100%;height: 100%;}
              45.83% {left: -100%;top: 100%;width: 100%;height: 200%;}
              50% {left: -100%;top: 100%;width: 100%;height: 100%;}
              54.16% {left: -200%;top: 100%;width: 200%;height: 100%;}
              58.33% {left: -200%;top: 100%;width: 100%;height: 100%;}
              62.5% {left: -200%;top: 0%;width: 100%;height: 200%;}
              66.66% {left: -200%;top: 0%;width: 100%;height: 100%;}
              70.83% {left: -200%;top: 0%;width: 200%;height: 100%;}
              75% {left: -100%;top: 0%;width: 100%;height: 100%;}
              79.16% {left: -100%;top: -100%;width: 100%;height: 200%;}
              83.33% {left: -100%;top: -100%;width: 100%;height: 100%;}
              87.5% {left: -100%;top: -100%;width: 200%;height: 100%;}
              91.66% {left: 0%;top: -100%;width: 100%;height: 100%;}
              95.83% {left: 0%;top: -100%;width: 100%;height: 200%;}
            }


        </style>


    </head>

    <body class="">
        <!-- Preloader -->
        <div id="preloader" style="padding: 0px;">
            <div class="load-wrapper">
                <div class="box-wrapper">
                    <div><span></span></div>
                    <div><span></span></div>
                    <div><span></span></div>
                    <div><span></span></div>
                </div>
                <p>loading...</p>
            </div>            
        </div>
        <!-- Color Mode -->
        <!--<div class="color-mode bg-dark-2">-->
        <!--    <p class="color-white mb-2 mt-0">Dark Mode</p>-->
        <!--    <label class="switch">-->
        <!--        <input type="checkbox"  id="changeColor">-->
        <!--        <span class="slider round"></span>-->
        <!--    </label>-->
        <!--</div>-->
        <!-- Back To Top Start -->
        <a href="#main-wrapper" id="backto-top" class="back-to-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Main Wrapper Start -->
        <div id="main-wrapper" class="main-wrapper overflow-hidden">

            <!-- Header Area Start -->
            <header class="header" style="padding: 0px 0px 0px 0px;">
                <div class="container">
                    <nav class="navbar navbar-expand-lg ">
                        <a class="navbar-brand light-logo text-center title" href="{{url('/')}}"><img alt="" src="{{asset('/assets/logo1.png')}}"  style="width:155px" /></a>
                        <a class="navbar-brand dark-logo text-center title" href="{{url('/')}}"><img alt="" src="{{asset('/assets/logo1.png')}}" style="width:155px" /><p class="color-dark" style="font-size: 14px;">Thane Municipal Corporation</p></a>
                        <div class="title text-center">
                            <h1 class="color-dark" style="font-weight: 400;margin-left: 70%;width: 100%;">Weather Information</h1>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar"> <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse " id="mynavbar">
                            <ul class="navbar-nav mainmenu m-0 ms-auto">
                            

                                <li class="menu-item title bordered">
                                    <span class="color-dark" style="font-size: 15px;">{{date('D, d M Y')}}<p id="timer" style="font-size: larger;"></p></span>

                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>

                  <div style="border-top: 2px solid #116eba;border-style: dashed;border-bottom: none;border-left: none;border-right: none;padding: 5px 0px;">
                <div class="d-flex justify-content-center">
                    <nav class="navbar navbar-expand-lg ">
                        <div class="collapse navbar-collapse " id="mynavbar">
                            <ul class="navbar-nav">
                                {{-- <li class="menu-item-has-children">
                                    <a href="javascript:void(0);"
                                        class="active">Home</a>
                                    <ul class="submenu">
                                        <li><a href="javascript::void(0)" class="active">Home 1</a></li>
                                        <li><a href="javascript::void(0)">Home 2</a></li>
                                    </ul>
                                </li> --}}
                                <li class="menu-item ml-3"><a href="{{url('/')}}">Home</a></li>
                                <li class="menu-item ml-3"><a href="{{url('/filter')}}">Weather Info</a></li>
                                <li class="menu-item">
                                    <a href="{{ url('hightide') }}" target="__blank">High Tide Info</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{asset('climatemonitoring.pdf')}}" download="">Climate Monitoring</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{url('pollution-update')}}">Pollution Update</a>
                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>

                </div>

            </header>
            <!-- Header Area end -->
            @if($hightide)
            <section style="margin-bottom: -7px;">
            <!-- Weather banner start -->
            <marquee width="100%" direction="left" style="background-color: #f58731;color: black;">
               <b style="color:#fff;"><span class="blink">High tide : {{ date('h:i A', strtotime($hightide->time)) }} and {{ $hightide->height }}m</span> </b> &nbsp;&nbsp; {{ $hightide->message }}
            </marquee>
            </section>
            @endif

            @yield('body')



            <!-- Footer area Start -->
            <footer class="footer pb-0" style="background:#0895E6">
                <div class="container">
                    <div class="text-center">
                        <p class="fw-4 fs-13 color-dark-2 copyright m-0" style="color:#fff;padding-bottom: 12px;">Copyright {{ date('Y') }} Thane Municipal Corporation. All rights reserved. <br>Design And Developed by Core Ocean Solutions LLP</p>
                    </div>
                </div>
            </footer>
            <!-- Footer area End -->



        </div>
        <!-- Jquery Js -->

        <script src="{{ asset('assets/js/vendor/jquery-3.6.3.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/jquery-appear.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/vendor/jquery-validator.js') }}"></script> --}}
        {{-- <script src="{{ asset('assets/js/vendor/chart.js') }}"></script> --}}


        <!-- Site Scripts -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script>
            setInterval(function() {
                var currentTime = new Date ( );
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
                var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
                currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
                currentHours = ( currentHours == 0 ) ? 12 : currentHours;
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                document.getElementById("timer").innerHTML = currentTimeString;
            }, 1000);
        </script>
        @stack('scripts')

    </body>

</html>
