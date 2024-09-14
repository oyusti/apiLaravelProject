<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::included()
                            ->filter()
                            ->sort()
                            ->getOrPaginate();

        return PostResource::collection($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts',
            'extract' => 'required|string',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id', 
        ]);

        /* return $data; */

        $user = auth()->user();
        $data['user_id'] = $user->id;
        $post = Post::create($data);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::included()->findorFail($id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //utilizamos el metodo authorize de la clase Gate para verificar si el usuario puede modificar el post
        Gate::authorize('modify', $post);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,' . $post->id,
            'extract' => 'required|string',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        $post->update($data);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //utilizamos el metodo authorize de la clase Gate para verificar si el usuario puede modificar el post
        Gate::authorize('modify', $post);
        
        $post->delete();
        return new PostResource($post);
    }
}
