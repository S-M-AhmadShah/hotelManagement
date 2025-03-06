@extends('layouts.app')

@section('content')

<h1>Meal Menu</h1>
<table class="table">
    <thead>
        <a href="{{ route('admin.meals.create') }}" class="btn btn-primary">Add Meal</a>
        <tr>
            <th>#</th>
            <th>Meal Type</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($meals as $meal)
            <tr>
                <td>{{ $meal->id }}</td>
                <td>{{ $meal->meal_type }}</td>
                <td>{{ $meal->name }}</td>
                <td>{{ $meal->description }}</td>
                <td>${{ number_format($meal->price, 2) }}</td>
                <td>
                    @if($meal->image)
                        <img src="{{ asset('storage/' . $meal->image) }}" alt="Meal Image" style="max-height: 50px;">
                    @else
                        No Image
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.meals.edit', $meal) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.meals.destroy', $meal) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>


@endsection
