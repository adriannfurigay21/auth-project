<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\ReadRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\ListRequest;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function create(CreateRequest $request) {

        //get the validated request
        $validated = $request->safe()->all();

        $status = 0;

        $validated['password'] = Hash::make($validated['password']);

        //create the user with validated input
        $data = User::create($validated);

        $token = $data->createToken('myapptoken')->plainTextToken;

        if($data) $status = 1;

        return response()->json([
            "status" => $status,
            "data" => $data,
            //"token" => $token
        ]);
    }

    public function read(ReadRequest $request) {
        
        $validated = $request->safe()->only(['id']);

        $status = 0;

        $data = User::find($validated['id']);

        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status
        ]);
    }
    

    public function update(UpdateRequest $request) {

        //get all validated incoming request
        $validated = $request->safe()->all();
        
        //look for the user based on the id
        $data = User::find($validated['id']);
        
        if($data) $status = 1;
        
        try {

            $data->update($validated);

        } catch (\Throwable $th) {

            $status = 0;
        }

        return response()->json([
            'data' => $data,
            'status' => $status
        ]);
    }


    public function list(ListRequest $request){
        
        $search_columns  = ['username', 'name', 'email'];

        $limit = ($request->limit) ?  $request->limit : 50;
        $sort_column = ( $request->sort_column) ?  $request->sort_column : 'id';
        $sort_order = ( $request->sort_order) ?  $request->sort_order : 'desc';
        
        $status = 0;
          
        $data = new User;

        /* Searching for the value of the request. */
        if(isset($request->search)) {

            $key = $request->search;

            /* Searching for the key in the columns. */
            $data = $data->where(function ($q) use ($search_columns, $key) {

                foreach ($search_columns as $column) {

                    /* Searching for the key in the column. */
                    $q->orWhere($column, 'LIKE', '%'.$key.'%');
                }  
            });
        }
        
        /* Filtering the seller by status. */
        if (isset($request->status)) { 
            $data = $data->whereStatus($request->status);
        }

        /* Filtering the data by date. */
        if($request->from && $request->to) {
            
            $data = $data->whereBetween('created_at', [
                Carbon::parse($request->from)->format('Y-m-d H:i:s'), 
                Carbon::parse($request->to)->format('Y-m-d H:i:s')
            ]);
        }

        $data = $data->orderBy($sort_column, $sort_order)->paginate($limit);
        
        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status
        ]);
    }


    public function delete(DeleteRequest $request) {
        
        $validated = $request->safe()->only(['id']);

        $status = 0;

        $data = User::whereId($validated)->delete();

        if($data) $status = 1;

        return response()->json([
            'status' => $status
        ]);
    }
}
