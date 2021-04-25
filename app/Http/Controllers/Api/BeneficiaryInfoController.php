<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use App\Exceptions\JsonExceptionHandler;
use App\Models\Activitable;
use App\Models\Activity;
use App\Models\Beneficiary_Info;
use App\Models\BeneficiaryType;
use App\Models\Type;
use App\Rules\ValidModel;
use BadMethodCallException;
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
                Beneficiary_Info::where('is_enabled', 1)->paginate(25)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, bool $adminRequest = false, bool $beneficiaryRelatedToRelation = false)
    {
        // die(var_dump($request->phone));
        $validator = \Validator::make($request->all(), [

            
            //no restrictions
            'first_name' => ['required'],
            
            #phone required unique for certain beneficiaryinfo
            'phone' => ['required_if:gender,1', 'digits:11', 'unique:beneficiary_infos,phone'],
            
            'second_name' => ['required'],
            
            'third_name' => ['required'],
            
            'fourth_name' => ['required'],
            
            'last_name' => ['required'],
            
            'known_as' => ['required'],
            
            'career_id' => ['required', new ValidModel('App\Models\Career')],
            

            //age restriction
            'polling_station_id' => [Rule::requiredIf($request->age >= 18), new ValidModel('App\Models\PollingStation')],
            // 'polling_station_name_en' => [Rule::requiredIf($request->age >= 18)],
            //death restriction
            'standing' => ['required_if:is_alive,0'],
            // 'standing_en' => ['required_if:is_alive,0'],
                //date restriction
            'date_of_death' => ['date', 'required_if:is_alive,0'],
            //boolean restriction
            'is_special_needs' => ['required', 'boolean'],
            //date restriction
            'birth' => ['date'],
            //boolean restriction
            'gender' => ['required'],
            //number restriction
            'national_number' => ['required', 'numeric'],
            //number unsigned max(3) min(1) restriction
            'age' => ['required', 'numeric', 'min:1', 'max:125'],            
            //boolean restriction
            'is_alive' => ['required', 'boolean'],
            //special needs restriction
            // 'special_needs_type_id' => ['required_if:is_special_needs,1'],

            //this type_infos_id is important whenever you need to link between user, type and beneficiary
            'type_infos_id'=>['nullable', new ValidModel('App\Models\Type_Info')],
            'is_enabled' => 'nullable|boolean',

            'special_need_types' => ['required_if:is_special_needs,1', 'array'],
            'special_need_types.*' => ['numeric', new ValidModel('App\Models\SpecialNeedType')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $adminRequest, $beneficiaryRelatedToRelation){

            // $beneficiaryInfo = Beneficiary_Info::where('type_infos_id', $request->type_infos_id)->first();

            // if(!$beneficiaryInfo) {

            return \DB::transaction(function () use ($request, $adminRequest, $beneficiaryRelatedToRelation){
                    
                $beneficiaryInfo = Beneficiary_Info::firstorcreate(
                    
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
                    ],

                    [

                        'phone' => $request->phone,

                        'type_infos_id' => $request->type_infos_id,
                        
                        // 'en' => $request->fourth_name_en,
                        // ],
                        'last_name'  => $request->last_name,
                        // 'en' => $request->last_name_en,
                        // ],
                        'known_as'  => $request->known_as,
                            // 'en' => $request->known_as_en,
                            // ],
                        'career_id'  => $request->career_id,
                            // 'en' => $request->career_en,
                        // ],
                        'polling_station_id'  => $request->polling_station_id,
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
                        // 'special_needs_type_id' => $request->special_needs_type_id,

                        "created_by" => auth()->user()->user_name,
                        // "is_enabled" => $adminRequest,
                        'is_enabled' => 1,
                    ]
                );

                //required_if:is_special_needs,1 => attach his/her special needs types
                if($request->has('special_need_types')) {
                    //add special needs type if it a special needs case
                    $beneficiaryInfo->special_needs()->attach($request->special_need_types, [

                        "created_by" => auth()->user()->user_name
                    ]);
                }

                // die('beneficiaryRelatedToRelation: ' . $beneficiaryRelatedToRelation);
                
                if($beneficiaryRelatedToRelation) {
                    #if for relation then it is disabled
                    $beneficiaryInfo->is_enabled = 0;
                    $beneficiaryInfo->save();

                    // die('you are assigning relation to a beneficiary');
                    return $beneficiaryInfo;
                }

                return $adminRequest ? Message::response(true, 'beneficiary fast assigned successfully', $beneficiaryInfo) :
                $beneficiaryInfo;
                
            });
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

            return Message::response(true, 'done', $beneficiary_info);
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

            'phone' => ['required', 'digits:11', 'unique:beneficiary_infos,phone,' . $beneficiary_info->id],

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
            'career_id' => ['required', new ValidModel('App\Models\Career')],

            // 'career_en' => ['required'],

            //age restriction
            'polling_station_id' => [Rule::requiredIf($request->age >= 18), new ValidModel('App\Models\PollingStation')],

            // 'polling_station_name_en' => [Rule::requiredIf($request->age >= 18)],
            //death restriction
            'standing' => ['required_if:is_alive,0'],
            // 'standing_en' => ['required_if:is_alive,0'],
                //date restriction
            'date_of_death' => ['date', 'required_if:is_alive,0'],
            //boolean restriction
            'is_special_needs' => ['required', 'boolean'],
            //date restriction
            'birth' => ['date'],
            //boolean restriction
            'gender' => ['required'],
            //number restriction
            'national_number' => ['required', 'numeric'],
            //number unsigned max(3) min(1) restriction
            'age' => ['required', 'numeric', 'min:1', 'max:200'],
            //email restriction and unique
            // 'email' => ['required', 'email'],
            //boolean restriction
            'is_alive' => ['required', 'boolean'],
            //special needs restriction
            'special_need_types' => ['required_if:is_special_needs,1', 'array'],
            'special_need_types.*' => ['numeric', new ValidModel('App\Models\SpecialNeedType')],

            // 'type_infos_id'=>['required', 'unique:beneficiary_infos,type_infos_id,' . $beneficiary_info->id, new ValidModel('App\Models\Type_Info')],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request, $beneficiary_info){

            return \DB::transaction(function ($request, $beneficiary_info) {
                
                $beneficiary_info->update(
                    
                    [
                        // 'type_infos_id' => $request->type_infos_id,
                        // 'location_id' => $request->location_id,
                        'first_name' => $request->first_name,
                        // 'en' => $request->first_name_en,
                        // ],
                        'second_name' => $request->second_name,
                            // 'en' => $request->second_name_en,
                            // ],
                        'third_name' => $request->third_name,
                        // 'en' => $request->third_name_en,
                        // ],
                        'fourth_name' => $request->fourth_name,
                        // 'en' => $request->fourth_name_en,
                        // ],
                        'last_name' => $request->last_name,
                        // 'en' => $request->last_name_en,
                        // ],
                        'known_as' => $request->known_as,
                        // 'en' => $request->known_as_en,
                        // ],
                        'career_id' => $request->career_id,
                        // 'en' => $request->career_en,
                        // ],
                        'polling_station_id' => $request->polling_station_id,
                            // 'en' => $request->polling_station_name_en,
                            // ],
                        'standing' => $request->standing,
                        // 'en' => $request->standing_en,
                        // ],
                        'date_of_death' => $request->date_of_death,
                        'is_special_needs' => $request->is_special_needs,
                        'birth' => $request->birth,
                        'gender' => $request->gender,
                        'national_number' => $request->national_number,
                        'age' => $request->age,
                        'is_alive' => $request->is_alive,
                        
                        "modified_by" => auth()->user()->user_name,
                        "is_enabled" => $request->has('is_enabled') ? $request->is_enabled : $beneficiary_info->is_enabled,
                    ]
                );
                
                //required_if:is_special_needs,1 => attach his/her special needs types
                if($request->has('special_need_types')) {
                    //add special needs type if it a special needs case
                    $beneficiary_info->special_needs()->sync($request->special_need_types, [

                        "modified_by" => auth()->user()->user_name
                    ]);
                }
            
                return Message::response(true, 'updated', Beneficiary_Info::findOrFail($beneficiary_info->id));
            });
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

        $beneficiaryUserType = Type::where('name', 'beneficiary')->first();

        if(!$beneficiaryUserType) {return Message::response(true, 'create the beneficiary type first!!');}

        return \DB::transaction(function () use ($request, $beneficiaryUserType, $adminRequest){

            if($adminRequest) {
                //create new user using admin privilige
                $user = app('App\Http\Controllers\Api\UserController')->signup($request, true);
                if($user instanceof \Illuminate\Http\JsonResponse) throw new JsonExceptionHandler($user);

                /*TODO: send notification to the newely created beneficiary tells him
                    to add locations relations and phones.
                */
            }else {                
                //not an admin => a beneficiary is inserting his data
                $user = \Auth::user();
            }
            //assign the user a beneficiary type
            $type_info = $user->assignType($beneficiaryUserType);
            //create the user's beneficiary details.
            $beneficiaryInfo = $this->store($request->merge(['type_infos_id' => $type_info->id]), $adminRequest);
            if($beneficiaryInfo instanceof \Illuminate\Http\JsonResponse) throw new JsonExceptionHandler($beneficiaryInfo);

            #the inserted beneficiary type according to who added him/her.
            \DB::table('beneficiary_types')
                ->when($adminRequest, function ($query) use ($beneficiaryInfo){
                    //assign the new fast created beneficiary type of "accepted" if an admin who added it
                    $acceptedBeneficiaryType = $query->where('name', 'accepted')->first();
                    if(!$acceptedBeneficiaryType) {return Message::response(true, 'create the beneficiary type \"accepted\" first!!');}

                    $beneficiaryInfo->beneficiary_type()->associate($acceptedBeneficiaryType->id);                    
                    $beneficiaryInfo->save();

                }, function ($query) use ($beneficiaryInfo){
                    #else assign the beneficiary type "pending registered" if it's him who inserting the data.
                    $PendedBeneficiaryType = $query->where('name', 'pending registered')->first();
                    if(!$PendedBeneficiaryType) {return Message::response(true, 'create the beneficiary type \"pending registered\" first!!');}

                    $beneficiaryInfo->beneficiary_type()->associate($PendedBeneficiaryType->id);
                    $beneficiaryInfo->save();
                });


            return $beneficiaryInfo;
        });
    }

    //1- create new beneficiary fast but his account won't be enabled yet
    public function createNewBeneficiaryNormal(Request $request) {

        $addNewBeneficiaryActivity = Activity::where('name', 'add_new_beneficiary')->first();
        if(!$addNewBeneficiaryActivity) {return Message::response(true, 'create the activity \"add_new_beneficiary\" first!!');}                


        return \DB::transaction(function () use ($request, $addNewBeneficiaryActivity){

            #1- create new beneficiary
            $beneficiaryInfo = $this->createNewBeneficiaryFast($request, false);            
            if($beneficiaryInfo instanceof \Illuminate\Http\JsonResponse) throw new JsonExceptionHandler($beneficiaryInfo);

            #2- link a new normal insertion between a beneficiary and his activity of becoming beneficiary
            $activity = Activity::findOrFail($addNewBeneficiaryActivity->id);

            $activitable = new Activitable();
            $activitable->fill([

                'activitable_id' => $beneficiaryInfo->id,
                'activitable_type' => Beneficiary_Info::class
            ]);

            $activitable = $activity->activitables()->save($activitable);

            //add the steps related to adding new benefciary request automatically
            #1- assign the step a needs custodian approval activity step            
            $newStep = app('App\Http\Controllers\Api\ActivityWorkflowStepController')->store($request->merge([
                'activitable_id' => $activitable->id,
                'step_id' => 6,
                'step_supervisor_id' => 3,
                'order_num' => 1,
                'finishing_percentage' => 50,
                'required' => 1,
                'status_id' => 1,
                'description' => 'needs custodian approval',
            ]), true);

            if($newStep instanceof \Illuminate\Http\JsonResponse) throw new JsonExceptionHandler($newStep);


            #2- assign the step a needs manager approval activity step
            $newStep = app('App\Http\Controllers\Api\ActivityWorkflowStepController')->store($request->merge([
                'activitable_id' => $activitable->id,
                'step_id' => 7,
                'step_supervisor_id' => 2,
                'order_num' => 2,
                'finishing_percentage' => 50,
                'required' => 1,
                'status_id' => 1,
                'description' => 'needs manager approval',
            ]), true);

            if($newStep instanceof \Illuminate\Http\JsonResponse) throw new JsonExceptionHandler($newStep);


            return Message::response(true, 'beneficiary request created and is waiting for processing..');
        });
    }

    /**=========    ==========  ==========  =======
     *  change the beneficiary acceptance type
     ====   ==========  ==========*/
     public function changeAcceptanceType(Request $request) {

        $validator = \Validator::make($request->all(), [

            'beneficiary_id' => ['required', new ValidModel('App\Models\Beneficiary_Info')],
            'beneficiary_type_id' => ['required', new ValidModel('App\Models\BeneficiaryType')],
        ]);

        if($validator->fails()){

            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        $beneficiaryInfo = Beneficiary_Info::find($request->beneficiary_id);

        $beneficiaryInfo->beneficiary_type()->associate($request->beneficiary_type_id);
        $beneficiaryInfo->save();

        return Message::response(true, 'done');
     }
}
