<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PDF</title>
	{{-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans&subset=devanagari" rel="stylesheet"> --}}
	<style>

	    body {
    font-family: DejaVu Sans;
}
	</style>
</head>
<body>
	<center><h4 style="margin-bottom: -8px;">Date, time and height of high tide above 4 meters in Thane Municipal Corporation limits</h4></center>
	@foreach($hightides as $key => $hightide)
	<center><h4 style="margin-bottom: 3px;">{{ date('F Y', strtotime($key)) }}</h4></center>
	<table style="width:100%" border="1" cellspacing="0">
        <thead>
	        <tr>
	            <th>Date</th>
	            <th>Day</th>
	            <th>Time</th>
	            <th>Height(m)</th>
	        </tr>
	        @foreach($hightide as $data)
	        <tr align="center">
	        	<td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
	        	<td>{{ date('l', strtotime($data->date)) }}</td>
	        	<td>{{ date('h:i A', strtotime($data->time)) }}</td>
	        	<td>{{ $data->height }}</td>
	        </tr>
	        @endforeach
        </thead>
    </table>
    @endforeach
</body>
</html>