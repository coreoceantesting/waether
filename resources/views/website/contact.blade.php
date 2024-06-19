@extends('layouts.master')

@section('body')
    <!-- inner banner Start -->
            <section class="inner-slider ">
                <div class="container">
                    <h2 class="title">Contact Us</h2>
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
                        <div class="col-lg-8">
                            <div class="contact-block bg-white-1">
                                <form method="post" action="{{url('contact')}}" class="contact-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group mb-32">
                                                <input type="text" class="form-control" id="name" name="name" required placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group mb-32">
                                                <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group mb-32">
                                                <input type="tel" class="form-control" id="phone" name="mobile" required placeholder="Phone">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-32">
                                                <textarea class="form-control" required name="message" placeholder="Your Message"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="weather-btn border-0">
                                            Send
                                        </button>
                                    </div>
                                    <!-- Alert Message -->
                                    <div id="message" class="alert-msg"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Contact area End -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            @if(session()->has('success'))
                alert("{{session()->get('success')}}")
            @endif
        })
    </script>
@endpush