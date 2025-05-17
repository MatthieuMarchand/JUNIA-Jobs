@extends('layouts.app')

@section('title', 'Demande d\'inscription envoyée')

@section('content')
    <div class="container row">
        @foreach($requests as $request)
            <div class="col-12 col-sm-6 col-md-4 card shadow p-4">
                <h2 class="mb-4">{{ $request->company_name }}</h2>

                <p>{{ $request->message }}</p>

                <form action="{{ route('admin.companies.requests.approve', $request->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success mb-2">Accepter</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
