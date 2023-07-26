<?php

namespace App\Http\Controllers;

use App\Models\HighScore;
use App\Rules\UniqueFourDigits;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function index()
    {
        if (!Session::has('number')) {
            $number = $this->generateUniqueNumber();
            Session::put('number', $number);

        }
        dump(Session::get('number'));
        return view('game.index');
    }

    public function check(Request $request): RedirectResponseAlias
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guess' => ['required', 'numeric', 'digits:4', new UniqueFourDigits],
        ]);

        $name = $request->input('name');

        $number = Session::get('number');

        $result = $this->calculateCowsAndBulls($request->guess, $number);
        $cows = $result['cows'];
        $bulls = $result['bulls'];

        if ($bulls === 4) {
            $attempts = Session::get('attempts', 0);
            $score = 100 - $attempts;

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

            return redirect()->route('game.index')->with('success', 'Congratulations, ' . $name . '! You guessed the number in ' . $attempts . ' attempts. Your score has been saved.');
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
        // TODO
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

    private function calculateCowsAndBulls(string $guess, string $number): array
    {
        $guessDigits = str_split($guess);
        $numberDigits = str_split($number);

        $bulls = array_intersect_assoc($guessDigits, $numberDigits);

        $cows = count(array_intersect($guessDigits, $numberDigits)) - count($bulls);

        $attempts = Session::get('attempts', 0) + 1;
        Session::put('attempts', $attempts);

        return [
            'cows' => $cows,
            'bulls' => count($bulls),
            'attempts' => $attempts,
        ];
    }
}
