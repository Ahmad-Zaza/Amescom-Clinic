@extends('layouts.AdminApp')

@section('title')
    {{ 'Radiographs Technicians' }}
@endsection


@section('content')
    <form class="search-form" action="{{ route('admin.radiographs') }}" method="GET">
        <div class="form-row">
            <div class="col-md-9">
                <input type="text" class="form-control" name="search" placeholder="Search for a radiograph technician" />
            </div>
            <div class="col-sm-3">
                <button class="btn btn-info search-button" type="submit">Search</button>
            </div>
        </div>
    </form>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <form>
        <select class="form-control" id="pagination" style="width: 100px">
            <option value="5" @if ($per_page == 5) selected @endif>5</option>
            <option value="10" @if ($per_page == 10) selected @endif>10</option>
            <option value="25" @if ($per_page == 25) selected @endif>25</option>
        </select>
    </form>

    <a href="{{ route('admin.create.radTech') }}" class="btn btn-primary" style="margin-top:10px;">
        Add Radiograph Technician
    </a>

    <div class="table-responsive-md" style="margin-top: 30px">
        <table class="table">
            <caption>List of radiograph technicians</caption>
            <thead>
                <tr>
                    <th scope="col">@sortablelink('firstName', 'Name')</th>
                    <th scope="col">@sortablelink('department.name', 'Specialty')</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($radiographs as $radiograph)
                    <tr>
                        <th scope="row">{{ $radiograph->firstName . ' ' . $radiograph->lastName }}</th>
                        <td>{{ $radiograph->department->name }}</td>
                        <td>{{ $radiograph->phoneNumber }}</td>
                        <td>

                            @if ($radiograph->isContracted == 1)
                                <button class="btn btn-success" style="color: #ffffff">Contrated</button>
                            @else
                                <button type="button" class="btn btn-danger" style="color: #ffffff">Not Contrated</button>
                            @endif
                        </td>

                        <td>
                            <a
                                href="{{ route('admin.edit-radiographTech', ['radTech_id' => Crypt::encrypt($radiograph->id)]) }}">
                                <i class="fa fa-edit" style="font-size:25px; color:#FFC107; margin-top:2px"> </i>
                            </a>
                        </td>

                @endforeach
            </tbody>
        </table>
    </div>
    @if ($tag === true)
        <div class="footer">
            <a href="{{ route('admin.labTechs') }}">
                <button class="btn btn-info">Get All Radiograph Technicians</button>
            </a>
        </div>
    @endif
    <div class="d-flex justify-content-center">
        {!! $radiographs->appends(\Request::except('page'))->render() !!}
    </div>
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $radiographs->url(1) !!}&per_page=" + this.value;
        };
    </script>
@endsection
