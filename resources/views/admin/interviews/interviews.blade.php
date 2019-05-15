@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('All interviews') }}</title>
@endsection

@section('custom-css')
<!-- Custom styles for this page -->
<link href="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('All interviews') }}</h1>

@include('admin.layout.partials.messages')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="users" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Interview</th>
                        <th>Interview time</th>
                        <th>Student</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($interviews) > 0)
                        @foreach($interviews as $value)
                            <tr>
                                <td>{{ $value->admission->name }}</td>
                                <td>{{ $value->time }}:00h  {{ $value->date }}</td>
                                <td>{{ $value->user->firstName }} {{ $value->user->lastName }}</td>
                                <td>{{ $value->user->phone }}</td>
                                <td>{{ $value->user->email }}</td>
                                <td class="text-center">
                                    <form action="{{ route('interviews.changestatus', ['interview' => $value->id]) }}" method="POST">
                                        @csrf
                                        <select name="status" id="status" onchange="this.form.submit()">
                                            <option value="0" {{ ($value->status == '0') ? 'selected':'' }}>Pending</option>
                                            <option value="1" {{ ($value->status == '1') ? 'selected':'' }}>Confirmed</option>
                                            <option value="2" {{ ($value->status == '2') ? 'selected':'' }}>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<!-- Page level plugins -->
<script src="/admin/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#users').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": [3] },
            { "searchable": false, "targets": [3] }
        ]
  });
});


$(function () {
  $('.tooltip-custom').tooltip()
})

</script>

@endsection

