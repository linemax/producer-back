<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlansRequest;
use App\Http\Requests\UpdatePlansRequest;
use App\Models\Plans;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Plans::paginate(10);
    }


//
//    public function photo(StorePhotoRequest $request, Plans $plans)
//    {
//        $path = $request->photo->store('photos', 'public');
//        if ($plans->photo()->exists()) {
//            Storage::delete($plan->photo->url);
//            $plans->photo->url = $path;
//            $plans->photo->save();
//        } else {
//            $photo = new Photo;
//            $photo->url = $path;
//            $photo->save();
//            $photo->refresh();
//            $plans->photo()->save($photo);
//        }
//        return response(status:201);
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlansRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlansRequest $request)
    {
        return Plans::create([
            'title' => $request->string('title'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plans  $plans
     * @return \Illuminate\Http\Response
     */
    public function show(Plans $plans)
    {
        //

        return $plans;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlansRequest  $request
     * @param  \App\Models\Plans  $plans
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlansRequest $request, Plans $plans)
    {
        //
        if ($request->has('title')) {
            $plans->update(['title' => $request->string('title')]);
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plans  $plans
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plans $plans)
    {
        //
        $plans->delete();
        return response(status:204);
    }
}
