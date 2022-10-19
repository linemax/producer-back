<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Project;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Project::paginate(10);

    }

    public function photo(StorePhotoRequest $request, Project $project)
    {
        $path = $request->photo->store('photos', 'public');
        if ($project->photo()->exists()) {
            Storage::delete($project->photo->url);
            $project->photo->url = $path;
            $project->photo->save();
        } else {
            $photo = new Photo;
            $photo->url = $path;
            $photo->save();
            $photo->refresh();
            $project->photo()->save($photo);
        }
        return response(status:201);
    }
    public function video(StoreVideoRequest $request, Project $project)
    {
        $path = $request->video->store('videos', 'public');
        if ($project->video()->exists()) {
            Storage::delete($project->video->url);
            $project->video->url = $path;
            $project->video->save();
        } else {
            $video = new Video;
            $video->url = $path;
            $video->save();
            $video->refresh();
            $project->video()->save($video);
        }
        return response(status:201);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'title' => $request->string('title'),
            'client' => $request->string('client'),
            'producer' => $request->string('producer'),
            'description' => $request->string('description'),
            'service_id' => $request->string('service_id'),

        ]);
        return $project;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return Project
     */
    public function show(Project $project)
    {
        return $project;
    }

    public function galleries(Request $request, Project $project)
    {
        $request->validate([
            // 'galleries' => ['required'],
        ]);
        foreach ($project->galleries as $gallery) {
            $gallery->project_id = null;
            $gallery->save();
        }
        foreach ($request->galleries as $gallery_id) {
            if (!($project->galleries->contains($gallery_id))) {
                $gallery = Gallery::findOrFail($gallery_id);
                $project->galleries()->save($gallery);
            }
        }
        return response(status:201);
    }



    public function getgalleries(Project $project)
    {
        //
        return $project->galleries;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProjectRequest $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if ($request->has('title')) {
            $project->update(['title' => $request->string('title')]);
        }
        if ($request->has('client')) {
            $project->update(['client' => $request->string('client')]);
        }
        if ($request->has('producer')) {
            $project->update(['producer' => $request->string('producer')]);
        }
        if ($request->has('description')) {
            $project->update(['description' => $request->string('description')]);
        }
//        if ($request->has('service_id')) {
//            $project->update(['service_id' => $request->string('service_id')]);
//        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response(status:204);
    }
}
