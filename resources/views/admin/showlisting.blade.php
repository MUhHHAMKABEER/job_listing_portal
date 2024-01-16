@extends('layout.main')

@section('title', 'Employers Details')

@section('content')
    <div class="row">
        <div class="col-6">
            <h1 class="h3 mb-3">{{ $listing->company_name }} Details</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('listings', $listing) }}" class="btn btn-outline-primary">Back to Listings</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div id="picture-section">
                            @if ($listing->picture)
                                <img src="{{ asset('template/img/company_photos/' . $listing->picture) }}"
                                    alt="Placeholder picture" class="img-fluid rounded-circle mb-2" width="200"
                                    height="200" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $listing->company_name }}"
                                    alt="Placeholder picture" class="img-fluid rounded-circle mb-2" width="200"
                                    height="200" />
                            @endif
                        </div>
                        <h5 class="card-title">{{ $listing->company_name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $listing->email }}</p>
                        <p class="card-text"><strong>Contact No.:</strong> {{ $listing->contact_no }}</p>
                        <p class="card-text"><strong>Company:</strong> {{ $listing->company_name }}</p>
                        <p class="card-text"><strong>Vacancies:</strong> {{ $listing->vacancies_available }}</p>
                        <p class="card-text"><strong>Category:</strong> {{ $listing->job_category }}</p>
                        <p class="card-text"><strong>Salary</strong> {{ $listing->salary }}</p>
                        <p class="card-text"><strong>Description</strong> {{ $listing->description }}</p>
                        <p class="card-text"><strong>Address</strong> {{ $listing->address }}</p>

                        <div>
                            <a href="{{ route('editlistings', $listing) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('deletelisting', $listing) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                        <!-- Add other details as needed -->

                    </div>
                </div>
            </div>
        </div>
    @endsection
