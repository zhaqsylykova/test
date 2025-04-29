<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;

class ResultController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'story_id' => 'required|exists:stories,id',
            'nickname' => 'required|string',
            'path' => 'required|string',
        ]);

        $result = Result::create([
            'story_id' => $request->story_id,
            'nickname' => $request->nickname,
            'path' => $request->path,
        ]);

        return response()->json($result, 201);
    }

   
    public function show($id)
    {
        $result = Result::findOrFail($id);
        return response()->json($result);
    }
}
