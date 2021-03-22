<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\{Tenant, Message};
use App\Models\LocationType;

class LocationTypeController extends Controller
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
                LocationType::paginate(25)
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
            // 'name_en'=>['required', 'unique:location_types,name->en'],
            'name'=>['required', 'unique:location_types,name'],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $locationType = LocationType::firstOrCreate(
                [
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'name' => $request->name,
                    'name' => $request->name,
                        // 'en' => $request->name_en,
                    // ],
                    'created_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'created', $locationType);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LocationType $locationType)
    {
        return Tenant::wrapTenant(function() use ($locationType){

            return Message::response('true', 'done', $locationType);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocationType $locationType)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:location_types,name,' . $locationType->id],
            // 'name_ar'=>['required', 'unique:location_types,name->ar,' . $locationType->id],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $locationType){

            $locationType->update(

                [
                    'name' => $request->name,
                        // 'ar' => $request->name_ar,
                    // ],
                    // 'name' => $request->name,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'updated', LocationType::findOrFail($locationType->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationType $locationType)
    {
        return Tenant::wrapTenant(function() use ($locationType){

            $locationType->delete();
            return Message::response(true, 'deleted');
        });
    }
}
