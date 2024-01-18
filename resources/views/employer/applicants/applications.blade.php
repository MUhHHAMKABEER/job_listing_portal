{{-- employer.applicants.applications.blade.php --}}
@extends('layout.employer_main')

@section('title', 'Applications')

@section('content')
    <div class="row">
        <div class="col-6">
            <h1 class="h3 mb-3">Applications</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($applications) > 0)
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No.</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->user->name }}</td>
                                    <td>{{ $application->user->email }}</td>
                                    <td>{{ $application->user->contact_no }}</td>
                                    <td>{{ $application->listing->company_name }}</td>
                                    <!-- Add any other fields you want to display -->
                                    <td>
                                        {{-- Add any action buttons here --}}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info mb-0">No applications found!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('partials.modals')

@endsection
