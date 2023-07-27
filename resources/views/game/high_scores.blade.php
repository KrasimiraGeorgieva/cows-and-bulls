<!DOCTYPE html>
<html>
<head>
    <title>Top 10 best results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<h1>High Scores</h1>
    <ol>
        @foreach($highScores as $score)
            <li>{{ $score->name }} - {{ $score->score }}</li>
        @endforeach
    </ol>

    <hr />
    <a href="{{ route('game.index') }}">Back to Game</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
