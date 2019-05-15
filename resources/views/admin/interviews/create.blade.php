@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Schedule new interview') }}</title>
@endsection

@section('custom-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Schedule new interview') }}</h1>
<div class='row'>
    <div class="offset-lg-2 col-lg-8">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('New interview') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('interviews.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Interview type</label>
                        <select class="form-control" name="admission_id" id="typeId">
                            <option value=''>-- Choose interview type --</option>
                            @foreach($types as $value)
                                <option value='{{ $value->id }}' >{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('admission_id'))
                            <div class='text text-danger'>
                                {{ $errors->first('admission_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group" id="datepicker"> <!-- Date input -->
                        <label class="control-label" for="date">Date</label>
                        <input class="form-control" id="date" name="date" placeholder="DD/MM/YYY" type="text"/>
                        @if($errors->has('date'))
                            <div class='text text-danger'>
                                {{ $errors->first('date') }}
                            </div>
                        @endif
                    </div>
                    <div id="time">
                    </div>
                    <div class="form-group text-right">
                        <button type='submit' class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function(){
            var date_input=$('input[name="date"]'); //our date input has the name "date"
            var options={
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
                daysOfWeekDisabled: [0,6],
                startDate: '-0d',
            };
            date_input.datepicker(options);

            $('#date').change(function () {
                var id = $('#typeId').val();
                $.ajax({
                    url: '{{ route("interviews.ajaxReq") }}',
                    type: 'post',
                    data: {
                        'date': date_input.val(),
                        'id': id,
                        '_token' : $('form [name=_token]').val()
                    },
                    dataType: 'html'
                }).done(function (data) {
                    $('#time').html(data);
                }).fail(function (jqXHR, error, message) {
                    alert(message);
                })
            })
        })

    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
@endsection

