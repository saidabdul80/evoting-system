<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\Voter;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
class VotingController extends Controller
{
    public function index()
    {
    	return view('voting');
    }

    public function allAspirantsVotes()
    {
    	$votes = Voting::with('aspirants')->groupBy('aspirant_id')->selectRaw('count(*) as total, aspirant_id')->get();
    	$votes1 = DB::select('SELECT a.fname, a.lname, p.name, p.id as post_id, a.image, v1.voter_id, v1.aspirant_id  FROM (SELECT DISTINCT v.voter_id,v.aspirant_id FROM Votings AS v ) AS v1  INNER JOIN aspirants as a ON a.id = v1.aspirant_id INNER JOIN posts as p ON p.id = a.post_id');        	
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

    	$data1 = array();
    		//return $votes;    	

    	function filterArrayByKeys(array $input, array $column_keys)
			{
			    $result      = array();
			    $column_keys = array_flip($column_keys); // getting keys as values
			    foreach ($input as $key => $val) {
			         // getting only those key value pairs, which matches $column_keys
			        $result[$key] = array_intersect_key($val, $column_keys);
			    }
			    return $result;
			}

    	foreach ($posts as $key => $post) {
    		$initdata = array();
    		$counter = 0;
    		foreach ($votes1 as $key1 => $vote) {
    			//$aspirant = $votes
    			if ($post->id == $vote->post_id) {
    			$counter++;
    				$initdata[] = array(
    					'aspirant_id'=>$vote->aspirant_id,
    					'post_id'    =>$vote->post_id,
    					'image'      =>$vote->image,
    					'lname'      =>$vote->lname,
    					'fname'      =>$vote->fname,    					
    					'post_name'  =>$post->name,
    					'post_abbr'  =>$post->abbr    					
    				);
    			}
    			
    		}    		    		

    		$newData = filterArrayByKeys($initdata,['aspirant_id','post_id','post_name','image','fname','post_abbr'] );
    		$latestData = array();
    		$new_array = array_count_values(array_values(array_column($initdata,'fname')));    		
			foreach($new_array as $k=>$v)
			{
				foreach ($newData as $keyx => $valuex) {					
					if ($valuex['fname'] == $k) {
						$latestData[] = array(
							'aspirant_id'=>	$valuex['aspirant_id'],
							'post_id'=>		 $valuex['post_id'],
							'image'=>		 $valuex['image'],							
							'fname'=>		 $valuex['fname'],
							'post_name'=>	 $valuex['post_name'],
							'post_abbr'=>	 $valuex['post_abbr'],
							'total'=>		$v
						);
						break;
						/*$initdata[$k]  = $v;
						$initdata[$k]  = $v;*/
					}
				}
			}			
    		$initdata['total'] = $counter;
    		$data1[]= $latestData;
    	}    	

        return response()->json(['distinct' => $data1, 'duplicate'=>$data]);    		
    	
    }
    public function dashboard()
    {
    	return view('dashboard');
    }
    public function votersInputs()
    {

/*    	$Votings = DB::table('votings','v')->join('voters','voters.voters_id', 'v.voter_id')->groupBy('aspirant_id')->get();
*/
    	$Votings = DB::select('SELECT a.fname, a.lname, p.name, v1.voter_id, v1.aspirant_id  FROM (SELECT  v.voter_id,v.aspirant_id FROM Votings AS v ) AS v1  INNER JOIN aspirants as a ON a.id = v1.aspirant_id INNER JOIN posts as p ON p.id = a.post_id');    
    	$Votings1 = DB::select('SELECT a.fname, a.lname, p.name, v1.voter_id, v1.aspirant_id  FROM (SELECT DISTINCT v.voter_id,v.aspirant_id FROM Votings AS v ) AS v1  INNER JOIN aspirants as a ON a.id = v1.aspirant_id INNER JOIN posts as p ON p.id = a.post_id');    
        return response()->json(['distinct' => $Votings1, 'duplicate'=>$Votings]);    		
    	
    }
}
