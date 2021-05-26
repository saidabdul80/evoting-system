<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Aspirant;
use App\Models\Voter;
use App\Models\Voting;
use \DB;
class PostController extends Controller
{
    function getAllPost(Request $request){
    	return Post::all();
    }

    function getAspirants(Request $request){
    	return Post::with('aspirants')->get();
    }

    function checkEligility(Request $request){
    	$voter = Voter::where('voters_id', $request->get('user_id'))->first();    	    	
    	if (is_null($voter)) {    		
            return response()->json(['success' => true,'code'=>419], 200);    		
    	}else if($voter->voted == 1){    		
            return response()->json(['success' => true, 'code'=>409], 200);    		
    	}
        return response()->json(['success' => true, 'code'=>200], 200);    		
    	
    }
    function submitElect(Request $request){
    	$user_id = $request->get('user_id');
    	$candidate = json_decode($request->get('selected_candidate'));
    	
    	$array = array();
    	for ($i=0; $i < sizeof($candidate) ; $i++) { 
    		array_push($array, array(    			
    			'voter_id'=> $user_id,
    			'aspirant_id'=>$candidate[$i]
    			)
    		);
    	}

    	$voter = Voter::where('voters_id',$user_id)->update(['voted'=>1]);    	
    	Voting::insert($array);
        return response()->json(['success' => true, 'code'=>200], 200);    		
    	
    }

}
