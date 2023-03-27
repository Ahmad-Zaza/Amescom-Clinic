@extends('layouts.TechniciansApp')

@section('title')
    {{ 'Department Requests' }}
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
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        @if ($visit->status == 'new')
                            <tr>
                                <th scope="row">{{ $visit->id }}</th>
                                <td>{{ $visit->patient->firstName . ' ' . $visit->patient->lastName }}</td>
                                <td>{{ $visit->created_at }}</td>
                                <td>
                                    <span style="font-weight: bold;color: #4768DB;font-size:14px;">New</span>
                                </td>

                                <td>
                                    @php
                                        if (Auth::guard('medical_person')->user()->type === 'analysis') {
                                            $url = 'laboratory-technician.receipt-patient';
                                        } elseif (Auth::guard('medical_person')->user()->type === 'radiograph') {
                                            $url = 'radiograph-technician.receipt-patient';
                                        }
                                    @endphp
                                    <form action="{{ route($url) }}" method="POST">
                                        @csrf
                                        {{-- <input id="patient_id" name="patient_id" type="hidden" value="{{$visit->patient->id}}"> --}}
                                        <input id="visiting_id" name="visiting_id" type="hidden"
                                            value="{{ $visit->id }}">
                                        {{-- <input id="labTech_id" name="labTech_id" type="hidden" value="{{auth()->guard('medical_person')->user()->id}}"> --}}
                                        <button type="submit" id="Submitbutton" class="btn btn-success"
                                            style="color: #ffffff">Receipt</button>
                                    </form>
                                </td>



                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <h1 class="text-center">No Requests Founded !! </h1>
    @endif

    <div class="d-flex justify-content-center">
        {{-- {!! $visits->links() !!} --}}
        {!! $visits->appends(\Request::except('page'))->render() !!}
    </div>
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $visits->url(1) !!}&per_page=" + this.value;
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
