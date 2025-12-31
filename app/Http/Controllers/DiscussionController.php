<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DiscussionController extends Controller
{
    public function show(Discussion $discussion)
    {
        $discussion->load(['posts']);
        return Inertia::render('Discussions/Show', [
            'discussion' => $discussion,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'on_id'   => 'required|integer',
            'on_type' => 'required|string',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $discussion = Discussion::create([
            'on_id'   => $validated['on_id'],
            'on_type' => "App\\Models\\{$validated['on_type']}",
            'title'   => $validated['title'],
            'status'  => 'Open',
        ]);

        $discussion->posts()
            ->create([
                'content' => $validated['content'],
                'status'  => 'Published',
            ]);

        return back()
            ->with('message', 'Thread started successfully.')
            ->with('type', 'success');
    }

    public function reply(Request $request, Discussion $discussion)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $post = $discussion->posts()
            ->create([
                'content' => $validated['content'],
                'status'  => 'Published',
            ]);

        return back()
            ->with('message', 'Reply added.')
            ->with('type', 'success')
            ->with('post', $post);
    }

    public function destroyPost(DiscussionPost $post)
    {
        $post->delete();
        return back()
            ->with('message', 'Post deleted.')
            ->with('type', 'success');
    }
}
