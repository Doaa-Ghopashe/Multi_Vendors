<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function Laravel\Prompts\password;

class RegisterController extends Controller
{
    //This create is for usual user
    public function create(){
        //first we get all data from request and validate.
        $data = request()->all();

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
            ]
        ]);

        //then check the validation errors if it's already exist so return them else return successful message
        if(! count($validators->errors()->all())){
            //first store image in storage
            $newImgName = request()->file('avatar')->hashName();
            request()->file('avatar')->move(storage_path('/app/public/images'),$newImgName);

            //then inject this new image name in the data
            $data['avatar'] = $newImgName;

            //store data in the database
            $user = User::create($data);

            //return a successful message
            return 'User Registration Succeeded';
        }

        //else return error message no data provided
        //return 'No Data Provided';
        dd($validators->errors());

    }
}
