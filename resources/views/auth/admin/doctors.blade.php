@extends('layouts.AdminApp')

@section('title')
    {{ 'Doctors' }}
@endsection


@section('content')
    <form class="search-form" action="{{ route('admin.doctors') }}" method="GET">
        <div class="form-row">
            <div class="col-md-9">
                <input type="text" class="form-control" name="search" placeholder="Search for a doctor" />
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

    <div class="row">
        <div class="col-6">
            <a href="{{ route('admin.create.doctor') }}" class="btn btn-primary" style="margin-top:10px;">
                Add Doctor
            </a>
        </div>
        <div class="col-6">

            {{-- <input type="text" name="doctor_name" id="doctor_name" class="form-control-lg" placeholder="Enter Doctor Name" /> --}}


        </div>

    </div>
    <div class="table-responsive-md" style="margin-top: 30px">
        <table class="table">
            <caption>List of doctors</caption>
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
                @foreach ($doctors as $doctor)
                    <tr>
                        <th scope="row">{{ $doctor->firstName . ' ' . $doctor->lastName }}</th>
                        <td>{{ $doctor->department->name }}</td>
                        <td>{{ $doctor->phoneNumber }}</td>
                        <td>

                            @if ($doctor->isContracted == 1)
                                <button class="btn btn-success" style="color: #ffffff">Contrated</button>
                            @else
                                <button type="button" class="btn btn-danger" style="color: #ffffff">Not Contrated</button>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.edit-doctor', ['doctor_id' => Crypt::encrypt($doctor->id)]) }}">
                                <i class="fa fa-edit" style="font-size:25px; color:#FFC107; margin-top:2px"> </i>
                            </a>
                        </td>

                @endforeach
            </tbody>
        </table>
    </div>
    @if ($tag === true)
        <div class="footer">
            <a href="{{ route('admin.doctors') }}">
                <button class="btn btn-info">Get All Patients</button>
            </a>
        </div>
    @endif

    <div class="d-flex justify-content-center">
        {{-- {!! $visits->links() !!} --}}
        {!! $doctors->appends(\Request::except('page'))->render() !!}
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#doctor_name').autocomplete({
                source: "{{ route('admin.search-doctor.action') }}",
                minlength: 1,
                autofocus: true,
                select: function(event, ui) {
                    $("doctor_name").val(ui.item.value);
                }
            });
        });
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $doctors->url(1) !!}&per_page=" + this.value;
        };
    </script>


@endsection
