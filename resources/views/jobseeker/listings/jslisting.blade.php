{{-- admin.listings.blade.php --}}
@extends('layout.jobseeker')

@section('title', 'Listings')

@section('content')
    <div class="row">
        <div class="col-6">
            <h1 class="h3 mb-3"> Listings</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('partials.alerts')
                    {{-- @if ($listings && count($listings) > 0) --}}
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Vacancies</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($listings as $listing)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $listing->company_name }}</td>
                                    <td>{{ $listing->email }}</td>
                                    <td>{{ $listing->contact_no }}</td>
                                    <td>{{ $listing->vacancies_available }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- @else
                        <div class="alert alert-info mb-0">No record found!</div>
                     @endif --}}
                </div>
            </div>
        </div>
    </div>

    @include('partials.modals')

@endsection
