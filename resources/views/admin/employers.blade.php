{{-- admin.employers.blade.php --}}
@extends('layout.main')

@section('title', 'Employers')

@section('content')
    <div class="row">
        <div class="col-6">
            <h1>Employers</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('create.employer') }}" class="btn btn-outline-primary">Add Employers</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('partials.alerts')
                    @if($employers && count($employers) > 0)
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employers as $employer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $employer->name }}</td>
                                        <td>{{ $employer->email }}</td>
                                        <td>
                                            <a href="{{ route('showemployers', ['id' => $employer->id]) }}" class="btn btn-primary">Show</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info mb-0">No record found!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('partials.modals')

@endsection
