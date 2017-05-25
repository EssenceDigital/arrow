<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Project;

use Session;

class ProjectsController extends Controller
{
    private $validationFields = [
        'province' => 'required|max:20',
        'location' => 'required|max:100',
        'details' => 'max:150',
        'client_company_name' => 'required|max:30',
        'client_contact_name' => 'required|max:30',
        'client_contact_phone' => 'required|max:14',
        'client_contact_email' => 'max:45',
        'first_contact_by' => 'required|max:30',
        'first_contact_date' => 'required|date',
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
        	if($request->invoiced_date == '' && $key == 'invoiced_date') continue;
        	if($request->invoice_paid_date == '' && $key == 'invoice_paid_date') continue;
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
     * Find all projects
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return Project::with('proposal')->paginate(15);      
    }

    /**
     * Find a project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function single($id)
    {
        $project = Project::with('proposal')->find($id);

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'model' => $project
        ], 200);        
    }

    /**
     * Find unique companies
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uniqueClients()
    {
        $clients = Project::distinct()->get(['client_company_name']);

        // Format unique companies in array
        $list = [];
        foreach($clients as $client){
            array_push($list, $client->client_company_name);
        }

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'clients' => $list
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
            'model' => $project
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
        $project = Project::with('proposal')->find($request->id);

        // Return failed response if collection empty
        if(! $project){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }

        // Validate and populate the request
        $project = $this->validateAndPopulate($request, $project);

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
            'model' => $project->toArray()
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Find user or throw 404 :)
        $project = Project::findOrFail($request->id);

        // Attempt to remove 
        $result = $project->delete();
        // Verify success on store
        if(! $result){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }

        // Return successful response for ajax call
        return response()->json([
            'result' => 'success'
        ], 200);
    }


}
