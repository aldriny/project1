<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Place;
use App\Models\Edit;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function show_login_form(){
        return view('Dashboards.CustomersLoginSystem.login');
    }

    function show_signup_form(){
        return view('Dashboards.CustomersLoginSystem.register');
    }

    function process_admin_signup(Request $request){
        //Validate requests
        $request -> validate([
            'name'=>'required',
            'email'=>'required|email|unique:customers',
            'password'=>'required|min:5|max:12',
            'password_confirmation'=>'required|same:password|min:5|max:12',
        ]);

        //Insert data into DB
        $admin = new Customer;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
    
        $save = $admin->save();
        if($save){
            return redirect()->route('customer.login1')->with('success','New user has been created, please login');
        }
        else{
            return back()->with('fail','something went wrong, please try again later');
        }
    }

    function process_admin_login(Request $request){
        
        //Validate Requests
        $request-> validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12',
        ]);

        $myPlace = Place::whereEmail($request->email)->first();
        Session::put('myPlace', $myPlace);

        $userInfo = Place::where('email','=',$request->email)->first();

        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }
        else{
            //Check Password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser2',$userInfo->id);
                return redirect('customer/dashboard');
            }
            else{
                return back()->with('fail','Incorrect Password');
            }
        }
    }

    function admin_dashboard(){
        
        $data = ['LoggedUserInfo'=>Customer::where('id','=',session('LoggedUser2'))->first()];
        return view('Dashboards.Customers.index', $data);
    }

    
    function admin_logout(){
        if(session()->has('LoggedUser2')){
            session()->pull('LoggedUser2');
            return redirect('customer/login');
        }
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
    function view_place(){
        $myPlace = Session::get('myPlace');

        $data = ['LoggedUserInfo'=>Customer::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Customers.view-place', $data, ['myPlace'=>$myPlace]);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
    function edit_place(Request $request){
        $myPlace = Session::get('myPlace');

        $data = ['LoggedUserInfo'=>Customer::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Customers.edit-myplace', $data, ['myPlace'=>$myPlace]);
    }

    function edit_myplace(Request $request){

        //Validate requests
        $request -> validate([
            'name'=>'required',
            'area'=>'required',
            'email'=>'required|email',
            'long'=>'required|between:-180,180|numeric|between:0,99.99',
            'lat'=>'required|between:-90,90|numeric|between:0,99.99',
            'type'=>'required|not_in:0',
            'filenames' => 'required',
            'filenames.*' => 'image',
        ]);
        $files = [];
        if($request->hasfile('filenames'))
            {
            foreach($request->file('filenames') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('files'), $name);  
                $files[] = $name;  
            }
            }   
        //Insert data into DB
        $myEdit = new Edit;
        $myEdit->name = $request->name;
        $myEdit->area = $request->area;
        $myEdit->email = $request->email;
        $myEdit->long = $request->long;
        $myEdit->lat = $request->lat;
        $myEdit->type = $request->type;
        $myEdit->filenames = $files;
        $save = $myEdit->save();
        if($save){
            return redirect()->route('customer.view.place')->with('success','Edit request has been sent successfuly!');
        }
        else{
            return back()->with('fail','something went wrong, please try again');
        }       
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////

    function show_change_password()
    {
        return view('Dashboards.Customers.change-password');
    } 

    function change_password(Request $request)
    {
        $myPlace = Session::get('myPlace');
        $request->validate([
            'current_password' => 'required',
            'password'=>'required|min:5|max:12',
            'password_confirmation'=>'required|same:password|min:5|max:12',
        ]);     





        $current_confirm = Hash::check($request->current_password, $myPlace->password);
         
        if($current_confirm){
            $myPlace->password = Hash::make($request->password);
            $save = $myPlace->save();
            return redirect()->route('show.change.password')->with('success','Password changed successfully!');

        }
        else{
            return back()->with('fail','something went wrong, please try again');
        }




        //Insert data into DB
    

}

}
