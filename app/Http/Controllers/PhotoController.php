<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Photo::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePhotoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {
        //
        $photo = Photo::create([
            'url' => $request->string('url'),
            'photoable_id' => $request->string('photoable_id'),
            'photoable_type' => $request->string('photoable_type'),
        ]);
    }


    public function serve(Photo $photo)
    {
        return response()->file('storage/'.$photo->url, );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Photo $photo
     * @return Photo
     */
    public function show(Photo $photo)
    {
        return $photo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePhotoRequest $request
     * @param \App\Models\Photo $photo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        if ($request->has('url')) {
            $photo->update(['url' => $request->string('url')]);
        }
        if ($request->has('photoable_id')) {
            $photo->update(['photoable_id' => $request->string('photoable_id')]);
        }
        if ($request->has('photoable_type')) {
            $photo->update(['photoable_type' => $request->string('photoable_type')]);
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Photo $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
        $photo->delete();
        return response(status: 204);
    }

    public function deleteMultiple(Request $request)
    {
        //
        $request->validate([
            'photos'=>['required']
        ]);
        foreach ($request->photos as $photo_id) {
            $photo = Photo::findOrFail($photo_id);
            $photo->delete();
        }
        return response(status: 204);
    }
}
