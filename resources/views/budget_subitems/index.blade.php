@extends('layouts.Nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Budget Subitems Dashboard') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subitems as $subitem)
                            <tr>
                                <th scope="row">{{ $subitem->id }}</th>
                                <td>{{ $subitem->name }}</td>
                                <td>{{ $subitem->description }}</td>
                                <td>{{ $subitem->amount }}</td>
                                <td>{{ $subitem->user->name }}</td>
                                <td>
                                    <a href="{{ route('budget_subitems.edit', $subitem->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('budget_subitems.destroy', $subitem->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
