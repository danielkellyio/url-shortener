<?php

namespace App\Http\Controllers;

use App\Click;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    public function redirectCodeToUrl($id){
        $url = Url::find($id);
        if(empty($url)){
            abort(404);
        }
        Click::newFromRequest();
        return redirect($url->url, 302);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $urls = Url::forCurrentUser()->get();
        return response()->json($urls);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $url = Url::create($request->all());
        $url->user_id = $user->id;
        $url->save();
        return response()->json($url);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $unique = '';
        if(Url::forCurrentUser()->where('id', $id)->count() === 0){
            $unique = '|unique:urls';
        }

        $request->validate([
            'id' => 'required|max:255' . $unique,
            'url' => 'required|url',
        ]);


        $url = Url::updateOrCreate(
            [
                'id' => $id,
                'user_id'=> $user->id
            ],
            [
                'id' => $request->get('id'),
                'url' => $request->get('url'),
                'user_id' => $user->id
            ]
        );

        // user id not fillable so save it here
        $url->user_id = $user->id;
        $url->save();
        return response()->json($url);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $url = Url::forCurrentUser()->where('id', $id)->first();
        if($url){
            Url::destroy($id);
        }else{
            return response()->json('unauthorized', 401);
        }
    }

    /**
     * Get the url count
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(){
        $count = Url::forCurrentUser()->count();
        return response()->json($count);
    }
}
