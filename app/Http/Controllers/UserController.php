<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request) {
        $searchbox = $request->query('searchbox');

        if ($searchbox == ''){
             $users = User::All();
        }else{
            $users= User::where('name','like','%'.$searchbox . '%')->get();
        }
        return view('users.index', ['users'=> $users]);
    }

    public function create(){

        return view('users.create');
    }

    public function store(Request $request){

        var_dump ($request->input());
        $name= $request->input('name');
        $email= $request->input('email');
        $password= $request->input('password');
        var_dump ($request->input([ $name,$email,$password]));

        $user = new User;
        $user->name= $name;
        $user->email= $email;
        $user->password= Hash::make($password);


        $user->save();


        return Redirect::route('users.index') ;

}

    //display
    public function show($id, Request $request){


        $user = User::where('id', $id)->first();
        return view('users.show',['user'=>$user]);

    }

    public function update($id, Request $request){


        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->password != ''){
        $user->password = Hash::make($request->passowrd);
        }
        $user->save();

        return Redirect::route('users.index') ;
    }


     //delete
     public function destroy($id, Request $request){
        User::destroy($id);
        return Redirect::route('users.index') ;
    }
    //api get all
    public function apiGetAll(){
        $users= User::all();
        return response()->json($users,200);
     }

     //api get one
     public function apiGetOne($id){
         try{
             $user= User::where('id',$id)->firstOrFail();

         }catch(\Throwable $th){
             return response()->json(['User Not Found'],404);
         }
     return response()->json($user,200);
     }

    // API CREATE USER

    public function apiCreateUser(Request $request){

        $validators = Validator::make($request->all(),[
            'email' => 'required | email | max:200| unique:users,email',
            'name' => 'required | max:100',
            'role' => 'required | in:member,Admin',
            'password' => 'required | max:50'
        ]);

        if($validators ->fails()){
            $errors = $validators->errors();
            return response()->json($errors, 400);
        }

        $data = $request->only([
            'name',
            'email',
            'password',
            'role'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if($user){
            $responseData = [
                'status'=> 'success',
                'message'=> 'User Created'
            ];
            return response()->json('User Created',200);
        }else{
            $responseData = [
                'status'=> 'failed',
                'message'=> 'Unable to Create'
            ];
            return response()->json('Unable to Create',400);
        }

        return response()->json('',200);
    // SAVE DB
    }
    //APi UPDATE USER

    public function apiUpdateUser(Request $request,$id){

        $validators = Validator::make($request->all(),[
            'email' => 'required | email | max:200'.Rule::unique('users','email'),
            'name' => 'required | max:100',
            'role' => 'required | in:member,Admin',
            'password' => 'required | max:50'
        ]);
        if($validators ->fails()){
            $errors = $validators->errors();
            return response()->json($errors, 400);
        }

        try {

            $userData = $request->only([
                'email',
                'name',
                'role' ,
                'password'
            ]);

            $userData['password'] = Hash::make($userData['password']);
            User::find($id)->update($userData);
            return response()->json($userData, 200);

        }  catch (\Throwable $th) {
            return response()->json('User not Created', 404);
        }
    }
    //API DELETE
    public function apiDelete ($id){
        return User::destroy($id);
    }
    public function profile(Request $request){
        return $request->user();
    }
}
