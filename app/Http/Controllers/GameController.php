<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckGameRequest;
use App\Models\HighScore;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function index()
    {
        if (!Session::has('number')) {
            $number = $this->generateUniqueNumber();
            Session::put('number', $number);

        }

        return view('game.index');
    }

    public function check(CheckGameRequest $request): RedirectResponseAlias
    {
        $name = $request->input('name');
        $number = Session::get('number');

        $result = $this->calculateCowsAndBulls($request->guess, $number);
        $cows = $result['cows'];
        $bulls = $result['bulls'];

        if ($bulls === 4) {
            $score = 100 - $result['attempts'];

            $highScore = HighScore::where('name', $name)->first();

            if ($highScore) {
                if ($score > $highScore->score) {
                    $highScore->score = $score;
                    $highScore->save();
                }
            } else {
                HighScore::create([
                    'name' => $name,
                    'score' => $score,
                ]);
            }

            Session::forget('number');
            Session::forget('history');
            Session::forget('attempts');

            Session::flash('success',
                'Congratulations, ' . $name . '! You guessed the number in ' . $result['attempts'] . ' attempts. Your score has been saved.');

            return redirect()->route('game.index');
        }

        $history = Session::get('history', []);
        $history[] = [
            'guess' => $request->guess,
            'cows' => $cows,
            'bulls' => $bulls,
        ];
        Session::put('history', $history);

        $attempts = Session::get('attempts', 0) + 1;
        Session::put('attempts', $attempts);

        return back()->withInput()->with('message', "Cows: $cows, Bulls: $bulls");
    }

    public function highScores()
    {
        $highScores = HighScore::orderBy('score', 'desc')->take(10)->get();

        return view('game.high_scores', compact('highScores'));
    }

    private function generateUniqueNumber(): string
    {
        $digits = range(0, 9);
        shuffle($digits);

        $index1 = array_search(1, $digits, true);
        $index8 = array_search(8, $digits, true);

        if (is_int($index1) && is_int($index8) && abs($index1 - $index8) !== 1) {
            $temp = $digits[$index1];
            $digits[$index1] = $digits[$index8];
            $digits[$index8] = $temp;
        }

        $index4 = array_search(4, $digits, true);
        $index5 = array_search(5, $digits, true);

        if (($index4 % 2 === 0 && $index5 % 2 === 0) || ($index4 % 2 !== 0 && $index5 % 2 !== 0)) {
            $swapIndex = ($index4 + 1) % 10;

            $temp = $digits[$index4];
            $digits[$index4] = $digits[$swapIndex];
            $digits[$swapIndex] = $temp;
        }

        return implode('', array_slice($digits, 0, 4));
    }

    private function calculateCowsAndBulls(string $guess, ?string $number): array
    {
        $guessDigits = str_split($guess);
        $numberDigits = str_split($number);

        $bulls = array_intersect_assoc($guessDigits, $numberDigits);

        $cows = count(array_intersect($guessDigits, $numberDigits)) - count($bulls);

        $attempts = Session::get('attempts', 0);
        Session::put('attempts', $attempts);

        return [
            'cows' => $cows,
            'bulls' => count($bulls),
            'attempts' => $attempts,
        ];
    }
}
