<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Sensor</title>
</head>
<body>

<h2>Tambah Data Sensor</h2>

<form action="/sensor" method="POST">
    @csrf

    <label>Nama Sensor</label><br>
    <input type="text" name="nama_sensor"><br><br>

    <label>Lokasi</label><br>
    <input type="text" name="lokasi"><br><br>

    <label>Nilai</label><br>
    <input type="number" name="nilai"><br><br>

    <button type="submit">Simpan</button>
</form>

</body>
</html>
