<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BasicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('basic.list', [
            'title' => 'Basic CRUD',
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basic.create', [
            'title' => 'New User',
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'domisili' => $request->domisili,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('basic.index')->with('message', 'User added successfully!');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $basic)
    {
        return view('basic.edit', [
            'title' => 'Edit User',
            'user' => $basic
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, User $basic)
    {
        if($request->filled('password')) {
            $basic->password = Hash::make($request->password);
        }
        $basic->name = $request->name;
        $basic->no_telepon = $request->no_telepon;
        $basic->jenis_kelamin = $request->jenis_kelamin;
        $basic->email = $request->email;
        $basic->save();

        return redirect()->route('basic.index')->with('message', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $basic)
    {
        if (Auth::id() == $basic->getKey()) {
            return redirect()->route('basic.index')->with('warning', 'Can not delete yourself!');
        }

        $basic->delete();

        return redirect()->route('basic.index')->with('message', 'User deleted successfully!');
    }
}
