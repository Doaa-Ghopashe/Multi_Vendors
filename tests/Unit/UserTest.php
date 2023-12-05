<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
//    public function test_login_form(){
//
//        $response =$this->post('/login',);
//
//        $response->assertStatus(200);
//    }

    public function test_user_Authorization()
    {

        //preparation
        $authorizedUser = [
            'email' => 'doaa@jk.com',
            'password' => 'Pa452$@do'
        ];

        $unauthorizedUser = [
            'email' => 'doaa@jk.com',
            'password' => 'dodfksdl'
        ];

        //action
        $response = $this->post('api/login',$unauthorizedUser);

        //assertion
        $response->dump();

    }
}
