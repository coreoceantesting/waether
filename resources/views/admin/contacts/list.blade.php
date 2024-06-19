@extends('layouts.admin')

@section('title')
Contact List
@endsection

@section('css')
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        @include('admin.message')
        <div class="d-flex justify-content-between">
            <h3 class="card-title ">Contact List</h3>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive ">
  
        <table class="table table-hover" id="example">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Date</th>
                    <th>Message</th>
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
                url: "{{ url('admin/contact/list') }}",
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
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'date',
                    name: 'created_at',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'message',
                    name: 'message',
                    render: function(data, type, row){
                         return data;
                    },
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row){
                         return `<form method="post" action='/admin/contact/delete'>
                                @csrf
                                <input type='hidden' value='${data}' name='id' />
                                <button style="border: none;background: none;color: red;" onclick="return confirm('Are you sure you want to remove this contact details')"><i class="nav-icon fa fa-trash"></i></button>
                        </form>`;
                    },
                }
            ]
        }); 
    });
</script> 
@stop

