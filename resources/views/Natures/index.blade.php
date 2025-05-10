@extends('layouts.Nav')

@section('content')
    <div class="container">
        <h1>Natures</h1>
                            <a href="{{ route('natures.create') }}" class="btn btn-primary">Create nature Category</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Classification</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($natures as $nature)
                    <tr>
                        <td>{{ $nature->id }}</td>
                        <td>{{ $nature->Nature }}</td>
                        <td>{{ $nature->Classification }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
