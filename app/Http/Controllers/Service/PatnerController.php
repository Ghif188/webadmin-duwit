<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patners;

class PatnerController extends Controller
{
    // Variable
    public $status;
    public $message;
     
    /**
     * Display a listing of the resource.
     */
    public function getListPatner()
    {
        $status = true;
        $message = 'Data patner tersedia.'; 
        $patner = Patners::all();
        if($patner == null){
            $message = "Data patner kosong.";
        }
        return [ 
            'status' => $status ,
            'message' => $message,
            'data' => $patner,
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
    public function getDetailPatner(string $id)
    {
        $patner = Patners::find($id);
        $status = true;
        $message = 'Data patner tersedia.'; 
        if($patner == null){
            $message = "Data patner kosong.";
        }
        return [ 
            'status' => $status ,
            'message' => $message,
            'data' => $patner,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePatner(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|string|',
        ]);
        $patner = Patners::find($id);
        $status = true;
        $message = 'Data patner tersedia.'; 
        if($patner == null){
            $message = "Data patner kosong.";
        }
        return [ 
            'status' => $status ,
            'message' => $message,
            'data' => $patner,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatusPatner(Request $request, string $id)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $patner = Patners::find($id);
        $status = true;
        $message = 'Status patner telah berubah.'; 
        if($patner == null){
            $message = "Data patner kosong.";
        }
        $patner->update([
            'status' => $request->status,
        ]);
        return [ 
            'status' => $status ,
            'message' => $message,
            'data' => $patner,
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
