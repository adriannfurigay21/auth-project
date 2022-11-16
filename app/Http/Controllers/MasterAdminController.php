<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\Wallet;

use App\Http\Requests\MasterAdmin\Business\ReadRequest;
use App\Http\Requests\MasterAdmin\Business\DeleteRequest;
use App\Http\Requests\MasterAdmin\Business\ListRequest;

use App\Http\Requests\MasterAdmin\Wallet\ReadRequestt;
use App\Http\Requests\MasterAdmin\Wallet\DeleteRequestt;
use App\Http\Requests\MasterAdmin\Wallet\ListRequestt;

class MasterAdminController extends Controller
{
    public function read(ReadRequest $request) {
        
        $validated = $request->safe()->only(['id']);

        $status = 0;

        $data = Business::find($validated['id']);
        //$data = Business::where('user_id', '=', Auth::id())->get();

        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status
        ]);
    }

    public function list(ListRequest $request){
    
        
        $search_columns  = ['name', 'address'];

        $limit = ($request->limit) ?  $request->limit : 50;
        $sort_column = ( $request->sort_column) ?  $request->sort_column : 'id';
        $sort_order = ( $request->sort_order) ?  $request->sort_order : 'desc';
        
        $status = 0;
          
        $data = new Business;

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

        $data = Business::whereId($validated['id'])->delete();

        if($data) $status = 1;

        return response()->json([
            'status' => $status
        ]);
    }

    /*------------------------------------------------WALLET----------------------------------------------- */


    public function readWallet(ReadRequestt $request) {
        
        $validated = $request->safe()->only(['id']);

        $status = 0;

        $data = Wallet::find($validated['id']);

        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status
        ]);
    }

    public function listWallet(ListRequestt $request){
    
        
        $search_columns  = ['name', 'account_no', 'amount'];

        $limit = ($request->limit) ?  $request->limit : 50;
        $sort_column = ( $request->sort_column) ?  $request->sort_column : 'id';
        $sort_order = ( $request->sort_order) ?  $request->sort_order : 'desc';
        
        $status = 0;
          
        $data = new Wallet;

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
    


    public function deleteWallet(DeleteRequestt $request) {
        
        $validated = $request->safe()->only(['id']);

        $status = 0;

        $data = Wallet::whereId($validated['id'])->delete();

        if($data) $status = 1;

        return response()->json([
            'status' => $status
        ]);
    }
}
