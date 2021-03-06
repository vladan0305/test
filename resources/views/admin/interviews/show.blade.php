@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('My interviews') }}</title>
@endsection

@section('custom-css')
<!-- Custom styles for this page -->
<link href="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('All scheduled interviews') }}</h1>

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
                        <th>Interview type</th>
                        <th>Interview date</th>
                        <th>Interview time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($interviews) > 0)
                        @foreach($interviews as $value)
                            <tr>
                                <td>{{ $value->admission->name }}</td>
                                <td>{{ $value->date }}</td>
                                <td>{{ $value->time }}:00h</td>
                                <td>
                                    @if($value->status == 0)
                                        Pending
                                    @elseif($value->status == 1)
                                        Confirmed
                                    @else
                                        Rejected
                                    @endif
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
            { "orderable": false, "targets": [7] },
            { "searchable": false, "targets": [7] }
        ]
  });
});

$(function () {
  $('.tooltip-custom').tooltip()
})

</script>

@endsection

