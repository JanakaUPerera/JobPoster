<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function loadApplyForJob(Request $request)
    {
        $post = Post::find($request->id);
        return Inertia::render('ApplyJob',[
            'post' => $post
        ]);
    }

    public function createApplication(Request $request)
    {
        $request->validate([
            'cover_letter' => 'required',
            'cv' => ['required', File::types(['pdf','docx'])]
        ]);

        DB::beginTransaction();
        try {
            $post = Post::find($request->post_id);
            $file = $request->file('cv');
            $filename = auth()->user()->email."_cv_to_$post->id.".$file->extension();

            $path = Storage::putFileAs('cvs',$file,$filename);
            Application::create([
                'applicant_id' => auth()->id(),
                'post_id' => $post->id,
                'cover_letter' => $request->cover_letter,
                'cv' => $path
            ]);
            DB::commit();
            return Inertia::render('JobWall');
        } catch (\Throwable $throwable){
            DB::rollBack();
            return response()->json($throwable);
        }
    }
}
