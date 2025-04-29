<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Action;
use App\Models\Story;

class ChapterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'story_id' => 'required|exists:stories,id',
            'title' => 'required|string',
            'text' => 'required|string',
            'is_final' => 'nullable|boolean',
            'author' => 'required|string',
        ]);

        $chapter = Chapter::create([
            'story_id' => $request->story_id,
            'title' => $request->title,
            'text' => $request->text,
            'is_final' => $request->is_final ?? false,
            'author' => $request->author,
        ]);

        return response()->json($chapter, 201);
    }


    public function storeAction(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'text' => 'required|string',
            'next_chapter_id' => 'nullable|exists:chapters,id',
        ]);

        $action = Action::create([
            'chapter_id' => $request->chapter_id,
            'text' => $request->text,
            'next_chapter_id' => $request->next_chapter_id,
        ]);

        return response()->json($action, 201);
    }
    
    public function showChapters($story_id)
    {
        $story = Story::with('chapters.actions')->findOrFail($story_id);
        return response()->json($story->chapters);
    }
}
