<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Controllers\API\BaseController as BaseController;

class AuthController extends BaseController
{
        
    /**
     * Method login
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name']  =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
    
    /**
     * Method logout
     *
     * @return void
     */
    public function logout()
    {
        
        auth()->user()->tokens()->delete();

        return $this->sendResponse('', 'User logout successfully.');
    }
}
