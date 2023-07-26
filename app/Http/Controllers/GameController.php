<?php

namespace App\Http\Controllers;

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

    public function check(Request $request)
    {
        // TODO
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
}
