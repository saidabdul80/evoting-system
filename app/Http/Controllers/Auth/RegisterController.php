<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Aspirant;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\UploadTrait;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use UploadTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        return view('auth.register');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'file'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
            $role = $request->get('role');         
        if ($role == 'aspirants') {
            if ($request->has('profile_image')) {
                 $image = $request->profile_image;
                 $folder = '/uploads/images/';                 
                $name =$request->get('fname').'_'.$request->get('lastname'). '_'.time().'.'.$image->getClientOriginalExtension();
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder.$name;  
                $image->move(public_path('/uploads/images'), $name);
                 // Upload image                
                Aspirant::create([
                    'fname'   => $request->get('fname'),
                    'lname'   => $request->get('lastname'),
                    'post_id' => $request->get('posts'),
                    'gender'  => $request->get('gender'),
                    'image'   => $filePath,
                    'phone'   => $request->get('phone'),
                    'counts'   => 0,
                    'email'   => $request->get('email'),
                    'password' => md5($request->get('password')),
                ]);                
                return redirect()->back()->with(['status' => 'Profile updated successfully.']);
            }
        }else{            
            return User::create([
                'fname' => $request->get('fname'),
                'lname' => $request->get('lname'),               
                'email' => $request->get('email'),
                'password' => md5($request->get('password')),
            ]);
        }
    }
}
