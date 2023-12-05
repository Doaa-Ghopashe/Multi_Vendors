<?php

namespace App\Http\Controllers;

use App\Models\User;
//use http\Client\Request;
//use http\Client\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function register(Request $request){

        //first we get all data from request and validate.
        $data = $request->all();
        $validators = Validator::make($data,[
            'name'=>[
                'required',
                'min:3',
                'max:255'
            ],
            'phone'=>[
                'required',
                'regex:/^01\d{9}$/'
            ],
            'password'=>[
                'required',
                'min:8',
                'max:14',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ],
            'email'=>[
                'required',
                'email',
                'unique:users,email'
            ],
            'avatar'=>[
                'required',
                'max:1000',
                'mimes:jpg,png,jpeg',
            ],
            'tag'=>[
                'required'
            ]
        ]);

        //then check the validation errors if it's already exist so return them else return successful message
        if(! count($validators->errors()->all())){
            //first store image in storage
            $newImgName = request()->file('avatar')->hashName();
            request()->file('avatar')->move(storage_path('/app/public/images'),$newImgName);

            //then inject this new image name in the data
            $data['avatar'] = $newImgName;

            //
            $data['tag']=explode(',',$data['tag']);

            //store data in the database
            $user = User::create($data);

            //
            $user->attachTags($data['tag']);

            //return a successful message
            return 'User Registration Succeeded';
        }

        //else return error message no data provided
        dd($validators->errors());
    }

    public function login(Request $request){
        //first we validate the data
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
