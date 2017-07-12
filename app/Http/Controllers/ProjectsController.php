<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Project;
use App\ProjectUser;
use App\ProjectComment;
use App\User;

use Session;

class ProjectsController extends Controller
{
    private $validationFields = [
        'province' => 'max:20',
        'location' => 'max:100',
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
        'invoice_paid_date' => 'date',
        // "Proposal related fields"
        'plans' => 'max:30',
        'work_type' => 'max:30',
        'work_overview' => 'max:150',
        'response_by' => 'date',
        'estimate' => 'numeric|between:0,1000000000000.99',
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
            if($request->first_contact_date == '' && $key == 'first_contact_date') continue;
        	if($request->invoiced_date == '' && $key == 'invoiced_date') continue;
        	if($request->invoice_paid_date == '' && $key == 'invoice_paid_date') continue;
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
        return Project::paginate(15);      
    }

    /**
     * Find a project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function single($id)
    {
        $project = Project::with(['comments', 'comments.user', 'timeline', 'users'])->find($id);

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

    public function addCrewMember(Request $request){
        // Find project
        $project = Project::find($request->project_id);
        // Find the user now
        $user = User::find($request->user_id);        
        // Attempt to store association
        $result = $project->users()->save($user);
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
            'model' => $user
        ], 200);               
    }

    public function removeCrewMember(Request $request){
        // Find the association
        $project = Project::find($request->project_id);

        $result = $project->users()->detach($request->user_id);

        // Verify success
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

    public function addComment(Request $request){
        $this->validate($request, [
            'project_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'comment' => 'required|max:255'
        ]);

        // Assemble the comment
        $comment = new ProjectComment;
        $comment->comment = $request->comment;
        $comment->user_id = $request->user_id;
        $comment->project_id = $request->project_id;

        // Attempt to store model
        $result = $comment->save();
        // Verify success on store
        if(! $result){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }

        // Get the user model
        $user = User::find($request->user_id);

        // Return failed response if no user
        if(! $user){
            // Return response for ajax call
            return response()->json([
                'result' => false
            ], 404);
        }
        // Add user to comment model
        $comment->user = $user;

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'model' => $comment
        ], 200);

    }

    public function removeComment(Request $request){
        // Find user or throw 404 :)
        $comment = ProjectComment::findOrFail($request->comment_id);

        // Attempt to remove 
        $result = $comment->delete();
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

    public function updateField(Request $request){
        return $this->updateModelField(
            $request,
            Project::with(['comments', 'comments.user', 'timeline', 'users'])->find($request->id),
            $this->validationFields
        );        
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
