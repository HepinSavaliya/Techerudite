<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function customerRegistrationForm(){
        
        return view('auth.customer-registration',['role' => 'customer']);
    }

    public function adminRegistrationForm(){
      
        return view('auth.admin-registration',['role' => 'admin']);
    }

    protected function validator($data)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];

        return Validator::make($data, $rules);
    }

    protected function create($data,$roleName){
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::firstOrCreate(['name' => $roleName]);
        
        $user->roles()->attach($role);
        return $user;

    }

    public function customerRegistration(Request $request){
        
        $this->validator($request->all(), 'customer')->validate();

        $this->create($request->all(), 'customer');

        return redirect()->back()->with('success', 'Customer registered successfully.');
    }

    public function adminRegistration(Request $request){
        $this->validator($request->all(), 'admin')->validate();

        $this->create($request->all(), 'admin');

        return redirect()->route('login')->with('success', 'Admin registered successfully. Please log in.');
    }
}
