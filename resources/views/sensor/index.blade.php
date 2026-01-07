<!DOCTYPE html>
<html>
<head>
    <title>Data Sensor</title>
</head>
<body>

<h2>Data Sensor</h2>

<a href="/sensor/create">
    <button>Tambah Data Sensor</button>
</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Nama Sensor</th>
        <th>Lokasi</th>
        <th>Nilai</th>
    </tr>
    @foreach($sensors as $sensor)
    <tr>
        <td>{{ $sensor->nama_sensor }}</td>
        <td>{{ $sensor->lokasi }}</td>
        <td>{{ $sensor->nilai }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
