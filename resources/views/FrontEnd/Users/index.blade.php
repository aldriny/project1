

@extends('FrontEnd.Layouts.user-layout')
@section('title','SD Keeper')

@section('content')

@if (session()->get('success'))
<div class="alert alert-success">{{session()->get('success')}}</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger">          
    <strong>Sorry!</strong> There were more problems with your input.<br><br>         
    <ul>         
      @foreach ($errors->all() as $error)        
          <li>{{ $error }}</li>        
      @endforeach        
    </ul>         
</div>          
@endif

<div class="container-fluid p-5 mt-5">
    <h2 class="text-center mb-3 text-orange">Search for safe places near you!</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="{{route('user.search')}}">
                <div class="input-group">
                    <input type="search" name="search" class="form-control form-control-lg" placeholder="Search for safe places near you!">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-lg btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h2 class="display-4">Categories</h2>
    <p class="lead">Search our categories to find safe places near you!</p>
</div>

<div class="container ">
<div class="card-deck mb-3 text-center ">
    <div class="card mb-4 bg-transparent">
    <div class="card bg-transparent">
        <a href="{{route('user.show.rest')}}">
        <img class="card-img-top" src="{{ url('files/restaurant-logo.jpeg' ) }}" alt="Card image cap">
        <div class="card-body card-bg-color">
            <h5 class="card-title">
                <p class="text-white">Restaurants</p>
            </h5>
        </div>
        </a>
        </div>
    </div>
    <div class="card mb-4 bg-transparent">
    <div class="card bg-transparent">
        <a href="{{route('user.show.malls')}}">
        <img class="card-img-top" src="{{ url('files/malls-logo.jpg' ) }}" alt="Card image cap">
        <div class="card-body card-bg-color">
            <h5 class="card-title">
                <p class="text-white">Malls</p>
            </h5>
        </div>
        </a>
        </div>
    </div>
    <div class="card mb-4 bg-transparent">
    <div class="card bg-transparent">
        <a href="{{route('user.show.hosp')}}">
        <img class="card-img-top" src="{{ url('files/hospitals-logo.jpg' ) }}" alt="Card image cap">
        <div class="card-body card-bg-color">
            <h5 class="card-title">
                <p class="text-white">Hospitals</p>
            </h5>
        </div>
        </a>
        </div>
    </div>
</div>
</div>
<div class="container ">
    <div class="card-deck mb-3 text-center ">
        <div class="card mb-4 bg-transparent">
        <div class="card bg-transparent">
            <a href="{{route('user.show.stores')}}">
            <img class="card-img-top" src="{{ url('files/stores-logo.jpeg' ) }}" alt="Card image cap">
            <div class="card-body card-bg-color">
                <h5 class="card-title">
                    <p class="text-white">Stores</p>
                </h5>
            </div>
            </a>
            </div>
        </div>
        <div class="card mb-4 bg-transparent">
        <div class="card bg-transparent">
            <a href="{{route('user.show.cafes')}}">
            <img class="card-img-top" src="{{ url('files/cafes-logo.jpg' ) }}" alt="Card image cap">
            <div class="card-body card-bg-color">
                <h5 class="card-title">
                    <p class="text-white">Cafés</p>
                </h5>
            </div>
            </a>
        </div>
        </div>
        <div class="card mb-4 bg-transparent">
        <div class="card bg-transparent">
            <a href="{{route('user.show.comp')}}">
            <img class="card-img-top" src="{{ url('files/companies-logo.jpg' ) }}" alt="Card image cap">
            <div class="card-body card-bg-color">
                <h5 class="card-title">
                    <p class="text-white">Companies</p>
                </h5>
            </div>
            </div>
        </a>
        </div> 
    </div>
</div>


<div class="card bg-transparent" id="become-parnter-form">
    <div class="card-body row">
      <div class="col-md-5 col-sm-12 text-center d-flex align-items-center justify-content-center">
        <div class="">
          <h2 class="display-4"><strong class="text-orange">SD</strong>Keeper</h2>
          <p class="lead mb-5">Contact Us | Become a <strong class="text-orange">Partner</strong><br>
          </p>
        </div>
      </div>

      <div class="col-md-7 col-sm-12">
        <form method="POST" action="{{ route('become.partner') }}">
            @csrf
            <div class="form-group">
            <label for="inputName">Name</label>
            <input type="text" id="inputName" name="name" class="form-control bg-transparent" />
            </div>
            <div class="form-group">
            <label for="inputEmail">E-Mail</label>
            <input type="email" id="inputEmail" name="email" class="form-control bg-transparent" />
            </div>
            <div class="form-group">
            <label for="inputSubject">Phone Number</label>
            <input type="text" id="inputSubject" name="phone" class="form-control bg-transparent" />
            </div>
            <div class="form-group">
            <label for="inputMessage" >Message</label>
            <textarea id="inputMessage" name="msg" class="form-control  bg-transparent" rows="4"></textarea>
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary bg-transparent" value="Send message">Send Message</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h2 class="mb-5">About<span class="text-orange"> Us</span></h2>
    <p class="lead mb-5 container">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.</p>
</div>
<hr>
<div id="partners-div">

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h2 class="">Our <span class="text-orange"> Partners</span></h2>
        <p class="lead">Here's a list of our partners!</p>
    </div>




    <div class="container" id="partners">
                <div class="row">
                    <div class="col-xl col-md-3 col-sm-6 col-sm-12">
                        <img class="rounded-circle" src="{{ url('files/Hyundai-logo.png' ) }}" alt="partner1" width="140px" height="100px">
                    </div>
                    <div class="col-xl col-md-3 col-sm-6 col-sm-12">
                        <img class="rounded-circle" src="{{ url('files/Tibco-logo.png' ) }}" alt="partner1" width="140px" height="100px">
                    </div>
                    <div class="col-xl col-md-3 col-sm-6 col-sm-12">
                        <img class="rounded-circle" src="{{ url('files/AEG-logo.png' ) }}" alt="partner1" width="140px" height="100px">
                    </div> 
                    <div class="col-xl col-md-3 col-sm-6 col-sm-12">
                        <img class="rounded-circle" src="{{ url('files/Hyundai-logo.png' ) }}" alt="partner1" width="140px" height="100px">
                    </div>
                    <div class="col-xl col-md-3 col-sm-6 col-sm-12">
                        <img class="rounded-circle" src="{{ url('files/Tibco-logo.png' ) }}" alt="partner1" width="140px" height="100px">
                    </div>
                </div>
    </div>
</div>
<hr>


@endsection