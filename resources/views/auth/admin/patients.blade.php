@extends('layouts.AdminApp')

  @section('title')
    {{ "Patients" }}
  @endsection


@section('content')
    <h1 class="text-center">
        Welcome to patients page
    </h1>

    <form>
    <select class="form-control" id="pagination" style="width: 100px">
        <option value="5" @if($per_page == 5) selected @endif >5</option>
        <option value="10" @if($per_page == 10) selected @endif >10</option>
        <option value="25" @if($per_page == 25) selected @endif >25</option>
    </select>
</form>

    <div class="table-responsive-md" style="margin-top: 30px">
        <table class="table">
            <caption>List of users</caption>
            <thead>
            <tr>
                <th scope="col">@sortablelink('firstName' , 'Name')</th>
                <th scope="col">@sortablelink('bloodSympol', 'Blood Sympol')</th>
                <th scope="col">@sortablelink('phoneNumber', 'Phone Number')</th>
                <th scope="col">@sortablelink('gender', 'Gender')</th>
                <th scope="col">@sortablelink('nationaltyID', 'Nationalty ID')</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
            <tr>
                <th scope="row">{{$patient->firstName . ' ' . $patient->lastName}}</th>
                <td>{{$patient->bloodSympol}}</td>
                <td>{{$patient->phoneNumber}}</td>
                <td>{{$patient->gender}}</td>
                <td>{{$patient->nationaltyID}}</td>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{--  {!! $visits->links() !!}  --}}
        {!! $patients->appends(\Request::except('page'))->render() !!}
    </div>
    <script>
    document.getElementById('pagination').onchange = function() {
        window.location = "{!! $patients->url(1) !!}&per_page=" + this.value;
    };
</script>
@endsection
