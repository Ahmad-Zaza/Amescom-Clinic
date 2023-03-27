@extends('layouts.ReceptionistApp')

@section('title')
    {{ 'Patient' }}
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
                    <th scope="col">@sortablelink('firstName', 'Name')</th>
                    <th scope="col">@sortablelink('bloodSympol')</th>
                    <th scope="col">@sortablelink('phoneNumber')</th>
                    <th scope="col">@sortablelink('gender')</th>
                    <th scope="col">@sortablelink('nationaltyID')</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <th>{{ $patient->firstName . ' ' . $patient->lastName }}</th>
                        <td>{{ $patient->bloodSympol }}</td>
                        <td>{{ $patient->phoneNumber }}</td>
                        <td>{{ $patient->gender }}</td>
                        <td>{{ $patient->nationaltyID }}</td>
                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#transfer{{ $patient->id }}">Transfer</button>
                            @php
                                $patient_id = Crypt::encrypt($patient->id);
                            @endphp
                            <form action="{{ route('receptionist.transfer-patient', ['patient_id' => $patient_id]) }}"
                                method="POST">
                                @csrf
                                <!-- Modal -->
                                <div id="transfer{{ $patient->id }}" class="modal fade" role="dialog">
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
                                                <input id="receptionist_id" name="receptionist_id" type="hidden"
                                                    value="{{ Auth::id() }}">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Transfer</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </td>
                        <td>
                            <a href="">
                                <i class="fa fa-edit" style="font-size:25px; color:#FFC107; margin-top:2px"> </i>
                            </a>
                        </td>

                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {!! $patients->links() !!}
    </div>
    <script>
        document.getElementById('pagination').onchange = function() {
            window.location = "{!! $patients->url(1) !!}&per_page=" + this.value;
        };
    </script>

@endsection
