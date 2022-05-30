<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Models\Place;
use App\Models\Edit;
use App\Models\Partner;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{  

    function show_login_form(){
        return view('Dashboards.AdminsLoginSystem.login');
    }

    function show_signup_form(){
        return view('Dashboards.AdminsLoginSystem.register');
    }

    function process_admin_signup(Request $request){
        //Validate requests
        $request -> validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins',
            'password'=>'required|min:5|max:12',
            'password_confirmation'=>'required|same:password|min:5|max:12',
        ]);

        //Insert data into DB
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
    
        $save = $admin->save();
        if($save){
            return redirect()->route('admin.login1')->with('success','New user has been created, please login');
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

        $userInfo = Admin::where('email','=',$request->email)->first();
        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }
        else{
            //Check Password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser',$userInfo->id);
                return redirect('admin/dashboard');
            }
            else{
                return back()->with('fail','Incorrect Password');
            }
        }
    }
    function admin_dashboard(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Admins.index', $data);
    }

    
    function admin_logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('admin/login');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////
    function show_add_place(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Admins.add-place', $data);
    }
    function add_place(Request $request){
                //Validate requests
                $request -> validate([
                    'name'=>'required',
                    'area'=>'required',
                    'email'=>'required|email|unique:places',
                    'password'=>'required|min:5|max:12',
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
                $place = new Place;
                $place->name = $request->name;
                $place->area = $request->area;
                $place->email = $request->email;
                $place->password = Hash::make($request->password);
                $place->long = $request->long;
                $place->lat = $request->lat;
                $place->type = $request->type;
                $place->filenames = $files;
                $save = $place->save();
                if($save){
                    return redirect()->route('admin.view.places')->with('success','New place has been added successfuly');
                }
                else{
                    return back()->with('fail','something went wrong, please try again');
                }
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
    function view_places(){
        $places = Place::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Admins.view-places', $data, ['places'=>$places]);
    }
    function show_place($id, Request $request){

    $places = Place::find($id);


        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Admins.edit-place', $data, ['places'=>$places]);
    }

    function edit_place($id, Request $request){
        $places = Place::find($id);
        //Validate requests
        $request -> validate([
            'name'=>'required',
            'area'=>'required',
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
        $places->name = $request->name;
        $places->area = $request->area;
        $places->long = $request->long;
        $places->lat = $request->lat;
        $places->type = $request->type;
        $places->filenames = $files;
        $save = $places->save();
        if($save){
            return redirect()->route('admin.view.places')->with('success','place has been edited successfully');
        }
        else{
            return back()->with('fail','something went wrong, please try again');
        }       
    }
    
    function delete_place($id, Request $request){
        $places = Place::find($id);
        $places->delete();
        return redirect()->route('admin.view.places');
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
    function partner_req(){

        $become_partner = Partner::all();


        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Admins.partner-req', $data, ['become_partner'=>$become_partner]);        
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
    function partner_rep(){
    
        $edits = Edit::all();


    
        $data = ['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('Dashboards.Admins.partner-rep', $data, ['edits'=>$edits]);        
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
