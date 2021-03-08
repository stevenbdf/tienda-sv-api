<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$id = auth()->user()->id;
        $user = User::select('id','name','email','phone')->get();
        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!User::where('email',$request['email'])->first()){
            if(!User::where('phone',$request['phone'])->first()){
                $user_id = User::insertGetId(['name'=>$request['name'],'email'=>$request['email'],'email_verified_at'=>now(),'phone'=>$request['phone'],'password'=>Hash::make($request['password']),'remember_token'=>Str::random(10),'created_at'=>now(),'updated_at'=>now()]);
                return $user_id;
            }else{
                return response('ya hay un telefono registrado');
            }
        }else{
            return response('Ya hay un correo registrado');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $id = auth()->user()->id;
        $user = User::select('id','name','email','phone')->where('id', $id)->get();
        return UserResource::collection($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $id = auth()->user()->id;
        $exists_email=User::where('email',$request['email'])->first();
        $exists_phone=User::where('phone',$request['phone'])->first();
        if(!$exists_email || $exists_email->id == $id){
            if(!$exists_phone || $exists_phone->id == $id){
                if($user->id == $id){
                    User::where('id',$id)->update(['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'updated_at'=>now()]);
                    $user->refresh();
                    return new UserResource($user);
                }
            }else{
                return response('ya hay un telefono registrado');
            }
        }else{
            return response('ya hay un email registrado');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

    }
}
