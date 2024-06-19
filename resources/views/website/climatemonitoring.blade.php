@extends('layouts.master')

@section('body')
    <!-- inner banner Start -->
    <section class="inner-slider ">
        <div class="container">
            <h2 class="title">Climate Monitoring</h2>
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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-block bg-white-1">
                        <div class='text-center'>
                            <h3>Weather Satelite view</h3>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d120562.30067206293!2d73.0014603!3d19.213891949999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b8fcfe76fd59%3A0xcf367d85f7c50283!2sThane%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1692268026209!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15071.70117390525!2d72.98147619999999!3d19.19846505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1691737454314!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
                        </div>
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