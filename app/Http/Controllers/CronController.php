<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\IPAccess;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CronController extends Controller
{
    public function deletePosts(){

        $postsDeleted = 0;
        $imagesDeleted = 0;

        $dateThreshold = Carbon::now()->subDays(7);

        $posts = Post::where('created_at', '<', $dateThreshold)->with('images')->get();

        foreach($posts as $post){
            foreach($post->images as $image){
                $filePath = storage_path('app/private/' . $image->path);

                if (file_exists($filePath)) {
                    unlink($filePath);
                    $imagesDeleted++;
                }
            }
            $postsDeleted++;
        }

        Post::where('status', 1)
        ->where('created_at', '<', $dateThreshold)
        ->delete();

        return response()->json(['posts_deleted' => $postsDeleted, 'images_deleted' => $imagesDeleted]);

    }

    public function ipDelete(){
        $dateThreshold = Carbon::now()->subDays(7);
        $deletedCount = IPAccess::where('created_at', '<', $dateThreshold)->delete();

        return response()->json(['ip_deleted' => $deletedCount]);
    }

    public function clearFile(){

        $foldersDeleted = 0;
        $filesDeleted = 0;

        $folders =  Storage::allDirectories('uploads');
        foreach($folders as $folder){
            $files =  Storage::allFiles($folder);
            if(count($files) === 0){
                Storage::deleteDirectory($folder);
                $foldersDeleted++;
            }
            foreach($files as $file){
                $image = Image::where('path', $file)->first();
                if(!$image){
                    Storage::delete($file);
                    $filesDeleted++;
                }
            }
        }
        
        return response()->json(['folders_deleted' => $foldersDeleted, 'files_deleted' => $filesDeleted]);
        
    }
}
