<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Relation;

class RelationController extends Controller
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
                Relation::paginate(25)
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
            'name'=>['required', 'unique:relations,name'],
            'description' => ['nullable'],
            // 's_beneficiary_id' => ['nullable', new ValidModel('App\Models\Beneficiary_Info')],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        return Tenant::wrapTenant(function() use ($request){

            $relation = Relation::firstOrCreate(

                ['name' => $request->name],

                [
                    'code' => $this->getCode(5, now()),
                    'description' => $request->description,
                    // 's_beneficiary_id' => $request->has('s_beneficiary_id') ? $request->s_beneficiary_id : Null,
                    
                    'created_by' => auth()->user()->user_name,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                ]
            );

            // if(!is_null($request->s_beneficiary_id)) {

            //     if($relation->s_beneficiary_id == $relation->beneficiary->id) {   
                
            //         $relation->delete();
            //         return Message::response(false, 'cannot link a beneficiary to himself!!');
            //     }
            // }

            return Message::response(true, 'created', $relation);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Relation  $relation
     * @return \Illuminate\Http\Response
     */
    public function show(Relation $relation)
    {
        return Tenant::wrapTenant(function() use ($relation){

            return Message::response('true', 'done', $relation);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Relation  $relation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Relation $relation)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:relations,name,' . $relation->id],
            'description' => ['nullable'],
            // 's_beneficiary_id' => ['nullable', new ValidModel('App\Models\Beneficiary_Info'), Rule::notIn([$relation->beneficiary->id])],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        return Tenant::wrapTenant(function() use ($request, $relation){

            $relation->update(

                [
                    'name' => $request->name,
                    // 'code' => $this->getCode(5, now()),
                    'description' => $request->description,
                    // 's_beneficiary_id' => $request->has('s_beneficiary_id') ? $request->s_beneficiary_id : Null,
                    'created_by' => auth()->user()->user_name,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                ]
            );

           return Message::response(true, 'updated', $relation);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $relation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Relation $relation)
    {
        return Tenant::wrapTenant(function() use ($relation){

            $relation->delete();
            return Message::response(true, 'deleted');
        });
    }

    /**
     * get a unique code
     */
    private function getCode(int $length, string $prefix = null) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $length; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $prefix . $randomString; 
    }
}
