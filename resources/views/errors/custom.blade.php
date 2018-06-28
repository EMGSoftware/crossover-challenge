@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
            <img src="{{ url('img/oops.png') }}">
        </div>
    </div>
    <div class="row">
		<div class="col-md-12 text-center">
            <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
        </div>
    </div>
</div>
@stop
