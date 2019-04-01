<?php

namespace App\Http\Controllers\api\v1\Category;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 

class CategoryController extends Controller
{
    //

    public $successStatus = 200;
    /** 
     * Create api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function create(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'category_name' => ['required', 'string', 'max:255', 'unique:categories'],
            'status' => 'required', 
        ]);
		if ($validator->fails()) { 
	            return response()->json(['error'=>$validator->errors()], 401);            
	        }
			$input = $request->all(); 
	        $category = Category::create($input); 
	        $success[] =  $category;
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
        $category = Category::find($id);


        if (is_null($category)) {
            return response()->json(['error'=>'Category not found.'], 401); 
        }

        $success[] =  $category;
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
            'category_name' => ['required', 'string', 'max:255'],
            'status' => 'required', 
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }
        $category = Category::find($id);
        //print_r($business); die;
        $input = $request->all();

        $category->category_name = $input['category_name'];
        $category->display_order = $input['display_order'];
        $category->icon = $input['icon'];
        $category->category_image = $input['category_image'];
        $category->status = $input['status'];
        $category->save();
        $success[] =  $category;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
	{
	    $category = Category::find($id);

	    if (is_null($category)) {
            return response()->json(['error'=>'Category not found.'], 401); 
        }

        $category = Category::findOrFail($id);
	    $category->delete();

	    $success[] =  $category;
        //return response()->json(['success'=>$success], $this-> successStatus); 
        return response()->json(['success'=>'Category deleted successfully.'], $this-> successStatus); 
	}





    
}
