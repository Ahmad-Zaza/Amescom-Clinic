@extends('layouts.ReceptionistApp')

@section('title')
    {{ 'Reception Dashboard' }}
@endsection

@section('content')
    <form class="search-form" action="{{ route('receptionist.patient.search') }}" method="GET">
        <div class="form-row">
            <div class="col-md-9">
                <input type="text" class="form-control" name="search" placeholder="Search for a patient" />
            </div>
            <div class="col-sm-3">
                <button class="btn btn-info search-button" type="submit">Search</button>
            </div>
        </div>
    </form>
@endsection
