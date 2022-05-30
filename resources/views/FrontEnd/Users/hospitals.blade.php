
@extends('FrontEnd.Layouts.user-layout')
@section('title','Hospitals')

@section('content')


<div class="container p-2 mt-3">
    <div class="row">
        <div class="col-12">
        <div class="card  bg-transparent">
            <div class="card-header text-white  bg-orange">
            <h3 class="card-title">Hospitals near you</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0 table-responsive bg-white" style="height: 300px;" >
            <table class="table text-nowrap table-head-fixed ">
                <thead class="text-orange">
                <tr class="">
                    <th>Name</th>
                    <th>Location</th>
                    <th>Distance</th>

                </tr>
                </thead>
                <tbody class="text-black" id="search-body">
                @foreach ($places as $hosp)
                    <tr>
                        <td>
                            <a href="{{route('user.show.place', [$hosp->id, $hosp->distance])}}">{{$hosp->name}}</a>
                        </td>
                        <td>
                            <a target="_blank" href="{{'https://www.google.com/maps/dir//' . $hosp->lat . ', ' . $hosp->long}}">Get directions</a>  
                          </td>
  
                          <td>{{round($hosp->distance,2) . ' km'}}</td>

                    </tr>
                @endforeach  
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
    </div>
</div>





@endsection