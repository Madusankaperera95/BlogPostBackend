<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserService
{

    public function registerUser(UserDTO $userDTO){
        $path = null;

        if($userDTO->image){
            $picture = $userDTO->image;
            $pictureName = time().'.'.$picture->getClientOriginalExtension();
            $path = Storage::disk('s3')->putFileAs('uploads/logos',$picture,$pictureName);
        }


        $input = ['name'=> $userDTO->name,'email'=>$userDTO->email,'password'=>$userDTO->password];
        $input['password'] = bcrypt($input['password']);
        $input['picture'] = $path;
        $input['role'] = 'commentor';
        $user = User::create($input);
        $success['name'] = $user->name;
    }
}
