<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\DataTableController;
use App\Http\Resources\UsersCollection;
use App\User;
use Illuminate\Http\Request;

class UsersController extends DataTableController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UsersCollection(User::query());
    }


    public function getDisplayableColumns()
    {
        return [
            'id','name','email','created_at',
        ];
    }
    public function getUpdatableColumns()
    {
        return [
           'name','email','created_at',
        ];
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
            'name' =>'required',
            'email' =>'required|email|unique:users,email',
        ]);
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }


}
