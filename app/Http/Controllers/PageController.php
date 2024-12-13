<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Image;
use App\Models\IPAccess;
use App\Models\Post;
use App\Models\Visitor;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{

    public function create(){
        $categories = Category::all();
        $recent = Post::where('visibility', 'public')->latest()->with('images')->limit(6)->get();
        
        $access = IPAccess::where('ip', $this->get_client_ip())->where('nsfw', true)->first();

        return view('create', ['categories' => $categories, 'recent' => $recent, 'access' => $access]);
    }

    public function recent(){
        $posts = Post::where('visibility', 'public')->latest()->with('images')->with('reports')->paginate(12);
        $access = IPAccess::where('ip', $this->get_client_ip())->where('nsfw', true)->first();
        return view('list', ['posts' => $posts, 'listTitle' => 'Recent', 'access' => $access]);
    }

    public function trending(){
        $posts = Post::where('visibility', 'public')->whereDate('created_at', Carbon::today())->orderBy('views', 'desc')->with('images')->with('reports')->paginate(12);
        $access = IPAccess::where('ip', $this->get_client_ip())->where('nsfw', true)->first();
        return view('list', ['posts' => $posts, 'listTitle' => 'Trending', 'access' => $access]);
    }

    public function show($slug){
        $recent = Post::where('visibility', 'public')->latest()->with('images')->with('reports')->limit(6)->get();
        $post = Post::where('slug', $slug)->with('images')->with('category')->first();

        if(!$post){
            return response('', 404);
        }

        $access = IPAccess::where('ip', $this->get_client_ip())->where('nsfw', true)->first();

        if(!$post->nsfw || ($access && $access->nsfw)){
            $visitor = Visitor::where('ip', $this->get_client_ip())->where('post_id', $post->id)->first();

            if(!$visitor){
                $visitor = new Visitor;
                $visitor->ip = $this->get_client_ip();
                $visitor->post_id = $post->id;
                $visitor->save();
                $post->views = $post->views + 1;
                $post->save();
            }
        }

        // $img = \Illuminate\Support\Facades\Storage::temporaryUrl($post->images[0]->path, now()->addMinutes(2));    

        return view('post', ['post' => $post, 'recent' => $recent, 'access' => $access]);
    }

    public function search(Request $request){
        if(!$request->q){
            return response('', 404);
        }

        $search = $request->q;
        $posts = Post::where('visibility', 'public')->where(function($q) use($search){
            $q->where('title', 'LIKE', '%'. $search . '%')->orWhere('description', 'LIKE', '%'. $search . '%');
        })->paginate(12);

        $access = IPAccess::where('ip', $this->get_client_ip())->where('nsfw', true)->first();

        return view('list', ['posts' => $posts, 'listTitle' => 'Search: ' . $search, 'access' => $access]);
    }

    public function categories($slug){
        
        $cateogry_id = null;
        $category_title = 'Uncategorized';

        if($slug !== 'uncategorized'){
            $category = Category::where('slug', $slug)->first();

            if(!$category){
                return response('', 404);
            }
            $cateogry_id = $category->id;
            $category_title = $category->title;
        }

        $posts = Post::where('visibility', 'public')->where('category_id', $cateogry_id)->paginate(12);
        
        $access = IPAccess::where('ip', $this->get_client_ip())->where('nsfw', true)->first();

        return view('list', ['posts' => $posts, 'listTitle' => 'Category: ' . $category_title, 'access' => $access]);
    }

    public function image(Image $image){
        if(!$image){
            return response('', 404);
        }

        $filePath = storage_path('app/private/' . $image->path);

        if (!file_exists($filePath)) {
            return response('', 404);
        }
    
        $mimeType = mime_content_type($filePath);
    
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
        ]);
    }

    public function terms(){
        return view('terms');
    }

    public function policy(){
        return view('policy');
    }

    public function faq(){
        return view('faq');
    }
}
