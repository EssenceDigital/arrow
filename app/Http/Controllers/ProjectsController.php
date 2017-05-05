<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

use Session;

class ProjectsController extends Controller
{
    private $validationFields = [
        'province' => 'required|max:20',
        'location' => 'required|max:100',
        'details' => 'max:150',
        'client_company_name' => 'max:30',
        'client_contact_name' => 'max:30',
        'client_contact_phone' => 'max:14',
        'client_contact_email' => 'max:45',
        'first_contact_by' => 'max:30',
        'first_contact_date' => 'date',
        'land_ownership' => 'max:20',
        'land_access_granted' => 'boolean',
        'land_access_granted_by' => 'max:30',
        'land_access_contact' => 'max:30',
        'land_access_phone' => 'max:14',
        'invoiced_date' => 'date',
        'invoice_paid_date' => 'date'
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
        	if($request->invoiced_date == '') continue;
        	if($request->invoice_paid_date == '') continue;
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

    // Returns the associated view
    public function hub(){
        return view('app.projects-hub');
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
        $project = $this->validateAndPopulate($request, new Project);

        // Attempt to store model
        $result = $project->save();
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
            'project' => $project->toArray()
        ], 200);

    }

}
