<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\PatnerController;
use App\Http\Controllers\Service\AccountController;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function __construct( 
        PatnerController $PatnerController,
        AccountController $AccountController 
        )
    {
        $this->PatnerController = $PatnerController;
        $this->AccountController =$AccountController;
    }

    public function getIndexPatner()
    {
        $data = $this->PatnerController->getListPatner();
        $patners = $data['data'];
        return view('patner.index', compact('patners'));
    }

    public function getDetailPatner($id)
    {
        $data = $this->PatnerController->getDetailPatner($id);
        $patner = $data['data'];
        return view('patner.show', compact('patner'));
    }

    public function postChangeStatusPatner(Request $request, $id)
    {
        $data = $this->PatnerController->updateStatusPatner($request, $id);
        $message = $data['message']; 
        $patner = $data['data'];
        return redirect()->route('patner.detail', ['id' => $patner->id])->with('status', $message);
    }

    public function getIndexAccount()
    {
        $data = $this->AccountController->getListAccount();
        $accounts = $data['data'];
        return view('account.index', compact('accounts'));
    }

    public function getDetailAccount($id)
    {
        $data = $this->AccountController-> getDetailAccount($id);
        $account = $data['data'];
        return view('account.show', compact('account'));
    }

    public function postChangeStatusAccount(Request $request, $id)
    {
        $data = $this->AccountController->updateStatusAccount($request, $id);
        $message = $data['message']; 
        $account = $data['data'];
        return redirect()->route('account.detail', ['id' => $account->id])->with('status', $message);
    }
}
