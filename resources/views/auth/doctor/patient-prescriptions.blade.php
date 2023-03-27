@extends('layouts.DoctorApp')

@section('title')
    {{ 'Prescriptions' }}
@endsection

@section('content')
    {{-- <h1>welcome To prescriptions page</h1> --}}
    <form>
        <select class="form-control" id="pagination" style="width: 100px">
            <option value="5" @if ($per_page == 5) selected @endif>5</option>
            <option value="10" @if ($per_page == 10) selected @endif>10</option>
            <option value="25" @if ($per_page == 25) selected @endif>25</option>
        </select>
    </form>

    <div class="table-responsive-md" style="margin-top: 30px">
        <table class="table">
            <caption>List of users</caption>
            <thead>
                <tr>
                    <th scope="col">@sortablelink('id', 'ID')</th>
                    <th scope="col">@sortablelink('patient.firstName', 'Name')</th>
                    <th scope="col">@sortablelink('created_at', 'Date')</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescriptions as $prescription)
                    <tr>
                        <th scope="row">{{ $prescription->id }}</th>
                        <td>{{ $prescription->patient->firstName . ' ' . $prescription->patient->lastName }}</td>
                        <td>{{ $prescription->created_at }}</td>

                        <td> <a
                                href="{{ route('doctor.patient.prescription', ['prescription_id' => Crypt::encrypt($prescription->id)]) }}">
                                <i class="fa fa-eye" style="font-size:25px; color:#4768DB;"> </i> </a> </td>
                        @if ($prescription->medical_person_id === Auth::guard('medical_person')->user()->id)
                            <td>
                                <a
                                    href="{{ route('doctor.edit-prescription', ['prescription_id' => Crypt::encrypt($prescription->id)]) }}">
                                    <i class="fa fa-edit" style="font-size:25px; color:#FFC107; margin-top:2px"> </i>
                                </a>
                            </td>
                        @endif

                @endforeach
            </tbody>
        </table>
    </div>


    <div class="d-flex justify-content-center">
        {{-- {!! $visits->links() !!} --}}
        {!! $prescriptions->appends(\Request::except('page'))->render() !!}
    </div>
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $prescriptions->url(1) !!}&per_page=" + this.value;
        };
    </script>
@endsection
