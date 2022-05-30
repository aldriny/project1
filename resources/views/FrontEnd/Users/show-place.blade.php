
@extends('FrontEnd.Layouts.user-layout')
@section('title','View Place')

@section('content')


@if (session()->get('success'))
<div class="alert alert-success">{{session()->get('success')}}</div>
@endif
    <div class="card card-primary bg-transparent mt-5">
      <div class="card-body mx-auto " id="view_place_card">
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal  ">{{$show_place->name}}</h1>
            <div class="bd-example container mb-3" id="place_images_slide">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel"> 
                    <ol class="carousel-indicators">
                        @php $filenames = json_decode($show_place->filenames); @endphp
                        @foreach ($filenames as $value)
                    <li data-target="#carouselExampleCaptions" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach( $filenames as $value )
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ url('files/' . $value) }}" class="d-block w-100" alt="..." height="300" width="350">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <p class="text-center mb-4">Area: {{$show_place->area . ' m2'}}</p>
            <p class="text-center mb-4">Distance: {{round($distance,2) . ' km'}}</p>

            <a class="btn-primary btn bg-transparent border-secondary" id="place_dir" target="_blank" href="{{'https://www.google.com/maps/dir//' . $show_place->lat . ', ' . $show_place->long}}">Get Directions</a>  

          </div>
        </div>
    </div>
@endsection