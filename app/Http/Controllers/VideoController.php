<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get the videos
        $user = auth()->user();
        $videos = Video::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['videos' => $videos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //store videos 
        //first get the user
        $user = $request->user();
        $videos = new Video;
        //get the video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos'), $filename);
            $videoUrl = asset('videos/' . $filename);
            $base_url = url('/');
            $videoUrl = str_replace($base_url, 'http://10.0.2.2:8000', $videoUrl);
            $videos->video = $videoUrl;
        }

        $videos->name = $filename;
        $videos->user()->associate($user);
        $videos->save();

        return response()->json([
            'message' => 'Video Upload Successfully',
            'status' => 'Success',
            'videos' => $videos
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        //get the video by id
        $user = $request->user();
        $videos = Video::where('user_id', $user->id)->findOrFail($id);
        $videos->user()->associate($user);
        return response()->json([
            'videos' => $videos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //delete the video
        $user = $request->user();
        $videos = Video::where('user_id', $user->id)->findOrFail($id);
        $videos->delete();

        return response()->json([
            'message' => 'Video Deleted Successfully',
            'status' => 'Success'
        ]);
    }
}
