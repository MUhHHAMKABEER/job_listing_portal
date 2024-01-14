@extends('layout.main')

@section('title', 'Employer Details')

@section('content')
    <div class="row">
        <div class="col-6">
            <h1 class="h3 mb-3">Details</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('employers') }}" class="btn btn-outline-primary">Back to Listings</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div id="picture-section">
                            @if ($employer->picture)
                                <img src="{{ asset('template/img/employerphotos/' . $employer->picture) }}"
                                    alt="Placeholder picture" class="img-fluid rounded-circle mb-2" width="200"
                                    height="200" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $employer->name }}"
                                    alt="Placeholder picture" class="img-fluid rounded-circle mb-2" width="200"
                                    height="200" />
                            @endif
                        </div>
                        <h5 class="card-title"></h5>
                        <p class="card-text"><strong>Name:</strong> {{ $employer->name }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $employer->email }}</p>
                        {{-- <p class="card-text"><strong>Password:</strong> {{ $employer->password }}</p> --}}


                        <div>
                            <a href="{{ route('edit', $employer) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('deleteemployer',  ['id' => $employer->id]) }}" method="post" class="d-inline">
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
