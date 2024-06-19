@extends('layouts.admin')

@section('title')
High Tide List
@endsection

@section('css')
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <h3 class="card-title ">High Tide List</h3>
            <a href="{{ url('admin/hightide/import') }}" class="btn btn-primary">Import High Tide</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive ">
        <table class="table table-hover" id="example">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Date</th>
                    <th>Time  </th>
                    <th>Height</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
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
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/admin/dashboard') }}",
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
                    name: 'yearly_data.date',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'time',
                    name: 'yearly_data.time',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'height',
                    name: 'yearly_data.height',
                    render: function(data, type, row){
                         return data+"mm";
                    },
                },
                {
                    data: 'id',
                    name: 'yearly_data.id',
                    render: function(data, type, row){
                        let html = `<div style="display:flex"><a href="{{ url('/') }}/admin/hightide/edit/${data}"><i class="nav-icon fa fa-edit"></i></a>`;
                        html += `<form method="post" action='/admin/hightide/delete'>
                                @csrf
                                <input type='hidden' value='${data}' name='id' />
                                <button style="border: none;background: none;color: red;" onclick="return confirm('Are you sure you want to remove hightide')"><i class="nav-icon fa fa-trash"></i></button>
                        </form></div>`;
                         return html;
                    },
                }
            ]
        }); 
    });
</script> 
@stop

