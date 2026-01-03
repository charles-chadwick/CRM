<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiscussionController extends Controller
{
    public function show(Discussion $discussion)
    {
        $posts = $discussion->posts()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Discussions/Show', [
            'discussion' => $discussion,
            'posts'      => $posts,
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

        // for some reason this was not redirecting properly. Now it is.
        session()->flash('message', 'Thread started successfully.');
        session()->flash('type', 'success');
        return Inertia::location(route('discussions.show', $discussion->id));

    }

    public function create(string $on, int $id)
    {
        $discussion = new Discussion;
        $discussion->on_id = $id;
        $discussion->on_type = $on;

        return Inertia::render('Discussions/Show', [
            'discussion' => $discussion,
            'posts'      => [new DiscussionPost]
        ]);
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
