<?php

namespace App\Http\Controllers;

use App\Models\Greeting;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $greetings = Greeting::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(['greetings' => $greetings]);
        //$greeting = greeting::orderBy('created_at', 'desc')->get();
        // $greetings = Greeting::orderBy('created_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // //validate the input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'descriptions' => 'required|string|max:4072',
            // 'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:10048',
            // 'video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:1000480',
            'date' => 'nullable',
            'time' => 'nullable',
        ]);
        // error handel
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //set the data to table
        $user = $request->user();
        $greeting = new Greeting;
        $greeting->title = $request->title;
        $greeting->descriptions = $request->descriptions;
        //image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imageUrl = asset('images/' . $imageName);
            $base_url = url('/');
            // Replace base URL with emulator IP address
            //for development purposes 
            $imageUrl = str_replace($base_url, 'http://10.0.2.2:8000', $imageUrl);
            $greeting->image = $imageUrl;
        }

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos'), $filename);
            $videoUrl = asset('videos/' . $filename);
            $base_url = url('/');
            $videoUrl = str_replace($base_url, 'http://10.0.2.2:8000', $videoUrl);
            $greeting->video = $videoUrl;
        }
        //date & time
        $greeting->date = $request->date;
        $greeting->time = $request->time;
        $greeting->user()->associate($user);
        $greeting->save();

        return response()->json([
            'message' => "Greetings Created Successfully",
            'status' => 'Success',
            'greetings' => $greeting
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // $user = $request->user();
        // $greeting = Greeting::where('user_id', $user->id)->findOrFail($id);
        // return response()->json([
        //     'greetings' => $greeting
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // //validate the input
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|max:255',
        //     'descriptions' => 'required|string|max:500',
        //     // 'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        //     // 'video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:20480',
        //     'date' => 'required|date',
        //     'time' => 'required',
        // ]);
        // // error handel
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        // //update the data to table
        // $user = $request->user();
        // $greeting = Greeting::where('user_id', $user->id)->findOrFail($id);
        // $greeting->title = $request->title;
        // $greeting->descriptions = $request->descriptions;
        // //image
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $imageName);
        //     $greeting->image = $imageName;
        // }
        // //video
        // if ($request->hasFile('video')) {
        //     $video = $request->file('video');
        //     $videoName = time() . '.' . $video->getClientOriginalExtension();
        //     $video->move(public_path('videos'), $videoName);
        //     $greeting->video = $videoName;
        // }
        // //date & time
        // $greeting->date = $request->date;
        // $greeting->time = $request->time;

        // $greeting->save();

        // return response()->json([
        //     'message' => "Greetings Updated Successfully",
        //     'status' => 'Success',
        //     'greetings' => $greeting
        // ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // $user = $request->user();
        // $greeting = Greeting::where('user_id', $user->id)->findOrFail($id);
        // $greeting->delete();
        // return response()->json([
        //     'message' => 'Greetings Deleted Successfully',
        //     'status' => 'Success'
        // ]);
    }

    //upload video
    // public function uploadVideo(Request $request)
    // {
    //     //video
    //     $videos = new Video;

    //     if ($request->hasFile('video')) {
    //         $video = $request->file('video');
    //         $videoName = time() . '.' . $video->getClientOriginalExtension();
    //         $video->move(public_path('videos'), $videoName);
    //         $videoUrl = asset('videos/' . $videoName);
    //         $base_url = url('/');
    //         $videoUrl = str_replace($base_url, 'http://10.0.2.2:8000', $videoUrl);
    //         $videos->video = $videoUrl;
    //     }

    //     return response()->json([
    //         'videos' => $videos
    //     ]);
    // }
    // public function uploadVideo(Request $request)
    // {
    //     $video = $request->file('video');
    //     $videoName = $video->getClientOriginalName();
    //     $videoPath = storage_path('app/public/videos/' . $videoName);

    //     if ($request->has('video')) {
    //         $videoContent = file_get_contents($video->getRealPath());
    //         file_put_contents($videoPath, $videoContent, FILE_APPEND | LOCK_EX);

    //         return response()->json(['message' => 'Video chunk uploaded successfully']);
    //     }

    //     return response()->json(['message' => 'Video uploaded successfully']);
    // }

    // public function uploadVideo(Request $request)
    // {
    //     $chunk = $request->file('video');
    //     $index = $request->input('index');
    //     $totalChunks = $request->input('totalChunks');
    //     $filename = $request->input('filename');

    //     $path = storage_path('app/videos/' . $filename . '.part');

    //     $chunk->move(storage_path('app/videos'), $filename . '.part');

    //     // Check if all the chunks have been uploaded
    //     if ($index + 1 == $totalChunks) {
    //         $this->mergeChunks($filename, $totalChunks);
    //     }

    //     return response()->json([
    //         'message' => 'Chunk uploaded successfully',
    //     ]);
    // }

    // private function mergeChunks($filename, $totalChunks)
    // {
    //     $path = storage_path('app/videos/' . $filename);
    //     $file = fopen($path, 'w');

    //     for ($i = 0; $i < $totalChunks; $i++) {
    //         $chunkPath = storage_path('app/videos/' . $filename . '.part' . $i);
    //         $chunk = file_get_contents($chunkPath);
    //         fwrite($file, $chunk);
    //         unlink($chunkPath);
    //     }

    //     fclose($file);

    //     return response()->json([
    //         'message' => 'File uploaded successfully',
    //     ]);
    // }

    // public function uploadVideo(Request $request)
    // {

    //     if ($request->hasFile('video')) {
    //         $video = $request->file('video');
    //         $filename = time() . '_' . $video->getClientOriginalName();
    //         $video->storeAs('public/videos', $filename);
    //         $url = url('storage/app/public/videos/' . $filename);
    //         $base_url = url('/');
    //         $videoUrl = str_replace($base_url, 'http://10.0.2.2:8000', $url);
    //         return response()->json(['message' => 'Video uploaded successfully']);
    //     }

    //     return response()->json(['error' => 'No video file found']);
    // }
}
