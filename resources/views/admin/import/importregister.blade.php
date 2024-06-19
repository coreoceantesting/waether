@extends('layouts.admin')

@section('title')
High Tide List
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
       
            <br>

            <div class="card">
              <!--    <div class="card-warning"> -->
                <div class="card-header">Import High Tide</div>
  
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  
                  <div class="card-body">
                    <form action="{{ route('importhightide') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input required="" type="file" name="file" class="form-control">
                        <br>
                        <button class="btn btn-success"> Import Data </button>

                        <a href="{{asset('TestData.xlsx')}}" class="btn btn-primary"> Sample Download </a>

                    </form>
                 </div>
  
                </div>
            </div>
       <!--  </div> -->
    </div>
    </div>
</div>
  @endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js" defer></script>



@stop