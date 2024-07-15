
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export As Excel</title>
    <style>
        table {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        table td, table th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        
        table tr:nth-child(even){background-color: #f2f2f2;}
        
        table tr:hover {background-color: #ddd;}
        
        table th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #04AA6D;
          color: white;
        }
        </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Rain</th>
                <th>Wind Speed</th>
                <th>Temperature</th>
                <th>Low Tamperature</th>
                <th>Hi Tamperature</th>
                <th>Humidity</th>
                <th>Progressive Rain(From 8:30 AM)</th>
                <th>Last 24 Hours Rain</th>
            </tr>
        </thead>
        <tbody>
            @foreach($weathers as $weather)
            <tr>
                <td>{{ $weather['location'] }}</td>
                <td>{{ $weather['date'] }}</td>
                <td>{{ $weather['time'] }}</td>
                <td>{{ $weather['rain'] }}</td>
                <td>{{ $weather['wind_speed'] }}</td>
                <td>{{ $weather['in_temp'] }}</td>
                <td>{{ $weather['low_temp'] }}</td>
                <td>{{ $weather['hi_temp'] }}</td>
                <td>{{ $weather['in_hum'] }}</td>
                <td>{{ round($weather['prograsive_rain'], 3) }}</td>
                <td>{{ round($weather['lastday'], 3) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>