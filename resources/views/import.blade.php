<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Enrollment Data</title>
</head>
<body>
    <h2>Import Enrollment Excel File</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('enrollment.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Choose Excel File:</label>
        <input type="file" name="file" required accept=".xls,.xlsx">
        <br><br>
        <button type="submit">Import</button>
    </form>
</body>
</html>
