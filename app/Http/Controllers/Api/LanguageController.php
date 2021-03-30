<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Language;
use App\Rules\ValidModel;

class LanguageController extends Controller
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
                Language::paginate(25)
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
            'title'=>['required', 'unique:languages,title'],
            'abbrivation'=>['required', 'unique:languages,abbrivation'],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            $language = Language::firstOrcreate(
                [
                    'title' => $request->title,
                    'abbrivation' => $request->abbrivation,
                ],
                [
                    #if is_enabled is null then it's false
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,                    
                    'created_by' => auth()->user()->user_name,                     
                ]
            );

            return Message::response(true, 'created', $language);          
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        return Tenant::wrapTenant(function() use ($language){

            return Message::response('true', 'done', $language);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $validator = \Validator::make($request->all(), [
            'title'=>['required', 'unique:languages,title,' . $language->id],
            'abbrivation'=>['required', 'unique:languages,abbrivation,' . $language->id],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($language, $request){

            $language->update(
                [
                    'title' => $request->title,
                    'abbrivation' => $request->abbrivation,
                    'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                    'modified_by' => auth()->user()->user_name,
                ]
            );

            return Message::response(true, 'updated', Language::findOrFail($language->id));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        return Tenant::wrapTenant(function() use ($language){

            $language->delete();
            return Message::response(true, 'deleted');
        });
    }
}
