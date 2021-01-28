<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Point;

class PointController extends Controller
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
                Point::with('locations')->paginate(25)
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
            'name'=>['required', 'unique:points'],
            // 'deleted_at' => 'nullable|date',
            'is_enabled' => 'nullable|boolean',
            // 'created_by' => 'nullable|alpha_num',
            // 'modified_by' => 'nullable|alpha_num',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $type = Point::firstOrcreate(
                ['name' => $request->name],

                [
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'created', $type);          
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        return Tenant::wrapTenant(function() use ($point){

            return Message::response('true', 'done', $point->load('locations'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:points,name,' . $point->id],
            // 'deleted_at' => 'nullable|date',
            'is_enabled' => 'nullable|boolean',
            // 'created_by' => 'nullable|alpha_num',
            // 'modified_by' => 'required|alpha_num',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($point, $request){

            $point->update(
                [
                    'name' => $request->name,
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    // 'created_by' => $request->created_by,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', Point::findOrFail($point->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        return Tenant::wrapTenant(function() use ($point){

            $point->delete();
            return Message::response(true, 'deleted');
        });
    }
}
