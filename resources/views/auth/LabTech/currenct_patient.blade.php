@extends('layouts.TechniciansApp')

@section('title')
    {{ 'Current Patients' }}
@endsection

@section('content')

    @if ($visits->count())
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
                    @foreach ($visits as $visit)
                        <tr>
                            <th scope="row">{{ $visit->id }}</th>
                            <td>{{ $visit->patient->firstName . ' ' . $visit->patient->lastName }}</td>
                            <td>{{ $visit->created_at }}</td>
                            <td>
                                @php
                                    if (Auth::guard('medical_person')->user()->type === 'analysis') {
                                        $url = 'laboratory-technician.create-medcialAnalysis';
                                        $text = 'Medical';
                                    } elseif (Auth::guard('medical_person')->user()->type === 'radiograph') {
                                        $url = 'radiograph-technician.create-radiographAnalysis';
                                        $text = 'Radiograph';
                                    }
                                @endphp
                                <a href="{{ route($url, ['visiting_id' => Crypt::encrypt($visit->id)]) }}">
                                    <button class="btn btn-secondary">
                                        Add {{ $text }} Analysis
                                        {{-- <i class="fas fa-file-prescription" style="color: #ffffff"></i> --}}
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a
                                    href="{{ route('laboratory-technician.close-medicalAnalysis', ['visit_id' => Crypt::encrypt($visit->id)]) }}">
                                    <button class="btn btn-danger">
                                        Logout Patient <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </td>

                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-center">
            {{-- {!! $visits->links() !!} --}}
            {!! $visits->appends(\Request::except('page'))->render() !!}
        </div>
    @else
        <h1 class="text-center">The Clinic is empty </h1>
    @endif
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $visits->url(1) !!}&per_page=" + this.value;
        };
    </script>

@endsection
