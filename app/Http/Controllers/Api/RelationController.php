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
                Relation::all()
                // Relation::paginate(25)
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
            // 'name_en'=>['required', 'unique:relations,name->en'],
            'name'=>['required', 'unique:relations,name'],
            // 'description_en'=>['nullable'],
            'description'=>['nullable'],            
            // 's_beneficiary_id' => ['nullable', new ValidModel('App\Models\Beneficiary_Info')],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());
        }

        $relation = Relation::checkOrCreate(
            [
                'name' => $request->name,
            ],

            [
                //     'en' => $request->name_en,
                // ],

                'description' => $request->has('description') ? $request->description : Null,
                //     'en' => $request->has('description_en') ? $request->description_en : Null,
                // ],
                'code' => $this->getCode(5, now()),
                // 's_beneficiary_id' => $request->has('s_beneficiary_id') ? $request->s_beneficiary_id : Null,
                
                'created_by' => auth()->user()->user_name,
                'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
            ]
        );
        return Message::response(true, 'created', $relation);
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
            // 'name_en'=>['required', 'unique:relations,name->en,' . $relation->id],
            'name'=>['required', 'unique:relations,name,' . $relation->id],
            // 'description_en'=>['nullable'],
            'description'=>['nullable'],

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
                    //     'en' => $request->name_en,
                    // ],

                    'description' => $request->has('description') ? $request->description : $relation->description,
                    //     'en' => $request->has('description_en') ? $request->description_en : $relation->description_en,
                    // ],
                    // 's_beneficiary_id' => $request->has('s_beneficiary_id') ? $request->s_beneficiary_id : Null,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'modified_by' => auth()->user()->user_name,
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
