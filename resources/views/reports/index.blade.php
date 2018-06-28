@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="title">
                        @if (!Auth::user()->is_patient)
                            Patient's Reports
                        @else
                            Your Reports
                        @endif
                    </span>
                    <span class="pull-right">{{ $reports->links() }}</span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            @if (!Auth::user()->is_patient)
                            <th>Patient</th>
                            @endif
                            <th>Creation Date</th>
                            <th>Updated at</th>
                            <th>Operations</th>
                        </thead>
                        <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                @if (!Auth::user()->is_patient)
                                <td>
                                    {{ $report->patient->name }}
                                </td>
                                @endif
                                <td>
                                    {{ date ('m/d/Y H:i', strtotime ($report->created_at)) }}
                                </td>
                                <td>
                                    {{ date ('m/d/Y H:i', strtotime ($report->updated_at)) }}
                                </td>
                                @if (!Auth::user()->is_patient)
                                <td class="col-md-4">
                                @else
                                <td class="col-md-3">
                                @endif
                                    <a class="btn btn-small btn-info" href="{{ url('reports/'. $report->id) }}" title="View Details">
    									<i class="glyphicon glyphicon-eye-open"></i>
    								</a>
    								<a class="btn btn-small btn-primary" href="{{ url('reports/'.$report->id.'/download_pdf') }}" target="_blank" title="Download PDF">
    									<i class="glyphicon glyphicon-cloud-download"></i>
    								</a>
    								<a class="btn btn-small btn-primary" href="{{ url('reports/'.$report->id.'/send_pdf') }}" target="_blank" title="Send PDF">
    									<i class="glyphicon glyphicon-envelope"></i>
    								</a>
    								@if (!Auth::user()->is_patient)
    								<a class="btn btn-small btn-warning" href="{{ url('reports/'.$report->id.'/edit') }}" title="Edit">
    									<i class="glyphicon glyphicon-pencil"></i>
    								</a>
    								<a class="btn btn-small btn-danger" href="{{ url('reports/' . $report->id) }}" title="Delete" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?">
    								    <i class="glyphicon glyphicon-trash"></i>
    								</a>
    								@endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                @if (!Auth::user()->is_patient)
                                <td colspan="4">No reports found</td>
                                @else
                                <td colspan="3">You don't have any report available</td>
                                @endif
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @if (!Auth::user()->is_patient)
                    <a class="btn btn-success pull-right" href="{{ route('reports.create') }}"><i class="glyphicon glyphicon-plus"></i> Add</a>
                    @endif
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
