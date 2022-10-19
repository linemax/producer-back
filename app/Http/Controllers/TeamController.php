<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Requests\StorePhotoRequest;
use App\Models\Team;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Team::paginate(10);
    }

    public function photo(StorePhotoRequest $request, Team $team)
    {
        $path = $request->photo->store('photos', 'public');
        if ($team->photo()->exists()) {
            Storage::delete($team->photo->url);
            $team->photo->url = $path;
            $team->photo->save();
        } else {
            $photo = new Photo;
            $photo->url = $path;
            $photo->save();
            $photo->refresh();
            $team->photo()->save($photo);
        }
        return response(status:201);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        return Team::create([
            'name'=>$request->string('name'),
            'occupation'=>$request->string('occupation'),
            'description'=>$request->string('description'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return Team
     */
    public function show(Team $team)
    {
        return $team;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        if ($request->has('name')) {
            $team->update(['name'=>$request->string('name')]);
        }
        if ($request->has('occupation')) {
            $team->update(['occupation'=>$request->string('occupation')]);
        }
        if ($request->has('description')) {
            $team->update(['description'=>$request->string('description')]);
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return response(status: 204);
    }
}
