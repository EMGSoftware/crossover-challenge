@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="title">
                        Report Details
                    </span>
                </div>
                <div class="panel-body">
                    <div class="row">
						<div class="col-sm-3 form-group">
							{{ Form::label('name', 'Name:', $attibutes = ['class' => 'control-label']) }}
							{{ Form::text('name', $value = $report->patient->name, $attributes = ["class" => "form-control", "readonly" => "readonly"]) }}
						</div>
						<div class="col-sm-9 form-group">
							{{ Form::label('notes', 'Notes:', $attibutes = ['class' => 'control-label']) }}
							{{ Form::text('notes', $value = $report->notes, $attributes = ["class" => "form-control", "readonly" => "readonly"]) }}
						</div>
					</div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th class="col-sm-3">Test</th>
                            <th class="col-sm-3">Result</th>
                            <th class="col-sm-6">Notes</th>
                        </thead>
                        <tbody>
                        @forelse ($report->tests as $test)
                            <tr>
                                <td>{{ $test->name }}</td>
                                <td>{{ empty ($test->pivot->result) ? "N/A" : $test->pivot->result }}</td>
        						<td>{{ $test->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No tests yet registered</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <a class="btn btn-small btn-primary pull-right" href="{{ route('reports.index') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
