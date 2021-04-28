<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Career;
use App\Rules\ValidModel;

class CareerController extends Controller
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
                Career::all()
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
            'location_id'=>['required', new ValidModel('App\Models\Location')],

            'name'=>['required'],
            // 'name_ar'=>['required', 'unique:locations,name->ar'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        $career = Career::checkOrCreate(
            [
                'location_id' => $request->location_id,
                'name' => $request->name,
            ],

            [
                // 'name' => $request->name,
                'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                //     'en' => $request->name_en,
                // ],
                'created_by' => auth()->user()->user_name,
            ]
        );

        return Message::response(true, 'created', $career);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function show(Career $career)
    {
        return Tenant::wrapTenant(function() use ($career){

            return Message::response('true', 'done', $career);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Career  $career
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Career $career)
    {
        $validator = \Validator::make($request->all(), [
            'location_id'=>['required', new ValidModel('App\Models\Location')],

            'name'=>['required'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }


        $carrer1 = $career->firstOrUpdate(
        [
            'name' => $request->name,
            'location_id' => $request->location_id,
        ],

        [
            'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
            'modified_by' => auth()->user()->user_name,
        ]);                        
        

        return Message::response(true, 'updated', $carrer1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Career $career
     * @return \Illuminate\Http\Response
     */
    public function destroy(Career $career)
    {
        return Tenant::wrapTenant(function() use ($career){

            $career->delete();
            return Message::response(true, 'deleted');
        });
    }
}
