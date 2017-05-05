<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{

    private $validationFields = [
        'first' => 'required|string|max:25',
        'last' => 'required|string|max:25',
        'email' => 'required|string|email|max:255|unique:users',
        'permissions' => 'required|string|max:10',
        'password' => 'required|string|min:6|confirmed',
        'company_name' => 'required|string|max:25',
        'hourly_rate_one' => 'required|numeric|between:0,1000000000000.99',
        'hourly_rate_two' => 'numeric|between:0,1000000000000.99',
        'gst_number' => 'required|string|max:25'
    ];

    /**
     * Validates request data and then adds it to a model. Helper method used by store() and update()
     *
     * @return App\Model
     */
    private function validateAndPopulate(Request $request, $user)
    {
    	if($request->hourly_rate_two == null){
    		$request->hourly_rate_two = 0;
    	}

        // Validate or stop proccessing :)
        $this->validate($request, $this->validationFields);

        // Add request data to model
        foreach($this->validationFields as $key => $val){
            $user->$key = $request->$key;
        }

        return $user;
    }

    // Returns the associated view
    public function hub(){
        return view('app.users-hub');
    }

    /**
     * Find all taxes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $users = User::all();

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'users' => $users->toArray()
        ], 200);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate and populate the request
        $user = $this->validateAndPopulate($request, new User);

        // Attempt to store model
        $result = $user->save();
        // Verify success on store
        if(! $result){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'user' => $user->toArray()
        ], 200);

    }



}
