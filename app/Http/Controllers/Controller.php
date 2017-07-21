<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Validates request data and then adds it to a model. Helper method used by store() and update()
     * @param Illuminate\Http\Request
     * @param App\Project (model)
     * @return App\Model
     */
    protected function validateAndPopulate(Request $request, Model $model, Array $validationFields)
    {
        // Ends up looking like validationFields
        $rules = [];

        // Populate rules[], but skip any dates that are an empty string in the request
        // Bypasses validation allowing an empty 'date' to be inserted in the db. (So it's optional not required)
        foreach($validationFields as $key => $val){
            // If a date rule and an empty string do not add to rules[]
            if($val == 'date' && $request->$key == '') continue;
            // If not a date field then add current field and its rule to the rules[]
            $rules[$key] = $val;
        }
        // Validate or stop proccessing :)
        $this->validate($request, $rules);

        // Add request data to model
        foreach($validationFields as $key => $val){
            $model->$key = $request->$key;
        }

        return $model;
    }

    protected function updateModelField(Request $request, Model $model, Array $validationFields){
        // Ensure request field is actually a project field
        if(array_key_exists($request->field, $validationFields)){
            // Validate field
            $this->validate($request, [
                // Dynamically validate proper field
                $request->field => $validationFields[$request->field],
                'id' => 'required|integer'
            ]);

            // Return failed response if collection empty
            if(! $model){
                // Return response for ajax call
                return response()->json([
                    'result' => false
                ], 404);
            }  

            // Update model with new field data
            $model[$request->field] = $request[$request->field];

            // Attempt to store model
            $result = $model->save();

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
                'model' => $model
            ], 200);      
        }
    } 




}
