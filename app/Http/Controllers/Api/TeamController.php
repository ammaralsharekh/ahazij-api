<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TeamCollection
     */
    public function index()
    {
        return new TeamCollection(Team::all());
    }

    /**
     * Display a user team.
     *
     * @return TeamResource
     */
    public function my_team(Request $request)
    {
        return new TeamResource(User::query()
            ->select("users.id as user_id,teams.id as id ,teams.name as name")
            ->where("id", $request['user_id'])->with("team")->first());
    }

    public function register_to_team(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|numeric|exists:teams,id',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user=User::find( $request['user_id']);
        if($user->team_id !=null)
        {
            $response = ['message' => 'team registered'];
            return response(['errors'=>["you already have team"]], 422);
        }
        $user->team_id=$request['team_id'];
        $user->save();

        $response = ['message' => 'team registered'];
        return response($response, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


}
