<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Proposal;

class ProposalsController extends Controller
{
    private $validationFields = [
        'project_id' => 'required|numeric',
        'plans' => 'required|max:30',
        'work_type' => 'required|max:30',
        'work_overview' => 'required|max:150',
        'response_by' => 'required|date',
        'estimate' => 'required|numeric|between:0,1000000000000.99',
        'approval_date' => 'date'
    ];

    /**
     * Validates request data and then adds it to a model. Helper method used by store() and update()
     *
     * @return App\Model
     */
    private function validateAndPopulate(Request $request, $project)
    {
        $rules = [];

        foreach($this->validationFields as $key => $val){
        	if($request->approval_date == '' && $key == 'approval_date') continue;
        	$rules[$key] = $val;
        }
        // Validate or stop proccessing :)
        $this->validate($request, $rules);

        // Add request data to model
        foreach($this->validationFields as $key => $val){
            $project->$key = $request->$key;
        }

        return $project;
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
        $proposal = $this->validateAndPopulate($request, new Proposal);

        // Find parent project
        $project = Project::with('proposal')->findOrFail($request->project_id);

        // Attempt to store model
        $result = $project->proposal()->save($proposal);
        // Verify success on store
        if(! $result){
            // Return response for ajax call
            return response()->json([
                'result' => false,
            ], 404);
        }

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'model' => $proposal
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
        $proposal = Proposal::find($request->id);

        // Return failed response if collection empty
        if(! $proposal){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }

        // Validate and populate the request
        $proposal = $this->validateAndPopulate($request, $proposal);

        // Attempt to store model
        $result = $proposal->save();

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
            'model' => $proposal
        ], 200);

    }    

}
