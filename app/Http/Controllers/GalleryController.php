<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        //
        return Gallery::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreGalleryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleryRequest $request)
    {
        return Gallery::create([
            'title' => $request->string('title'),
//            'project_id' => $request->string('project_id'),
        ]);
    }

    public function photos(StorePhotoRequest $request, Gallery $gallery)
    {
        $path = $request->photo->store('photos', 'public');
        $photo = new Photo;
        $photo->url = $path;
        $photo->save();
        $photo->refresh();
        $gallery->photos()->save($photo);

        return response(status:201);
    }
    
    public function videos(StoreVideoRequest $request, Gallery $gallery)
    {
        $path = $request->video->store('videos', 'public');
        $video = new Video;
        $video->url = $path;
        $video->save();
        $video->refresh();
        $gallery->videos()->save($video);
        
        return response(status:201);
    }
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Gallery $gallery
     * @return Gallery
     */
    public function show(Gallery $gallery)
    {
        //
        return $gallery;
    }

    public function getphotos(Gallery $gallery)
    {
        //
        return $gallery->photos;
    }


    public function getvideos(Gallery $gallery)
    {
        //
        return $gallery->videos;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateGalleryRequest $request
     * @param \App\Models\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        if ($request->has('title')) {
            $gallery->update(['title' => $request->string('title')]);
        }
//        if ($request->has('project_id')) {
//            $gallery->update(['project_id' => $request->string('project_id'),]);
//        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
        $gallery->delete();
        return response(status:204);
    }
}
