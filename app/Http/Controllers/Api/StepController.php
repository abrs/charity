<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Step;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tenant::wrapTenant(function() {

            return Message::response(
                true,
                'done',
                Step::paginate(25)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            // 'name_en'=>['required', 'unique:steps,name->en'],
            'name'=>['required', 'unique:steps,name'],
            // 'description_en'=>['nullable'],
            'description'=>['nullable'],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }


        $step = Step::checkOrcreate(
            [
                'name' => $request->name,
            ],
            
            [

                'description' => $request->has('description') ? $request->description : Null,
                //     'en' => $request->has('description_en') ? $request->description_en : Null,
                // ],
                
                #if is_enabled is null then it's false
                'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                'created_by' => auth()->user()->user_name,
            ]
        );

        return Message::response(true, 'created', $step);          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function show(Step $step)
    {
        return Tenant::wrapTenant(function() use ($step){

            return Message::response('true', 'done', $step);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Step $step)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:steps,name,' . $step->id],
            // 'name_ar'=>['required', 'unique:steps,name->ar,' . $step->id],
            'description'=>['nullable'],
            // 'description_ar'=>['nullable'],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($step, $request){

            $step->update(
                [
                    'name' => $request->name,
                    //     'en' => $request->name_en,
                    // ],

                    'description' => $request->has('description') ? $request->description : $step->description,
                    //     'en' => $request->has('description_en') ? $request->description_en : $step->description_en,
                    // ],
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'created_by' => $request->created_by,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', Step::findOrFail($step->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function destroy(Step $step)
    {
        return Tenant::wrapTenant(function() use ($step){

            $step->delete();
            return Message::response(true, 'deleted');
        });
    }

    /**
     * =========================
     * extra functionality
     * =======
     */    
}
