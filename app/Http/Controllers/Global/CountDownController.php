<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class CountDownController extends Controller
{
    public function getTime($quiz_id)
    {
        $countdown = Quiz::where('quiz_id', $quiz_id)->first();

        return response()->json([
            'jam' => $countdown->jam,
            'menit' => $countdown->menit,
            'detik' => $countdown->detik
        ]);
    }

    public function updateTime(Request $request, $quiz_id)
    {
        $countdown = Quiz::find($quiz_id)->first();

        $countdown->jam = $request->input('jam');
        $countdown->menit = $request->input('menit');
        $countdown->detik = $request->input('detik');

        $countdown->save();

        return response()->json([
            'message' => 'Waktu berhasil diperbarui'
        ]);
    }
}
