@extends('Dashboards.Layouts.customer-dash-layout')
@section('title','SD Keeper | View My Place')

@section('content')

@if (session()->get('success'))
<div class="alert alert-success">{{session()->get('success')}}</div>
@endif
<div class="col-12">
    <div class="card card-primary">
      <div class="card-header">
        <h4 class="card-title">{{$myPlace->name}}</h4>
      </div>
      <div class="card-body">
              <dl class="row">
                <dt class="col-sm-4">Bussiness type:</dt>
                <dd class="col-sm-8">{{$myPlace->type}}</dd>

                <dt class="col-sm-4">Area:</dt>
                <dd class="col-sm-8">{{$myPlace->area . ' m2'}}</dd>
                <dt class="col-sm-4">Show Location:</dt>
                <dd class="col-sm-8">
                  <a  target="_blank" href="{{'https://www.google.com/maps/place/' . $myPlace->lat . ', ' . $myPlace->long}}">
                    Show Location
                  </a>
                </dd>
                <dt class="col-sm-4">Email:</dt>
                <dd class="col-sm-8">{{$myPlace->email}}</dd>
                <dt class="col-sm-4">Joined at:</dt>
                <dd class="col-sm-8">{{$myPlace->created_at . ' GMT'}}</dd>
                
      
                <dt class="col-sm-4">Pictures:</dt>

                @php $filenames = json_decode($myPlace->filenames); @endphp
                @foreach ($filenames as $singlefilename)
                <div class="mr-2">
                  <a href="{{ url('files/' . $singlefilename)}}">
                    <img src="{{ url('files/' . $singlefilename) }}" width="200px" height="200px">  
                  </a>    
                </div>
                @endforeach


              </dl>
      </div>
    </div>
</div>



{{-- <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
  Launch demo modal
</button>
  <!-- Modal -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @foreach ($myPlace as $place)
            @php $filenames = json_decode($myPlace->filenames); @endphp
            @foreach ($filenames as $singlefilename)    
              <img src="{{ url('files/' . $singlefilename) }}" width="50px" height="50px">
            @endforeach
            
            @endforeach
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
 --}}
{{-- @foreach ($places as $place)
@php $filenames = json_decode($place->filenames); @endphp
@foreach ($filenames as $singlefilename)    
  <img src="{{ url('files/' . $singlefilename) }}" width="50px" height="50px">
@endforeach

@endforeach
 --}}

@endsection