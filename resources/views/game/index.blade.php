<!DOCTYPE html>
<html>
<head>
    <title>Cows and Bulls Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Cows and Bulls Game</h1>
    <form action="{{ route('game.check') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <br />
        <div class="form-group">
            <label for="guess">Enter a 4-digit number with unique digits:</label>
            <input type="text" class="form-control" id="guess" name="guess" maxlength="4" required>
        </div>
        <br />
        <button type="submit" class="btn btn-outline-primary">Check</button>
        <br /> <br />
        @error('guess')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @if(session('message'))
            <div>{{ session('message') }}</div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('history'))
            <h2>History of Guesses:</h2>
            <ul>
                @foreach(Session::get('history') as $entry)
                    <li>Guess: {{ $entry['guess'] }} - Cows: {{ $entry['cows'] }}, Bulls: {{ $entry['bulls'] }}</li>
                @endforeach
            </ul>
        @endif
    </form>

    <hr />
    <a href="{{ route('game.highScores') }}">View High Scores</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
