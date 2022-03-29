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
        // customerName
        //generate accountNumber
        //accountBalace = 0
        // comment = "null"

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
        // return $user->accountNumber;


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
        ]);

        // customerName
        //generate accountNumber
        //accountBalace = 0
        // comment = "null"

        $result = banking_service::where('accountNumber','=',$req->accountNumber);
        if($result->count()<1){
            return \response(["response"=>"No associated Account"],501);
        }

         return banking_service::where('accountNumber','=',$req->accountNumber)->get();
        // $balance = $result[0]["accountBalace"];
        // return $balance;
            
        // return $result;
        // if($result->count()>0){
        // if($result[0]["name"]){
        //     return \response(["response"=>"data saved"],201);
        // }
        // else{
        //     return \response(["response"=>"failed register"],501);
        // }
        // }
        //     return "junck";
    }

 /*  
    
    function debitAccount(Request $req){
        $this->validate($req,[
            'email'=>'required',
            'password'=>'required'
        ]);

        $result = create new record
        return $result;
        if($result->count()>0){
        if($result[0]["name"]){
            return \response(["response"=>"data saved"],201);
        }
        else{
            return \response(["response"=>"failed register"],501);
        }
        }
            return "junck";
    }
    */
}
