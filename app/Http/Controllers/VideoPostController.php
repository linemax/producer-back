<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoPostRequest;
use App\Http\Requests\UpdateVideoPostRequest;
use App\Models\VideoPost;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Laravel\Facades\Vimeo;

class VideoPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //
        $videoPost = VideoPost::all();
        return view('index')->with($videoPost);
    }

    /**
     * @throws VimeoRequestException
     */
    public function getVideos(): array
    {

        $client = new \Vimeo\Vimeo('{client_id}', '{client_secret}', '{access_token}');
        return $client->request('/projects', array(), 'GET');
    }
    /**
     * upload videos to vimeo
     *
     */
    public function uploadVideos()
    {
        Vimeo::upload('');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        //
        return view('video_post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVideoPostRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVideoPostRequest $request,  VideoPost $videoPost)
    {
        //
        $validData = $request->validate(
            [
                'title' => ['required', 'unique:video_posts', 'max:255'],
                'video' =>['required', 'mimetypes:video/avi,video/mpeg,video/quicktime, video/x-flv,application/x-mpegURL,video/mp4,video/3gpp'],
                'description'=> 'required',
                'author'=>['unique:App\Models\User,email_address']
            ]);
        $validator = Validator::make(Input::all(), $validData);
        if ($validator->fails()){
            return  Redirect::to('videos/create')->withErrors($validator);
        }
        else{

            $videoPost->title = Input::get('title');
            $videoPost->description = Input::get('description');
            $videoPost->video = Input::get('video');
            $videoPost->author = Input::get('author');
            $videoPost->save();

            Session::flash('message', 'Created Successfully');
            return Redirect::to('videos');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoPost  $videoPost
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(VideoPost $videoPost)
    {
        return \view('video_post.show')->with($videoPost);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VideoPost  $videoPost
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(VideoPost $videoPost)
    {
        //
        return view('video_post.edit')->with($videoPost);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVideoPostRequest  $request
     * @param  \App\Models\VideoPost  $videoPost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVideoPostRequest $request, VideoPost $videoPost)
    {
        //
        $validData = $request->validate(
            [
                'title' => ['required', 'unique:video_posts', 'max:255'],
                'video' =>['required', 'mimetypes:video/avi,video/mpeg,video/quicktime, video/x-flv,application/x-mpegURL,video/mp4,video/3gpp'],
                'description'=> 'required',
                'author'=>['unique:App\Models\User,email_address']
            ]);
        $validator = Validator::make(Input::all(), $validData);
        if ($validator->fails()){
            return  Redirect::to('videos/'. $videoPost .'/edit')->withErrors($validator);
        }
        else{
            $videoPost->update($validData->all());

            Session::flash('message', 'Updated Successfully');
            return Redirect::to('/videos');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VideoPost  $videoPost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(VideoPost $videoPost)
    {
        //
        $videoPost->delete();

        Session::flash('message', 'Deleted Successfully');
        return Redirect::to('videos');
    }
}
