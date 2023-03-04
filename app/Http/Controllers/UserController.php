<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|unique:users|max:255|email|string',
            'password' => 'required|max:255|string'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->created_at = now();
        $user->updated_at = now();

        $user->save();

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(is_null($user)) {
            return response()->json('User not exist', 404);
        }
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'unique:users|max:255|email|string',
            'password' => 'required|max:255|string'
        ]);

        $user = User::find($id);
        if(is_null($user)) {
            return response()->json('User not exist', 404);
        }
        
        $user->name = $request->name;
        $user->email = $request->email ?? $user->email;
        $user->password = $request->password;
        $user->updated_at = now();

        $user->update();

        return $user;    
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(is_null($user)) {
            return response()->json('User not exist', 404);
        }

        $user->delete();
        return response()->noContent();
    }
    /**
     * Display top 3 domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function topDomain(){

        $users = DB::table('users')
                ->select(DB::raw('count(*) as domain_count, SUBSTRING_INDEX(email, "@", -1) as domain'))
                ->groupBy('domain')
                ->orderByDesc('domain_count')
                ->limit(3)
                ->get();
                
        return $users;
    }
}
