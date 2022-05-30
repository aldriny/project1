<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\User;
use App\Models\Partner;


class UserController extends Controller
{
    function show_login_form(){
        return view('FrontEnd.UsersLoginSystem.login');
    }

    function show_signup_form(){
        return view('FrontEnd.UsersLoginSystem.register');
    }

    function process_user_signup(Request $request){
        //Validate requests
        $request -> validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins',
            'password'=>'required|min:5|max:12',
            'password_confirmation'=>'required|same:password|min:5|max:12',
        ]);

        //Insert data into DB
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
    
        $save = $user->save();
        if($save){
            return redirect()->route('user.login1')->with('success','New user has been created, please login');
        }
        else{
            return back()->with('fail','something went wrong, please try again later');
        }
    }

    function process_user_login(Request $request){


        //Validate Requests
        $request-> validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12',
        ]);

        $getLong = $request->input('userLong');
        $getLat = $request->input('userLat');
        $getAcc = $request->input('userAcc');
        if($getLong === null || $getLat === null || $getAcc === null){
            return back()->with('fail','Please allow location');
        }

        
        

        $latitude1 = $getLat;
        $longitude1 = $getLong;
    

         Session::put('long', $getLong);
        Session::put('lat', $getLat);



        $userInfo = User::where('email','=',$request->email)->first();
        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }
        else{
            //Check Password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser3',$userInfo->id);
                return redirect('user/dashboard');
            }
            else{
                return back()->with('fail','Incorrect Password');
            }
        }
    }
    function user_dashboard(){
        $data = ['LoggedUserInfo'=>User::where('id','=',session('LoggedUser3'))->first()];
        return view('FrontEnd.Users.index', $data);
    }

    
    function user_logout(){
        if(session()->has('LoggedUser3')){
            session()->pull('LoggedUser3');
            return redirect('user/login');
        }
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////// 
function become_partner(Request $request){

    //Validate requests
    $request -> validate([
        'name'=>'required',
        'email'=>'required|email',
        'phone'=>'required|regex:/(01)[0-9]{9}/',
        'msg'=>'required|min:3|max:1000',
    ]);
    $partner = new Partner;
    $partner->name = $request->name;
    $partner->email = $request->email;
    $partner->phone = $request->phone;
    $partner->msg = $request->msg;

    $save = $partner->save();
    if($save){
        return redirect()->route('user.dashboard')->with('success','New place has been added successfuly');
    }
    else{
        return back()->with('fail','something went wrong, please try again');
    }

}
//////////////////////////////////////////////////////////////////////////////////////////////////////// 

function show_user_place(){
    $get_id = request('id');
    $get_distance = request('distance');
    $show_place = Place::where('id','=',$get_id)->first();
    return view('FrontEnd.Users.show-place', ['show_place'=>$show_place, 'distance'=>$get_distance]);
}

function show_search_places(Request $request){

    $search = $request->input('search');
    
    $latitude1 = Session::get('lat');
    $longitude1 = Session::get('long');

    $places = DB::table("places")
    ->where('name', 'LIKE', '%' . $search . '%')
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
    
/*     $places = DB::table("places")
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
     */
    return view('FrontEnd.Users.search',['places'=>$places]);

    

}
function show_malls(){
    $latitude1 = Session::get('lat');
    $longitude1 = Session::get('long');
    $places = DB::table("places")
    ->where('type','=','Mall')
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
    
    return view('FrontEnd.Users.malls', ['places'=>$places]);
}
function show_rest(){
    $latitude1 = Session::get('lat');
    $longitude1 = Session::get('long');
    $places = DB::table("places")
    ->where('type','=','Restaurant')
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
    
    return view('FrontEnd.Users.restaurants', ['places'=>$places]);
}
function show_hosp(){
    $latitude1 = Session::get('lat');
    $longitude1 = Session::get('long');
    $places = DB::table("places")
    ->where('type','=','Hospital')
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
    
    return view('FrontEnd.Users.hospitals', ['places'=>$places]);
}
function show_stores(){
    $latitude1 = Session::get('lat');
    $longitude1 = Session::get('long');
    $places = DB::table("places")
    ->where('type','=','Store')
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
    
    return view('FrontEnd.Users.stores', ['places'=>$places]);
}
function show_cafes(){
    $latitude1 = Session::get('lat');
    $longitude1 = Session::get('long');
    $places = DB::table("places")
    ->where('type','=','Cafe')
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
    
    return view('FrontEnd.Users.cafes', ['places'=>$places]);
}
function show_comp(){
    $latitude1 = Session::get('lat');
    $longitude1 = Session::get('long');
    $places = DB::table("places")
    ->where('type','=','Company')
    ->select('places.id','places.name','places.long','places.lat','places.type'
        ,DB::raw("6371 * acos(cos(radians(".$latitude1.")) 
        * cos(radians(places.lat)) 
        * cos(radians(places.long) - radians(".$longitude1.")) 
        + sin(radians(".$latitude1.")) 
        * sin(radians(places.lat))) AS distance"))
        ->orderBy('id', 'DESC')
        ->get();        
    
    return view('FrontEnd.Users.companies', ['places'=>$places]);
}






function distance(Request $request){




}




}
