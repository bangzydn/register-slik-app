<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use illuminate\routing\Controllers\HasMiddleware;
use illuminate\routing\Controllers\Middleware;

class PermissionController extends Controller //implements HasMiddleware
{
    // public static function middleware():array 
    //     {
    //      return [ 
    //         new Middleware('permission:View Permissions', only:['index']), 
    //         new Middleware('permission:Delete Permissions', only:['destroy']), 
    //         new Middleware('permission:Create Permissions', only:['store']), 
    //         new Middleware('permission:Edit Permissions', only:['update']), 
    //         ];
    //     }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(4);
        return view('permissions.index')->with([
            'permissions' => $permissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permissions = [
            'name' => $request->input('name')
        ];
        Permission::create($permissions);
        return back()->with('message_insert', 'Data Sudah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) 
    {
        $permissions = [
            'name' => $request->input('name')
        ];
        $permission = Permission::findOrFail($id);
        $permission->update($permissions);
        return back()->with('message_insert', 'Data Sudah ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
