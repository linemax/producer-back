<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServicesRequest;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdateServicesRequest;
use App\Models\Services;
use App\Models\Photo;
use App\Models\Project;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Services::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesRequest $request)
    {
        $service = Services::create([
            'name'=>$request->string('name'),
            'description'=>$request->string('description')
        ]);

    }



    public function getphotos(Services $service)
    {
        //
        return $service->photos;
    }
    public function getplans(Services $service)
    {
        //
        return $service->plans;
    }

    public function getphoto(Services $service)
    {
        //
        return $service->photo;
    }

    // public function plans(Request $request, Services $service)
    // {
    //     $request->validate([
    //         // 'galleries' => ['required'],
    //     ]);
    //     foreach ($service->plans as $plan) {
    //         $plan->service_id = null;
    //         $plan->save();
    //     }
    //     foreach ($request->plans as $plan_id) {
    //         if (!($service->plans->contains($plan_id))) {
    //             $plan = Plans::findOrFail($plan_id);
    //             $service->plans()->save($plan);
    //         }
    //     }
    //     return response(status:201);
    // }

    public function photo(StorePhotoRequest $request, Services $service)
    {
        $path = $request->photo->store('photo', 'public');
        if ($service->photo()->exists()) {
            Storage::delete($service->photo->url);
            $service->photo->url = $path;
            $service->photo->save();
        } else {
            $photo = new Photo;
            $photo->url = $path;
            $photo->save();
            $photo->refresh();
            $service->photo()->save($photo);
        }
        return response(status:201);
    }

    public function photos(StorePhotoRequest $request, Services $service)
    {
        $path = $request->photo->store('photos', 'public');
        $photo = new Photo;
        $photo->url = $path;
        $photo->save();
        $photo->refresh();
        $service->photos()->save($photo);

        return response(status:201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return Services
     */
    public function show(Services $service)
    {
        return $service;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServicesRequest  $request
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicesRequest $request, Services $service)
    {
        if ($request->has('name')){
            $service->update(['name'=>$request->string('name')]);
        }
        if ($request->has('description')){
            $service->update(['description'=>$request->string('description')]);
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $service)
    {
        $service->delete();
        return response(status: 204);
    }
}
