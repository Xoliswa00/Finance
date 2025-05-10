@extends('layouts.Nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Nature') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        <label for="category">Category Name:</label>
                        <input type="text" name="category" value="{{ $category->category }}" required>
                        @error('category')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <br><br>
                        <label for="Nature">Category Nature:</label>
                        <select name="Nature" required>
                            <option value="">-- Select Category Nature --</option>
                            @foreach($natures as $nature)
                            <option value="{{ $nature->Nature }}" @if($category->Nature == $nature->Nature) selected
                                @endif>{{ $nature->Nature }}</option>
                            @endforeach
                        </select>
                        @error('Nature')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <br><br>
                        <input type="submit" value="Update Category">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection