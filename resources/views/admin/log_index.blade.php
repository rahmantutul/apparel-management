@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            Activity Logs
        </h2>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>User</th>
                            <th>Affected Model</th>
                            <th>Changes</th>
                            <th>IP Address</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge badge">
                                    {{ ucfirst($log->description) }}
                                </span>
                            </td>
                            <td>
                                @if($log->causer)
                                <div class="d-flex align-items-center">
                                    <img src="{{ $log->causer->avatar_url }}" width="30" class="rounded-circle mr-2">
                                    {{ $log->causer->name }}
                                </div>
                                @else
                                <em>System</em>
                                @endif
                            </td>
                            <td>
                                {{ class_basename($log->subject_type) }} #{{ $log->subject_id ?? 'N/A' }}
                            </td>
                            <td>
                                @if($log->properties->has('attributes'))
                                <div class="changes">
                                    @foreach($log->properties['attributes'] as $field => $value)
                                        <p>
                                            <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong>
                                            @if(is_null($value))
                                                <span class="text-muted">Not set</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </p>
                                    @endforeach
                                </div>
                                @endif
                            </td>
                            <td>{{ $log->getExtraProperty('ip_address') }}</td>
                            <td>
                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                                <br>
                                <small>({{ $log->created_at->diffForHumans() }})</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush