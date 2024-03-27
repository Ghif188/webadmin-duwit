<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AccountController extends Controller
{
    // Variable
    public $status;
    public $message;
     
    /**
     * Display a listing of the resource.
     */
    public function getListAccount()
    {
        $status = true;
        $message = 'Data akun tersedia.'; 
        $account = User::all();
        if($account == null){
            $message = "Data akun kosong.";
        }
        return [ 
            'status' => $status ,
            'message' => $message,
            'data' => $account,
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePatner(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function getDetailAccount(string $id)
    {
        $account = User::find($id);
        $status = true;
        $message = 'Data akun tersedia.'; 
        if($account == null){
            $message = "Data akun kosong.";
        }
        return [ 
            'status' => $status ,
            'message' => $message,
            'data' => $account,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAccount(Request $request, string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatusAccount(Request $request, string $id)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $account = User::find($id);
        $status = true;
        $message = 'Status akun telah berubah.'; 
        if($account == null){
            $message = "Data akun kosong.";
        }
        $account->update([
            'status' => $request->status,
        ]);
        return [ 
            'status' => $status ,
            'message' => $message,
            'data' => $account,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPatner(string $id)
    {
        //
    }
}
