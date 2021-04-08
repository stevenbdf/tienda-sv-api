<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AddressResource::collection(auth()->user()->addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $id = auth()->user()->id;
        $addreses = Address::where('user_id', $id)->get();
        if ($addreses->count() < 3) {
            Address::insertGetId([
                'user_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
                'address' => $request['address'],
                'municipality' => $request['municipality']
            ]);
            return AddressResource::collection(auth()->user()->addresses);
        } else {
            return response('muchas direcciones');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        if (auth()->user()->id == $address->user_id) {
            return new AddressResource($address);
        }
        return response('no maitro', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, Address $address)
    {
        $address->update($request->all());
        $address->refresh();
        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if (Address::where('user_id', auth()->user()->id)->get()->count() > 1) {
            Address::where('id', $address['id'])->delete();
            return AddressResource::collection(auth()->user()->addresses);
        } else {
            return response('No es posible eliminar todas las direcciones');
        }
    }
}
