<?php

namespace App\Http\Controllers;

use App\Models\IPAccess;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    public function reports(){
        $posts = Post::where('visibility', 'public')->whereHas('reports', function ($query) {
            $query->where('status', 'pending')->latest();
        })->with('reports')->with('images')->paginate(12);
        $access = new IPAccess;
        $access->nsfw = true;
        return view('list', ['posts' => $posts, 'listTitle' => 'Reported Posts', 'access' => $access]);
    }

    public function do_report(Request $request){
        // $request->validate([
        //     'post' => 'required',
        //     'type' => 'required|in:pornography,child-abuse,spam,abusive,illegal,other',
        //     'message' => 'nullable|max:160',
        //     'email' => 'required|email|max:100'
        // ]);

        $validator = Validator::make($request->all(), [
            'post' => 'required',
            'type' => 'required|in:pornography,child-abuse,spam,abusive,illegal,other',
            'message' => 'nullable|max:160',
            'email' => 'required|email|max:100',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('report-error', '1');
        }
        
        $post = Post::where('id', $request->post)->first();

        if(!$post){
            return response('', 400);
        }

        $report = new Report;
        $report->ip = $this->get_client_ip();
        $report->post_id = $post->id;
        $report->email = $request->email;
        $report->message = $request->message;
        $report->type = $request->type;
        $result = $report->save();

        if(!$result){
            return response('', 500);
        }

        return redirect()->back()->with('success', 'Post is successfully reported!');
    }
}
