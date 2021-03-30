<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\{Tenant, Message};
use Illuminate\Http\Request;
use App\Models\Sentence;
use App\Rules\ValidModel;

class SentenceController extends Controller
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
                Sentence::paginate(25)
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
            'body'=>['required', 'unique:sentences,body'],
            'language_id'=>['required', new ValidModel('App\Models\Language')],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }

        return Tenant::wrapTenant(function() use ($request){

            return \DB::transaction(function () use ($request){

                $sentence = Sentence::firstOrcreate(
                    [
                        'body' => $request->body,
                    ],
                    [
                        #if is_enabled is null then it's false
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                        'created_by' => auth()->user()->user_name,                     
                    ]
                );

                $sentence->languages()->attach($request->language_id);

                return Message::response(true, 'created', $sentence);
            });
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sentence  $sentence
     * @return \Illuminate\Http\Response
     */
    public function show(Sentence $sentence)
    {
        return Tenant::wrapTenant(function() use ($sentence){

            return Message::response('true', 'done', $sentence);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sentence  $sentence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sentence $sentence)
    {
        $validator = \Validator::make($request->all(), [
            'body'=>['required', 'unique:sentences,body,' . $sentence->id],
            'language_id'=>['required', new ValidModel('App\Models\Language')],
            'is_enabled' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return Message::response(false,'Invalid Input' ,$validator->errors());  
        }
        
        return Tenant::wrapTenant(function() use ($sentence, $request){

            return \DB::transaction(function () use ($request, $sentence){

                $sentence->update(
                    [
                        'body' => $request->body,
                        'is_enabled' => $request->has('is_enabled') ? $request->is_enabled : 1,
                        'modified_by' => auth()->user()->user_name,
                    ]
                );

                $sentence->languages()->sync($request->language_id);

                return Message::response(true, 'updated', Sentence::findOrFail($sentence->id));
            });
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sentence  $sentence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sentence $sentence)
    {
        return Tenant::wrapTenant(function() use ($sentence){

            $sentence->delete();
            return Message::response(true, 'deleted');
        });
    }
}
