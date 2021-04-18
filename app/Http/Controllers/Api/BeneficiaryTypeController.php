<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Models\BeneficiaryType;
use Illuminate\Http\Request;

class BeneficiaryTypeController extends Controller
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
                BeneficiaryType::all()
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
            'name'=>['required', 'unique:beneficiary_types,name'],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $beneficiaryType = BeneficiaryType::firstOrcreate(
                [
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'name' => $request->name,
                    'created_by' => auth()->user()->user_name,                     
                ]
            );

            return Message::response(true, 'created', $beneficiaryType);          
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Api\Models\BeneficiaryType  $beneficiaryType
     * @return \Illuminate\Http\Response
     */
    public function show(BeneficiaryType $beneficiaryType)
    {
        return Tenant::wrapTenant(function() use ($beneficiaryType){

            return Message::response(true, 'done', $beneficiaryType);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Api\Models\BeneficiaryType  $beneficiaryType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BeneficiaryType $beneficiaryType)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>['required', 'unique:beneficiary_types,name,' . $beneficiaryType->id],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($beneficiaryType, $request){

            $beneficiaryType->update(
                [
                    'name' => $request->name,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', BeneficiaryType::findOrFail($beneficiaryType->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Api\Models\BeneficiaryType  $beneficiaryType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BeneficiaryType $beneficiaryType)
    {
        return Tenant::wrapTenant(function() use ($beneficiaryType){

            $beneficiaryType->delete();
            return Message::response(true, 'deleted');
        });
    }
}
