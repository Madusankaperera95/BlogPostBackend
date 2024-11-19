<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ReturnResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    use ReturnResponse;
    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'picture' => 'required|Image|mimes:jpg,png,jiff'
        ]);


        $userDTO = new UserDTO($request->name,$request->email,$request->password,$request->picture);

        $this->userService->registerUser($userDTO);

        return $this->sendResponse([], 'User Registered Succesfully');
    }


    public function changePassword(Request $request){
        $request->validate([
            'old_password' => ['required',function ($attribute, $value, $fail) use($request) {
                if (!Hash::check($value,$request->user()->password)) {
                    $fail('Your entered password and real password is not matching');
                }
            }],
            'new_password' => ['required','confirmed']
        ]);

        $request->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['message'=>'Password Changed Successfully']);
    }

    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Wrong UserName or Password.');
        }
    }

    public function logout(Request $request){

        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Log out Successfully'],200);
    }


    public function updateUser(Request $request){
        $path = null;
        if($request->file('avatar')){
            $picture = $request->file('avatar');
            $pictureName = time().'.'.$picture->getClientOriginalExtension();
            $path = Storage::disk('s3')->putFileAs('uploads/logos',$picture,$pictureName);
        }
        $private = ($request->isPrivate == 'true') ? 1 : 0;
        $data = ['name'=>$request->name,
                 'biography'=>$request->biography,
                  'website'=>$request->website,
                  'is_private'=> $private
               ];
        if($path){
            $data['picture'] = $path;
        }

        User::where('id',$request->id)->update($data);
        return response()->json(['message'=>'Updated Profile Successfully'],200);
    }


}
