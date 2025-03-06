@extends('layouts.app')

@section('content')
<h1>{{ isset($meal) ? 'Edit Meal' : 'Add Meal' }}</h1>
<form action="{{ isset($meal) ? route('admin.meals.update', $meal) : route('admin.meals.store') }}" method="POST">
    @csrf
    @if(isset($meal))
        @method('PUT')
    @endif
    <div class="form-group">
        <label for="meal_type">Meal Type</label>
        <select name="meal_type" id="meal_type" class="form-control">
            <option value="Breakfast" {{ (isset($meal) && $meal->meal_type == 'Breakfast') ? 'selected' : '' }}>Breakfast</option>
            <option value="Lunch" {{ (isset($meal) && $meal->meal_type == 'Lunch') ? 'selected' : '' }}>Lunch</option>
            <option value="Dinner" {{ (isset($meal) && $meal->meal_type == 'Dinner') ? 'selected' : '' }}>Dinner</option>
        </select>
    </div>
    <div class="form-group">
        <label for="name">Meal Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $meal->name ?? '' }}" required>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" step="0.01" name="price" id="price" class="form-control"
               value="{{ $meal->price ?? '' }}" required>
    </div>

    <div class="form-group">
        <label for="image">Meal Image</label>
        <input type="file" name="image" id="image" class="form-control">
        @if(isset($meal) && $meal->image)
            <img src="{{ asset('storage/' . $meal->image) }}" alt="Meal Image"
                 style="max-height: 150px; margin-top: 10px;">
        @endif
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ $meal->description ?? '' }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">{{ isset($meal) ? 'Update' : 'Add' }}</button>
</form>
@endsection
