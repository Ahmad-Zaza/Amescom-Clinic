@extends('layouts.TechniciansApp')

@section('title')
    {{ 'Search' }}
@endsection

@section('content')

    @if ($patients->count())
        <div class="row">
            <div class="col md-12">
                <form class="search-form" action="{{ route('laboratory-technician.patient.medicalAnalyses-search') }}"
                    method="GET">
                    <div class="form-row">
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="search" required />
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-info search-button" id="Submitbutton" type="submit">Search</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>


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
                        {{-- <th scope="col">@sortablelink('created_at', 'Date')</th> --}}
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <th scope="row">{{ $patient->id }}</th>
                            <td>{{ $patient->firstName . ' ' . $patient->lastName }}</td>
                            {{-- <td>{{ $patient->created_at }}</td> --}}
                            <td>
                                <a
                                    href="{{ route('radiograph-technician.patient-radiographAnalyses', ['patient_id' => Crypt::encrypt($patient->id)]) }}">
                                    <i class="fa fa-eye" style="font-size:25px; color:#4768DB;"> </i> </a>
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-center">
            {{-- {!! $visits->links() !!} --}}
            {!! $patients->appends(\Request::except('page'))->render() !!}
        </div>
    @else
        <h1 class="text-center">
            No such results !!
        </h1>
        <a href="{{ route('laboratory-technician.my-medicalAnalyses') }}">
            <button class="btn btn-primary">Return Back</button>
        </a>
    @endif
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $patients->url(1) !!}&per_page=" + this.value;
        };
    </script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function() {
            $("#Submitbutton").on('dblclick', function(event) {
                event.preventDefault();
                var el = $(this);
                el.prop('disabled', true);
                setTimeout(function() {
                    el.prop('disabled', false);
                }, 3000);
            });

            $("form").submit(function() {
                $(this).submit(function() {
                    return false;
                });
                return true;
            });

        });
    </script>
@endsection
