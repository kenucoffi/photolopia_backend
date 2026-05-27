<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Photographer;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        //
        $user = new User();
        $user->name = $request->first_name ." ".$request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->user_type = $request->user_type;
        $user->save();
        if ($user->user_type == "photographer"){
            $photographer = new Photographer();
            $photographer->user_id = $user->id;
            $photographer->save();
        }
        else if($user->user_type = "client"){
            $client = new Client();
            $client->user_id = $user->id;
            $client->save();
        }
        return response()->json(["message"=>"created successfuly"],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $client = new Client();
        $client = $client->findOrFail($id);
        $list = [$client ,"user"=>$client->user];
        return response()->json($list,200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $client = Client::findOrFail($id);
        $client->phone = $request->phone;
        $client->location = $request->location;
        $client->save();
        return response()->json($client,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
