@extends('layouts.admin')

@section('title')
{{ $locationName }} / Air Quality List
@endsection

@section('css')
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        @include('admin.message')
        <div class="d-flex justify-content-between">
            <h3 class="card-title "><a href="{{ url('admin/pollution/location/list') }}">{{ $locationName }}</a> / Air Quality List</h3>
            <div>
                <button type="button" href="javascript::void(0)" data-toggle="modal" data-target="#exampleModal" class="btn btn-success">Import</button>

                <a href="{{ url('/admin/pollution/location/'.Request()->location.'/air-quality/add') }}" class="btn btn-primary">Add</a>
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive ">
  
        <table class="table table-hover" id="example">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Date</th>
                    <th>SO2</th>
                    <th>NOx</th>
                    <th>PM2.5</th>
                    <th>RSPM</th>
                    <th>CO</th>
                    <th>O3</th>
                    <th>NH3</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('/admin/pollution/location/air-quality/import') }}" enctype="multipart/form-data">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Import Excel</label>
                <input type="hidden" name="location_id" value="{{ Request()->location }}">
                <input required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" name="import" class="form-control" />
                
            </div>
            <div class="modal-footer">
                <a href="{{ asset('Sample air quality.xlsx') }}" download="" class="btn btn-success">Download Sample</a>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
            </form>
        </div>
    </div>
</div>


@endsection


@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/pollution/location/'.Request()->location.'/air-quality/list') }}",
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'date',
                    name: 'date',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'so2',
                    name: 'so2',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'nox',
                    name: 'nox',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'pm2',
                    name: 'pm2',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'rspm',
                    name: 'rspm',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'co',
                    name: 'co',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'o3',
                    name: 'o3',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'nh3',
                    name: 'nh3',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row){
                         let html = `<div class="d-flex"><a href="{{ url('/') }}/admin/pollution/location/{{ Request()->location }}/air-quality/edit/${data}"><i class="nav-icon fa fa-edit"></i></a>`;
                         html += `<form method="post" action='{{ url('/') }}/admin/pollution/location/air-quality/delete'>
                                @csrf
                                <input type='hidden' value='${data}' name='id' />
                                <button style="border: none;background: none;color: red;" onclick="return confirm('Are you sure you want to remove')"><i class="nav-icon fa fa-trash"></i></button>
                        </form></div>`
                        return html;
                    },
                }
            ]
        }); 
    });
</script> 
@stop

