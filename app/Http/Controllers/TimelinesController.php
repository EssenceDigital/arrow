<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\Timeline;

class TimelinesController extends Controller
{
    private $validationFields = [
        'project_id' => 'required|numeric',
        'permit_application_date' => 'date',
        'permit_recieved_date' => 'date',
        'permit_number' => 'max:50',
        'site_number_application_date' => 'date',
        'site_number_recieved_date' => 'date',
        'site_number' => 'max:50',
        'completion_target' => 'date',
        'field_completion_target' => 'date',
        'report_completion_target' => 'date',
        'fieldwork_scheduled' => 'boolean',
        'artifact_analysis' => 'boolean',
        'mapping' => 'boolean',
        'writing' => 'boolean',
        'draft_submitted' => 'boolean',
        'draft_accepted' => 'boolean',
        'final_approval' => 'boolean'
    ];

    /**
     * Validates request data and then adds it to a model. Helper method used by store() and update()
     *
     * @return App\Model
     */
    private function validateAndPopulate(Request $request, $timeline)
    {
        $rules = [];

        foreach($this->validationFields as $key => $val){
        	if($request->permit_application_date == '' && $key == 'permit_application_date') continue;
        	if($request->permit_recieved_date == '' && $key == 'permit_recieved_date') continue;
        	if($request->site_number_application_date == '' && $key == 'site_number_application_date') continue;
            if($request->site_number_recieved_date == '' && $key == 'site_number_recieved_date') continue;
        	if($request->completion_target == '' && $key == 'completion_target') continue;
        	if($request->field_completion_target == '' && $key == 'field_completion_target') continue;
        	if($request->report_completion_target == '' && $key == 'report_completion_target') continue;

        	$rules[$key] = $val;
        }
        // Validate or stop proccessing :)
        $this->validate($request, $rules);

        // Add request data to model
        foreach($this->validationFields as $key => $val){
            $timeline->$key = $request->$key;
        }

        return $timeline;
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
        $timeline = $this->validateAndPopulate($request, new Timeline);

        // Find parent project
        $project = Project::with('timeline')->findOrFail($request->project_id);

        // Attempt to store model
        $result = $project->timeline()->save($timeline);
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
            'model' => $timeline
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
        $timeline = Timeline::find($request->id);

        // Return failed response if collection empty
        if(! $timeline){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }

        // Validate and populate the request
        $timeline = $this->validateAndPopulate($request, $timeline);

        // Attempt to store model
        $result = $timeline->save();

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
            'model' => $timeline
        ], 200);

    } 

}
