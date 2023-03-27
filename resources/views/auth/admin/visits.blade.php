@extends('layouts.AdminApp')

@section('title')
    {{ 'Visits' }}
@endsection


@section('content')


    <form style="margin-top: 20px">
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
                    <th scope="col">@sortablelink('department.name', 'Department')</th>
                    <th scope="col">@sortablelink('created_at', 'Date')</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visits as $visit)
                    <tr>
                        <th scope="row">{{ $visit->id }}</th>
                        <td>{{ $visit->patient->firstName . ' ' . $visit->patient->lastName }}</td>
                        <td>{{ $visit->department->name }}</td>
                        <td>{{ $visit->created_at }}</td>
                        <td>
                            @if ($visit->status == 'new')
                                <span style="font-weight: bold;color: #4768DB;font-size:14px;">New</span>
                            @endif
                            @if ($visit->status == 'pending')
                                <span style="font-weight: bold;color: #FFC107;font-size:14px;">Pending</span>
                            @endif
                            @if ($visit->status == 'done')
                                <span style="font-weight: bold;color: #24B290;font-size:14px;">Done</span>
                            @endif
                        </td>
                        <td> <a href=""> <i class="fa fa-eye" style="font-size:25px; color:#4768DB;"> </i> </a> </td>

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
    </script>
@endsection
