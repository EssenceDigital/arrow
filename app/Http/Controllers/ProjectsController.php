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
    // Fields and their respective validation rules
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
        'plans' => 'max:30',
        'work_type' => 'max:30',
        'work_overview' => 'max:150',
        'response_by' => 'date',
        'estimate' => 'numeric|between:0,1000000000000.99',
        'approval_date' => 'date'
    ];

    /**
     * Find all projects and returns a paginated result
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return Project::paginate(15);      
    }

    public function filter(Request $request){
        // Validate or stop proccessing :)
        $this->validate($request, [
            'client_company_name' => 'max:25',
            'province' => 'max:25'
            //'invoice_paid_date' => 'required|boolean'
        ]);

        // Not null = paid
        // Construct where array for query
        $queryArray = [];
        // Add company field or not
        if($request->client_company_name != ''){
            // Push array clause
            array_push($queryArray, ['client_company_name', '=', $request->client_company_name]);
        }
        // Add province field or not
        if($request->province != ''){
            // Push array clause
            array_push($queryArray, ['province', '=', $request->province]);
        }
        // Add invoiced date or not
        if($request->invoice_paid_date != ''){
            if($request->invoice_paid_date == 0){
                array_push($queryArray, ['invoice_paid_date', '=', null]);
            } else if($request->invoice_paid_date ==  1){
                array_push($queryArray, ['invoice_paid_date', '<>', null]);
            }
        }

        return Project::where($queryArray)->paginate(15);      
    }

    /**
     * Find a project
     *
     * @param Int - The primary key
     * @return \Illuminate\Http\JsonResponse
     */
    public function single($id)
    {
        // With all foreign keys / children
        $project = Project::with(['comments', 'comments.user', 'timeline', 'users', 'timesheets'])->find($id);

        // Return response for ajax call
        return response()->json([
            'result' => 'success',
            'model' => $project
        ], 200);        
    }

    /**
     * Find unique clients from all projects
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uniqueClients()
    {
        // Run query to find unique clients from projects
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
        $project = $this->validateAndPopulate($request, new Project, $this->validationFields);

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
     * Associates a user with a project based on the id in the request
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
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

    /**
     * Unassociates a user with a project based on the id in the request
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function removeCrewMember(Request $request){
        // Find the association
        $project = Project::find($request->project_id);
        // Attempt to detach
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

    /**
     * Adds a ProjectComment to storage
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function addComment(Request $request){
        // Validate request
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

        // Add the user to the comment model before returning response
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

    /**
     * Removes a ProjectComment from storage.
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function removeComment(Request $request){
        // Find or throw 404
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
     * Updates a single field on a project
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function updateField(Request $request){
        // Use the parent method to update
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
        $project = $this->validateAndPopulate($request, $project, $this->validationFields);

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
