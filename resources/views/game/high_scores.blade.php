<!DOCTYPE html>
<html>
<head>
    <title>High Scores</title>
</head>
<body>
<h1>High Scores</h1>
<ol>
    @foreach($highScores as $score)
        <li>{{ $score->name }} - {{ $score->score }}</li>
    @endforeach
</ol>

<a href="{{ route('game.index') }}">Back to Game</a>

</body>
</html>
