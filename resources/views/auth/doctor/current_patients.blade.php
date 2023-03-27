@extends('layouts.DoctorApp')

@section('title')
    {{ 'Current Patients' }}
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
                    <th scope="col">Patient</th>
                    <th scope="col">@sortablelink('created_at', 'Date')</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visits as $visit)
                    <tr>
                        <td>{{ $visit->patient->firstName . ' ' . $visit->patient->lastName }}</td>
                        <td>{{ $visit->created_at }}</td>
                        <td>
                            @php

                            @endphp
                            <a
                                href="{{ route('doctor.create-prescription', ['visiting_id' => Crypt::encrypt($visit->id)]) }}">
                                <button class="btn btn-secondary">
                                    Add Prescription
                                    {{-- <i class="fas fa-file-prescription" style="color: #ffffff"></i> --}}
                                </button>
                            </a>
                        </td>
                        <td>
                            <a href="">
                                <button class="btn btn-danger">
                                    Logout Patient <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </button>
                            </a>
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#transfer{{ $visit->patient->id }}">Transfer</button>
                            <form action="{{ route('doctor.transfer-patient') }}" method="POST">
                                @csrf
                                <!-- Modal -->
                                <div id="transfer{{ $visit->patient->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Modal Header</h4>
                                            </div>
                                            <div class="modal-body">


                                                <label for="department">Choose Department</label>
                                                <select class="form-control" id="department_id" style="width: 200px"
                                                    name="department_id">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                <input id="patient_id" name="patient_id" type="hidden"
                                                    value="{{ $visit->patient->id }}">
                                                <input id="doctor_id" name="doctor_id" type="hidden"
                                                    value="{{ Auth::id() }}">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="Submitbutton" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger"
                                                    data-dismiss="transfer">Transfer</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </td>
                        <td> <a
                                href="{{ route('doctor.patient.medical-history', ['patient_id' => Crypt::encrypt($visit->patient->id)]) }}">
                                <i class="fa fa-eye" style="font-size:25px; color:#4768DB;"> </i> </a>
                        </td>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="d-flex justify-content-center">
        {{-- {!! $visits->links() !!} --}}
        {!! $visits->appends(\Request::except('page'))->render() !!}
    </div>
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $visits->url(1) !!}&per_page=" + this.value;
        };
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
