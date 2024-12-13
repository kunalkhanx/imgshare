<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'image' => 'required|image|max:2048|mimes:jpg,jpeg,png',
            'title' => 'nullable|max:120',
            'description' => 'nullable|max:2048',
            'category' => 'nullable',
            'visibility' => 'required|in:public,unlisted',
            'nsfw' => 'boolean'
        ]);

        if($request->category){
            $category = Category::where('id', $request->category)->first();
            if(!$category){
                return redirect()->back()->withInput()->with('error', 'Unable to creare post. Please try again!');
            }
        }

        $file = $request->file('image');
        $date = date('d-m-Y');
        $file_path = $file->store('uploads/'. $date);

        if(!$file_path){
            return redirect()->back()->withInput()->with('error', 'Unable to creare post. Please try again!');
        }

    
        $slug = Str::random(10);
        $uniquePost = Post::where('slug', $slug)->first();

        while($uniquePost !== null){
            $slug = Str::random(10);
            $uniquePost = Post::where('slug', $slug)->first();
        }

        $post = new Post;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->description = $request->description;
        $post->category_id = $request->category;
        $post->visibility = $request->visibility;
        $post->nsfw = $request->nsfw ? true : false;
        $post->ip = $this->get_client_ip();
        $post_result = $post->save();

        if(!$post_result){
            return redirect()->back()->withInput()->with('error', 'Unable to creare post. Please try again!');
        }

        $image = new Image;
        $image->path = $file_path;
        $image->post_id = $post->id;
        $image_result = $image->save();

        if(!$image_result){
            $post->delete();
            return redirect()->back()->withInput()->with('error', 'Unable to creare post. Please try again!');
        }

        return redirect()->route('show', ['slug' => $slug])->with('success', 'Post created successfully!');
    }

    public function delete(Post $post){
        if(!$post){
            return response('', 404);
        }
        $images = $post->images()->get();
        foreach($images as $image){
            $filePath = storage_path('app/private/' . $image->path);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $post->delete();
        return redirect()->route('home')->with('success', 'Post deleted successfully!');
    }
}
