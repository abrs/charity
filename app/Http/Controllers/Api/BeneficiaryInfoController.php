<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Models\Activity;
use App\Models\ActivityBeneficiary;
use App\Models\Beneficiary_Info;
use App\Models\BeneficiaryRelation;
use App\Models\Relation;
use App\Models\RequestType;
use App\Models\StepApproval;
use App\Models\Type;
use App\Models\Type_Info;
use App\Rules\BreadwinnerFamilyBudget;
use App\Rules\ValidModel;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BeneficiaryInfoController extends Controller
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
                Beneficiary_Info::paginate(25)
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
            //no restrictions
            'first_name_ar' => ['required'],
            'first_name_en' => ['required'],
            'second_name_ar' => ['required'],
            'second_name_en' => ['required'],
            'third_name_ar' => ['required'],
            'third_name_en' => ['required'],
            'fourth_name_ar' => ['required'],
            'fourth_name_en' => ['required'],
            'last_name_ar' => ['required'],
            'last_name_en' => ['required'],
            'known_as_ar' => ['required'],
            'known_as_en' => ['required'],
            'career_ar' => ['required'],
            'career_en' => ['required'],

            //age restriction
            'polling_station_name_ar' => [Rule::requiredIf($request->age >= 18)],
            'polling_station_name_en' => [Rule::requiredIf($request->age >= 18)],
            //death restriction
            'standing_ar' => ['required_if:is_alive,0'],
            'standing_en' => ['required_if:is_alive,0'],
                //date restriction
            'date_of_death' => ['date_format:YYYY-MM-DD', 'required_if:is_alive,0'],
            //boolean restriction
            'is_special_needs' => ['required', 'boolean'],
            //date restriction
            'birth' => ['date_format:YYYY-MM-DD'],
            //boolean restriction
            'gender' => ['required'],
            //number restriction
            'national_number' => ['required', 'numeric'],
            //number unsigned max(3) min(1) restriction
            'age' => ['required', 'numeric', 'min:1', 'max:200'],
            //email restriction and unique
            'email' => ['required', 'email'],
            //boolean restriction
            'is_alive' => ['required', 'boolean'],
            //special needs restriction
            'special_needs_type_id' => ['required_if:is_special_needs,1'],

            'type_infos_id'=>['required', 'unique:beneficiary_infos,type_infos_id', new ValidModel('App\Models\Type_Info')],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $beneficiaryInfo = Beneficiary_Info::firstOrCreate(

                [
                    'type_infos_id' => $request->type_infos_id,
                ],

                [
                    
                    'first_name'  => [
                        'ar' => $request->first_name_ar,
                        'en' => $request->first_name_en,
                    ],
                    'second_name'  => [
                        'ar' => $request->second_name_ar,
                        'en' => $request->second_name_en,
                    ],
                    'third_name'  => [
                        'ar' => $request->third_name_ar,
                        'en' => $request->third_name_en,
                    ],
                    'fourth_name'  => [
                        'ar' => $request->fourth_name_ar,
                        'en' => $request->fourth_name_en,
                    ],
                    'last_name'  => [
                        'ar' => $request->last_name_ar,
                        'en' => $request->last_name_en,
                    ],
                    'known_as'  => [
                        'ar' => $request->known_as_ar,
                        'en' => $request->known_as_en,
                    ],
                    'career'  => [
                        'ar' => $request->career_ar,
                        'en' => $request->career_en,
                    ],
                    'polling_station_name'  => [
                        'ar' => $request->polling_station_name_ar,
                        'en' => $request->polling_station_name_en,
                    ],
                    'standing'  => [
                        'ar' => $request->standing_ar,
                        'en' => $request->standing_en,
                    ],

                    'date_of_death' => $request->date_of_death,
                    'is_special_needs' => $request->is_special_needs,
                    'birth' => $request->birth,
                    'gender' => $request->gender,
                    'national_number' => $request->national_number,
                    'age' => $request->age,
                    'email' => $request->email,
                    'is_alive' => $request->is_alive,
                    'special_needs_type_id' => $request->special_needs_type_id,

                    "created_by" => auth()->user()->user_name,
                    "is_enabled" => $request->has('is_enabled') ? $request->is_enabled : 1,
                ]
            );

           return Message::response(true, 'created', $beneficiaryInfo);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary_Info  $beneficiary_info
     * @return \Illuminate\Http\Response
     */
    public function show(Beneficiary_Info $beneficiary_info)
    {
        return Tenant::wrapTenant(function() use ($beneficiary_info){

            return Message::response('true', 'done', $beneficiary_info);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beneficiary_Info  $beneficiary_info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beneficiary_Info $beneficiary_info)
    {
        $validator = \Validator::make($request->all(), [
            'first_name_ar' => ['required'],
            'first_name_en' => ['required'],
            'second_name_ar' => ['required'],
            'second_name_en' => ['required'],
            'third_name_ar' => ['required'],
            'third_name_en' => ['required'],
            'fourth_name_ar' => ['required'],
            'fourth_name_en' => ['required'],
            'last_name_ar' => ['required'],
            'last_name_en' => ['required'],
            'known_as_ar' => ['required'],
            'known_as_en' => ['required'],
            'career_ar' => ['required'],
            'career_en' => ['required'],

            //age restriction
            'polling_station_name_ar' => [Rule::requiredIf($request->age >= 18)],
            'polling_station_name_en' => [Rule::requiredIf($request->age >= 18)],
            //death restriction
            'standing_ar' => ['required_if:is_alive,0'],
            'standing_en' => ['required_if:is_alive,0'],
                //date restriction
            'date_of_death' => ['date_format:YYYY-MM-DD', 'required_if:is_alive,0'],
            //boolean restriction
            'is_special_needs' => ['required', 'boolean'],
            //date restriction
            'birth' => ['date_format:YYYY-MM-DD'],
            //boolean restriction
            'gender' => ['required'],
            //number restriction
            'national_number' => ['required', 'numeric'],
            //number unsigned max(3) min(1) restriction
            'age' => ['required', 'numeric', 'min:1', 'max:200'],
            //email restriction and unique
            'email' => ['required', 'email'],
            //boolean restriction
            'is_alive' => ['required', 'boolean'],
            //special needs restriction
            'special_needs_type_id' => ['required_if:is_special_needs,1'],

            'type_infos_id'=>['required', 'unique:beneficiary_infos,type_infos_id,' . $beneficiary_info->id, new ValidModel('App\Models\Type_Info')],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $beneficiary_info){

            $beneficiary_info->update(

                [
                    'type_infos_id' => $request->type_infos_id,
                    // 'location_id' => $request->location_id,
                    'first_name'  => [
                        'ar' => $request->first_name_ar,
                        'en' => $request->first_name_en,
                    ],
                    'second_name'  => [
                        'ar' => $request->second_name_ar,
                        'en' => $request->second_name_en,
                    ],
                    'third_name'  => [
                        'ar' => $request->third_name_ar,
                        'en' => $request->third_name_en,
                    ],
                    'fourth_name'  => [
                        'ar' => $request->fourth_name_ar,
                        'en' => $request->fourth_name_en,
                    ],
                    'last_name'  => [
                        'ar' => $request->last_name_ar,
                        'en' => $request->last_name_en,
                    ],
                    'known_as'  => [
                        'ar' => $request->known_as_ar,
                        'en' => $request->known_as_en,
                    ],
                    'career'  => [
                        'ar' => $request->career_ar,
                        'en' => $request->career_en,
                    ],
                    'polling_station_name'  => [
                        'ar' => $request->polling_station_name_ar,
                        'en' => $request->polling_station_name_en,
                    ],
                    'standing'  => [
                        'ar' => $request->standing_ar,
                        'en' => $request->standing_en,
                    ],

                    "updated_by" => auth()->user()->user_name,
                    "is_enabled" => $request->has('is_enabled') ? $request->is_enabled : 1,
                ]
            );

           return Message::response(true, 'updated', Beneficiary_Info::findOrFail($beneficiary_info->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary_Info  $beneficiary_info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficiary_Info $beneficiary_info)
    {
        return Tenant::wrapTenant(function() use ($beneficiary_info){

            $beneficiary_info->delete();
            return Message::response(true, 'deleted');
        });
    }

    /**
     * ===============================================================
     * ===================== extra functionality =====================
     * ==================================================
     */

    /**
     * add new beneficiary memeber
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function createNewBeneficiaryDetails(Request $request) {
        
        $validator = \Validator::make($request->all(), [

            #get the owner
            'owner_id' => ['required', 'numeric', new ValidModel('App\User')],

            #create beneficiary
            // 'location_id'=>['required', new ValidModel('App\Models\Location')],

            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        #create a password for the user
        return Tenant::wrapTenant(function() use ($request){

            return \DB::transaction(function () use ($request){

                #1- create user
                $created_user = User::find($request->owner_id);

                #get the type of a beneficiary
                #type beneficiary needs to be exist
                $type = Type::findOrFail(Type::where('name', 'beneficiary')->first('id')->id);
                $typeInfo = $created_user->assignType($type);

                #create a beneficiary details
                Beneficiary_Info::firstOrCreate(

                    ['type_infos_id' => $typeInfo->id],
                    [
                        // 'location_id' => $request->location_id,
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                        'created_by' => auth()->user()->user_name,
                    ]
                );

                return Message::response(true, 'created', User::find($request->owner_id));

            });
        });
    }

    /**
     * assign beneficiary a phone
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function assignBeneficiaryPhone(Request $request) {

        $validator = \Validator::make($request->all(), [
            'is_enabled'        => ['nullable', 'boolean'],

            'user_id'    => ['required', new ValidModel('App\Models\Beneficiary_Info')],
            'phone_type_id'  => ['required', new ValidModel('App\Models\PhoneType')],
            'number'       => ['required', 'unique:phones,number'],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){
                    
            \DB::table('phones')->insert(
                [
                    'user_id' => $request->user_id,
                    'phone_type_id' => $request->phone_type_id,
                    'number' => $request->number,
                
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,

                    'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                ]
            );

            $phone = \DB::table('phones')->where('number', $request->number)->first();
            
            return Message::response(true, 'attached successfully', $phone);
        });
    }

    /**
     * assign beneficiary a location
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function assignBeneficiaryLocation(Request $request) {

        $validator = \Validator::make($request->all(), [
            'is_enabled'        => ['nullable', 'boolean'],

            'beneficiary_id'    => ['required', new ValidModel('App\Models\Beneficiary_Info')],
            'location_type_id'  => ['required', new ValidModel('App\Models\LocationType')],
            'location_id'       => ['required', new ValidModel('App\Models\Location')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $beneficiaryLocation = \DB::table('beneficiary_location')
                ->where('beneficiary_id', $request->beneficiary_id)
                ->where('location_type_id', $request->location_type_id)
                ->where('location_id', $request->location_id)
                ->first();

            if(!$beneficiaryLocation) {

                \DB::table('beneficiary_location')->insert(
                    [
                        'beneficiary_id' => $request->beneficiary_id,
                        'location_type_id' => $request->location_type_id,
                        'location_id' => $request->location_id,
                    
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                        'created_by' => auth()->user()->user_name,

                        'created_at' => date("Y-m-d H:i:s", strtotime(now())),
                    ]
                );
                
                $beneficiaryLocation = \DB::table('beneficiary_location')
                ->where('beneficiary_id', $request->beneficiary_id)
                ->where('location_type_id', $request->location_type_id)
                ->where('location_id', $request->location_id)
                ->first();
            }


           return Message::response(true, 'attached successfully', $beneficiaryLocation);
        });
    }


    /**
     * assign beneficiary a relation
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function assignBeneficiaryRelation(Request $request) {

        $validator = \Validator::make($request->all(), [
            'is_enabled'        => ['nullable', 'boolean'],

            'beneficiary_id'    => ['required', new ValidModel('App\Models\Beneficiary_Info')],
            's_beneficiary_id'  => ['nullable', new ValidModel('App\Models\Beneficiary_Info'), Rule::notIn($request->beneficiary_id)],
            'relation_id'       => ['required', new ValidModel('App\Models\Relation')],
            'family_budget'     => ['required_if:relation_id,' . Relation::where('name->en', "Breadwinner")->first()->id],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            BeneficiaryRelation::firstOrCreate(
                [
                    'beneficiary_id' => $request->beneficiary_id,
                    'relation_id' => $request->relation_id,
                    's_beneficiary_id' => $request->s_beneficiary_id,
                ],
                [
                    'family_budget' => $request->has('family_budget') ? $request->family_budget : NULL,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'created_by' => auth()->user()->user_name,
                ]
            );

           return Message::response(true, 'attached successfully');
        });
    }

    /**
     * unassign beneficiary a relation
     * @param \Illuminate\Http\Request $request
     * @return \App\Helpers\Message
     */
    public function unAssignBeneficiaryRelation(Request $request) {

        $validator = \Validator::make($request->all(), [

            'beneficiary_id' => ['required', new ValidModel('App\Models\Beneficiary_Info')],
            'relation_id'    => ['required', new ValidModel('App\Models\Relation')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){
            
            $beneficiary = Beneficiary_Info::find($request->beneficiary_id);

            $beneficiary->relations()->detach($request->relation_id);

           return Message::response(true, 'unattached successfully');
        });
    }
}
