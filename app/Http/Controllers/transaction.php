<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\banking_service;


class transaction extends Controller
{
    
    function createAccount(Request $req){
        $this->validate($req,[
            'customerName'=>'required',
            'accountBalace'=>'required',
        ]);

        $user  = new banking_service;
        $user->customerName = $req->customerName;
        $user->comment = " ";
        $user->accountBalace = $req->accountBalace ;

        $isUsed =1;
        $num_str = 0;
        
        if((banking_service::where('customerName','=',$req->customerName))->count()>0){
            return \response(["response"=>"User Already exist"],501);
        }
            

        while(1) {
            $num_str = sprintf("%06d", mt_rand(100000, 999999));
            $isUsed= banking_service::where('accountNumber','=',$num_str);
            if($isUsed->count()==0) break;
        }

        $user->accountNumber = $num_str;


        $result = $user->save();
        if($result){
            return \response(["response"=>"data saved"],201);
        }
        else{
            return \response(["response"=>"registeration failed"],501);
        }
    }
 
    function creditAccount(Request $req){
        $this->validate($req,[
            'accountNumber'=>'required',
            'amount'=>'required',
        ]);


        $result = banking_service::where('accountNumber','=',$req->accountNumber)->orderBy('created_at', 'desc')->get();
        if($result->count()<1){
            return \response(["response"=>"No associated Account"],501);
        }
        $balance = $result[0]["accountBalace"] + $req->amount;
        $user = new banking_service;
        $user->customerName = $result[0]["customerName"];
        $user->accountNumber = $req->accountNumber;
        $user->accountBalace = $balance;
        $user->comment = " ";// $req->comment;

        $result = $user->save();
         
        if($result){
            return \response(["response"=>"data saved"],201);
        }
        else{
            return \response(["response"=>"failed to credit account"],501);
        }
    }

    
    function debitAccount(Request $req){
        $this->validate($req,[
            'accountNumber'=>'required',
            'amount'=>'required',
        ]);


        $result = banking_service::where('accountNumber','=',$req->accountNumber)->orderBy('created_at', 'desc')->get();
        if($result->count()<1){
            return \response(["response"=>"No associated Account"],501);
        }
        $balance = $result[0]["accountBalace"] - $req->amount;
        $user = new banking_service;
        $user->customerName = $result[0]["customerName"];
        $user->accountNumber = $req->accountNumber;
        $user->accountBalace = $balance;
        $user->comment = " ";// $req->comment;

        $result = $user->save();
         
        if($result){
            return \response(["response"=>"data saved"],201);
        }
        else{
            return \response(["response"=>"failed to debit account"],501);
        }
    }

//////////

function checkbalance(Request $req){
    $this->validate($req,[
        'accountNumber'=>'required',
    ]);


    $result = banking_service::where('accountNumber','=',$req->accountNumber)->orderBy('created_at', 'desc')->get();
    if($result->count()<1){
        return \response(["response"=>"No associated Account"],501);
    }
     
    if($result){
        return \response([$result[0]],201);
    }
    else{
        return \response(["response"=>"failed to credit account"],501);
    }
}

       

}

/*  "customerName": "ggold",
        "accountNumber": 968199,
        "accountBalace": 1342,
        "comment": " "
 */