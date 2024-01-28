<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(2)->through(function ($post) {
            return array_merge($post->toArray(), [
                'can' => [
                    'update' => Auth::user()->can('update', [Post::class, $post])
                ]
            ]);
        });
        return Inertia::render('JobWall', [
            'posts' => $posts->items(),
            'paginate' => $posts,
            'can' => [
                'post' => PermissionService::postPermissions(),
                'application' => PermissionService::applicationPermissions()
            ]
        ]);
    }

    public function loadCreatePost()
    {
        return Inertia::render('JobPost');
    }

    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required',
            'location' => 'required',
            'about' => 'required',
            'responsibilities' => 'required',
            'requirements' => 'required',
            'benefits' => 'nullable',
            'deadline' => 'required|date|after:' . now()->toDateString(),
        ]);

        DB::beginTransaction();
        try {
            $post = Post::create([
                'poster_id' => auth()->id(),
                'position' => $request->position,
                'location' => $request->location,
                'about' => $request->about,
                'responsibilities' => $request->responsibilities,
                'requirements' => $request->requirements,
                'benefits' => $request->benefits,
                'deadline' => $request->deadline
            ]);
            DB::commit();
            return Inertia::render('JobPost');
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return response()->json($throwable);
        }
    }

    public function updatePost(Request $request)
    {
        $post = Post::find($request->id);
        $this->authorize('update', [Post::class, $post]);

        $validated = $request->validate([
            'position' => 'required',
            'location' => 'required',
            'about' => 'required',
            'responsibilities' => 'required',
            'requirements' => 'required',
            'benefits' => 'nullable',
            'deadline' => 'required|date|after:' . now()->toDateString(),
        ]);

        DB::beginTransaction();
        try {
            $post->position = $request->position;
            $post->location = $request->location;
            $post->about = $request->about;
            $post->responsibilities = $request->responsibilities;
            $post->requirements = $request->requirements;
            $post->benefits = $request->benefits;
            $post->deadline = $request->deadline;
            $post->save();
            DB::commit();
            return Inertia::render('JobWall');
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return response()->json($throwable);
        }
    }
}
