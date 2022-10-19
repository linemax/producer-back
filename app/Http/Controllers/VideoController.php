<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Video::all();
    }


    public function serve(Video $video)
    {
        return response()->file('storage/'.$video->url, );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVideoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoRequest $request)
    {
        return Video::create([
            'url'=>$request->string('url'),
            'videoable_id'=>$request->string('videoable_id'),
            'videoable_type'=>$request->string('videoable_type'),
            'id'=>Str::uuid()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return Video
     */
    public function show(Video $video)
    {
        return $video;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVideoRequest  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {

        if ($request->has('url')){
            $video->update(['url'=>$request->string('url')]);
        }
        if ($request->has('videoable_id')){
            $video->update(['videoable_id'=>$request->string('videoable_id')]);
        }
        if ($request->has('videoable_type')){
            $video->update(['videoable_type'=>$request->string('videoable_type')]);
        }
        return  null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return response(status: 204);
    }
}
