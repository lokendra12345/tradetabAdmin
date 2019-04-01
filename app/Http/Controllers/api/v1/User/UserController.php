<?php
namespace App\Http\Controllers\api\v1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
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
     * User register api 
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
            'mobile' => 'required|min:11|numeric',
            'user_type' => 'required',
            'status' => 'required', 
        ]);
	       if ($validator->fails()) { 
	            return response()->json(['error'=>$validator->errors()], 401);            
	        }
			$input = $request->all(); 
	        $input['password'] = bcrypt($input['password']); 


            //$request->offsetSet('password', Hash::make($request->password));
	        $user = User::create($input); 
            //$input['api_token'] = $user->createToken('MyApp')-> accessToken; 
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



/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);


        if (is_null($user)) {
            return response()->json(['error'=>'User not found.'], 401); 
        }

        $success[] =  $user;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }



/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [ 
            'first_name' => ['required', 'string', 'max:255'], 
            'last_name' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'], 
            'mobile' => 'required|min:11|numeric',
            'user_type' => 'required',
            'status' => 'required', 
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }
        $user = User::find($id);
        //print_r($user); die;
        $input = $request->all();


        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $user->email;
        $user->password = bcrypt($input['password']); 
        $user->mobile = $input['mobile'];
        $user->user_type = $input['user_type'];
        $user->status = $input['status'];
        $user->save();
        $success[] =  $user;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }

	 


}
