<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Location;
use App\Rules\ValidModel;

class LocationController extends Controller
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
                Location::paginate(25)
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
            'point_id'=>['required', new ValidModel('App\Models\Point')],

            'name'=>['required', 'unique:locations,name'],
            // 'name_ar'=>['required', 'unique:locations,name->ar'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $location = Location::firstOrCreate(
                [
                    'point_id' => $request->point_id,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'name' => $request->name,
                    'name' => $request->name,
                    //     'en' => $request->name_en,
                    // ],
                    'created_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'created', $location);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return Tenant::wrapTenant(function() use ($location){

            return Message::response('true', 'done', $location->load('point', 'beneficiaries'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $validator = \Validator::make($request->all(), [
            'point_id'=>['required', new ValidModel('App\Models\Point')],

            'name'=>['required', 'unique:locations,name,' . $location->id],
            // 'name_ar'=>['required', 'unique:locations,name->ar,' . $location->id],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $location){

            $location->update(

                [
                    'name' => $request->name,
                    //     'ar' => $request->name_ar,
                    // ],
                    // 'name' => $request->name,
                    'point_id' => $request->point_id,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'updated', Location::findOrFail($location->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        return Tenant::wrapTenant(function() use ($location){

            $location->delete();
            return Message::response(true, 'deleted');
        });
    }
}
