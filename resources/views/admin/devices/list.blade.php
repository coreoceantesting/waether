@extends('layouts.admin')

@section('title')
Device List
@endsection

@section('css')
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        @include('admin.message')
        <div class="d-flex justify-content-between">
            <h3 class="card-title ">Device List</h3>
            <a href="{{ url('admin/device/add') }}" class="btn btn-primary">Add</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive ">
  
        <table class="table table-hover" id="example">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Path</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $count  = 1; @endphp
                @foreach($devices as $device)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $device->name }}</td>
                    <td>{{ unserialize($device->path) }}</td>
                    <td>
                        @if($device->status == 1) 
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('/admin/device/edit/'.$device->id) }}"><i class="nav-icon fa fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection


@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
        }); 
    });
</script> 
@stop

