<?php
namespace App\Http\Controllers\api\v1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
//use Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    //

	public $successStatus = 200;

/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
    	/*---- Test-----*/
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'first_name' => ['required', 'string', 'max:255'], 
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'], 
            //'password' => ['required', 'string', 'min:6', 'confirmed'],
            //'c_password' => 'required|same:password', 
             'mobile' => 'required|min:11|numeric',
             'user_type' => 'required',
             'status' => 'required', 
        ]);
	if ($validator->fails()) { 
	            return response()->json(['error'=>$validator->errors()], 401);            
	        }
	$input = $request->all(); 
	        $input['password'] = bcrypt($input['password']); 
	        $user = User::create($input); 
	        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
	        //$success[] =  $user;
	        $success['first_name'] =  $user->first_name;
	        $success['last_name'] =  $user->last_name;
	        $success['email'] =  $user->email;
	        $success['mobile'] =  $user->mobile;
	        $success['user_type'] =  $user->user_type;
	        $success['status'] =  $user->status;
	return response()->json(['success'=>$success], $this-> successStatus); 
	    }


}
