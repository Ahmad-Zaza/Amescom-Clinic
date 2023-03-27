@extends('layouts.DoctorApp')

@section('title')
    {{ 'Medical Analyses' }}
@endsection

@section('content')
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
                    <th scope="col">Patient</th>
                    <th scope="col">@sortablelink('created_at', 'Date')</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicalAnalyses as $medicalAnalysis)
                    <tr>
                        <th scope="row">{{ $medicalAnalysis->id }}</th>
                        <td>{{ $medicalAnalysis->patient->firstName . ' ' . $medicalAnalysis->patient->lastName }}</td>
                        <td>{{ $medicalAnalysis->created_at }}</td>

                        <td> <a
                                href="{{ route('doctor.patient.medicalAnalysis', ['medicalAnalysis_id' => Crypt::encrypt($medicalAnalysis->id)]) }}">
                                <i class="fa fa-eye" style="font-size:25px; color:#4768DB;"> </i> </a> </td>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="d-flex justify-content-center">
        {{-- {!! $visits->links() !!} --}}
        {!! $medicalAnalyses->appends(\Request::except('page'))->render() !!}
    </div>
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $medicalAnalyses->url(1) !!}&per_page=" + this.value;
        };
    </script>
@endsection
