<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Models\Beneficiary_Info;
use App\Models\Type;
use App\Rules\ValidModel;
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
    public function store(Request $request, bool $fastSignup = false)
    {
        $validator = \Validator::make($request->all(), [
            //no restrictions
            'first_name' => ['required'],
            // 'first_name_en' => ['required'],
            'second_name' => ['required'],
            // 'second_name_en' => ['required'],
            'third_name' => ['required'],
            // 'third_name_en' => ['required'],
            'fourth_name' => ['required'],
            // 'fourth_name_en' => ['required'],
            'last_name' => ['required'],
            // 'last_name_en' => ['required'],
            'known_as' => ['required'],
            // 'known_as_en' => ['required'],
            'career' => ['required'],
            // 'career_en' => ['required'],

            //age restriction
            'polling_station_name' => [Rule::requiredIf($request->age >= 18)],
            // 'polling_station_name_en' => [Rule::requiredIf($request->age >= 18)],
            //death restriction
            'standing' => ['required_if:is_alive,0'],
            // 'standing_en' => ['required_if:is_alive,0'],
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

        return Tenant::wrapTenant(function() use ($request, $fastSignup){

            $beneficiaryInfo = Beneficiary_Info::firstOrCreate(

                [
                    'type_infos_id' => $request->type_infos_id,
                ],

                [
                    
                    'first_name'  => $request->first_name,
                        // 'en' => $request->first_name_en,
                    // ],
                    'second_name'  => $request->second_name,
                        // 'en' => $request->second_name_en,
                    // ],
                    'third_name'  => $request->third_name,
                        // 'en' => $request->third_name_en,
                    // ],
                    'fourth_name'  => $request->fourth_name,
                        // 'en' => $request->fourth_name_en,
                    // ],
                    'last_name'  => $request->last_name,
                        // 'en' => $request->last_name_en,
                    // ],
                    'known_as'  => $request->known_as,
                        // 'en' => $request->known_as_en,
                    // ],
                    'career'  => $request->career,
                        // 'en' => $request->career_en,
                    // ],
                    'polling_station_name'  => $request->polling_station_name,
                        // 'en' => $request->polling_station_name_en,
                    // ],
                    'standing'  => $request->standing,
                        // 'en' => $request->standing_en,
                    // ],

                    'date_of_death' => $request->date_of_death,
                    'is_special_needs' => $request->is_special_needs,
                    'birth' => $request->birth,
                    'gender' => $request->gender,
                    'national_number' => $request->national_number,
                    'age' => $request->age,
                    'is_alive' => $request->is_alive,
                    'special_needs_type_id' => $request->special_needs_type_id,

                    "created_by" => auth()->user()->user_name,
                    "is_enabled" => $fastSignup,
                ]
            );

            return $fastSignup ? Message::response(true, 'beneficiary fast assigned successfully', $beneficiaryInfo) :
                Message::response(true, 'created', $beneficiaryInfo);
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
            'first_name' => ['required'],
            // 'first_name_en' => ['required'],
            'second_name' => ['required'],
            // 'second_name_en' => ['required'],
            'third_name' => ['required'],
            // 'third_name_en' => ['required'],
            'fourth_name' => ['required'],
            // 'fourth_name_en' => ['required'],
            'last_name' => ['required'],
            // 'last_name_en' => ['required'],
            'known_as' => ['required'],
            // 'known_as_en' => ['required'],
            'career' => ['required'],
            // 'career_en' => ['required'],

            //age restriction
            'polling_station_name' => [Rule::requiredIf($request->age >= 18)],
            // 'polling_station_name_en' => [Rule::requiredIf($request->age >= 18)],
            //death restriction
            'standing' => ['required_if:is_alive,0'],
            // 'standing_en' => ['required_if:is_alive,0'],
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
                    'first_name' => $request->first_name_ar,
                        // 'en' => $request->first_name_en,
                    // ],
                    'second_name' => $request->second_name_ar,
                        // 'en' => $request->second_name_en,
                    // ],
                    'third_name' => $request->third_name_ar,
                        // 'en' => $request->third_name_en,
                    // ],
                    'fourth_name' => $request->fourth_name_ar,
                        // 'en' => $request->fourth_name_en,
                    // ],
                    'last_name' => $request->last_name_ar,
                        // 'en' => $request->last_name_en,
                    // ],
                    'known_as' => $request->known_as_ar,
                        // 'en' => $request->known_as_en,
                    // ],
                    'career' => $request->career_ar,
                        // 'en' => $request->career_en,
                    // ],
                    'polling_station_name' => $request->polling_station_name_ar,
                        // 'en' => $request->polling_station_name_en,
                    // ],
                    'standing' => $request->standing_ar,
                        // 'en' => $request->standing_en,
                    // ],

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

    /*  ======= ======  =========
        extra functionality
      ======= ======  =========*/

    //create new beneficiary fast => admin
    public function createNewBeneficiaryFast(Request $request, bool $adminRequest = true) {

        $beneficiaryType = Type::where('name', 'beneficiary')->first();

        if(!$beneficiaryType) {return Message::response(true, 'create beneficiary type first!!');}

        return \DB::transaction(function () use ($request, $beneficiaryType, $adminRequest){

            //create new user
            $user = app('App\Http\Controllers\Api\UserController')->signup($request, true);
            if($user instanceof \Illuminate\Http\JsonResponse) return $user;
            //assign the user a beneficiary type
            $type_info = $user->assignType($beneficiaryType);
            //create the user's beneficiary details.
            $res = $this->store($request->merge(['type_infos_id' => $type_info->id]), $adminRequest);

            return $res;
        });
    }

    //1- create new beneficiary fast but his account won't be enabled yet
    public function createNewBeneficiaryNormal(Request $request) {
        
        $this->createNewBeneficiaryFast($request, false);
    }
}
