@extends('layouts.TechniciansApp')

@section('title')
    {{ 'Radiograph Analysis' }}
@endsection

@section('content')
    <style>
        img {
            max-width: 100%;
            max-height: 100%;
            padding-top: 10px;
        }

    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-center">
                    radiograph Analysis Info
                </h3>
            </div>
            <div class="col-md-6">
                <p> {{ $radiographAnalysis->content }} </p><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-center">
                    radiograph Analysis Date
                </h3>
            </div>
            <div class="col-md-6">
                <p> {{ $radiographAnalysis->created_at }} </p><br>
            </div>
        </div>


        <div class="card-deck row">
            @foreach ($photos as $photo)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <img id="piecture" class="img" src="{{ $photo->getUrl() }}" alt="">
                </div>
            @endforeach
        </div>

    </div>
@endsection
