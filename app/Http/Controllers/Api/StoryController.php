<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Action;

class StoryController extends Controller
{
    public function index()
    {
        return response()->json(Story::all());
    }

    public function view($id)
    {
        return view('story', ['storyId' => $id]);
    }

    public function show($id)
    {
        $story = Story::with('chapters.actions')->findOrFail($id);
        return response()->json($story);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
        ]);

        $story = Story::create([
            'title' => $request->title,
            'author_name' => $request->author,
        ]);

        return response()->json($story, 201);
    }
}
