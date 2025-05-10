@extends('layouts.Nav')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cards
                        <br>
                        <a href="{{ route('cards.create') }}" class="btn btn-primary float-right">Add Card</a>



                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Card Number</th>
                                    <th>Expiry Date</th>
                                    <th>CVC</th>
                                    <th>Cardholder</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cards as $card)
                                    <tr>
                                        <td>{{ $card->Type }}</td>
                                        <td>{{ $card->CardNumber }}</td>
                                        <td>{{ $card->ExpiryDate }}</td>
                                        <td>{{ $card->CVC }}</td>
                                        <td>{{ $card->Cardholder }}</td>
                                        <td>{{ $card->Status }}</td>
                                        <td>
                                            <a href="{{ route('cards.show', $card->id) }}" class="btn btn-primary btn-sm">View</a>
                                            <a href="{{ route('cards.edit', $card->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                                            <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this card?')">Delete</button>
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
