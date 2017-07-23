<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Timesheet;

class TimesheetsController extends Controller
{
    // Fields and their respective validation rules
    private $validationFields = [
        'project_id' => 'required|numeric',
        'date' => 'required|date',
        'per_diem' => 'numeric|between:0,1000000000000.99',
        'comment' => 'max:255'
    ];

    /**
     * Find a timesheet
     *
     * @param Int - The primary key
     * @return \Illuminate\Http\JsonResponse
     */
    public function single($id)
    {
        // Find the timesheet
        $timesheet = Timesheet::with(['workJobs', 'travelJobs', 'equipmentRentals', 'otherCosts'])->find($id);

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'model' => $timesheet
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
        $timesheet = $this->validateAndPopulate($request, new Timesheet, $this->validationFields);
        
        // Add user id to the timesheet
        $timesheet->user_id = Auth::id();

        // Attempt to store model
        $result = $timesheet->save();

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
            'model' => $timesheet
        ], 200);

    }

    /**
     * Update a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $timesheet = Timesheet::with(['workJobs', 'travelJobs', 'equipmentRentals', 'otherCosts'])->find($request->id);

        // Return failed response if collection empty
        if(! $timesheet){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }

        // Validate and populate the request
        $timesheet = $this->validateAndPopulate($request, $timesheet, $this->validationFields);

        // Attempt to store model
        $result = $timesheet->save();

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
            'model' => $timesheet
        ], 200);

    }    

}
