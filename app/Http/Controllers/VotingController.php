<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\Post;
class VotingController extends Controller
{
    public function index()
    {
    	return view('voting');
    }

    public function allAspirantsVotes()
    {
    	$votes = Voting::with('aspirants')->groupBy('aspirant_id')->selectRaw('count(*) as total, aspirant_id')->get();
    	$posts = Post::all();
    	$data = array();
    		//return $votes;
    	foreach ($posts as $key => $post) {
    		$initdata = array();
    		foreach ($votes as $key1 => $vote) {
    			//$aspirant = $votes
    			if ($post->id == $vote->aspirants->post_id) {
    				$initdata[] = array(
    					'aspirant_id'=>$vote->aspirants->id,
    					'post_id'    =>$vote->aspirants->post_id,
    					'image'      =>$vote->aspirants->image,
    					'lname'      =>$vote->aspirants->lname,
    					'fname'      =>$vote->aspirants->fname,
    					'email'      =>$vote->aspirants->email,
    					'post_name'  =>$post->name,
    					'post_abbr'  =>$post->abbr,
    					'total'      =>$vote->total
    				);
    			}
    			
    		}
    		$data[]= $initdata;
    	}
    	return $data;
    }
    public function dashboard()
    {
    	return view('dashboard');
    }
}
