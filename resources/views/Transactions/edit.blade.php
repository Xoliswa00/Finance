@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Transaction</h1>
        <hr>
        <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description" value="{{ $transaction->Description }}" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" name="amount" value="{{ $transaction->Amount }}" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" name="bill_date" value="{{ $transaction->bill_date }}" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" name="category" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->category }}" @if($category->id == $transaction->Category_id) selected @endif>{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
