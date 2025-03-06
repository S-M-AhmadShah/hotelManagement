@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="text-center mb-5">
        <h1 class="display-4">🍳 Breakfast Menu</h1>
        <p class="lead">Start your day with our delicious and energizing breakfast options!</p>
    </div>

    <div class="row">
        <!-- Example Breakfast Item 1 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="img/pancakes.jpg" class="card-img-top" alt="Pancakes">
                <div class="card-body text-center">
                    <h5 class="card-title">Fluffy Pancakes</h5>
                    <p class="card-text">Golden, fluffy pancakes served with maple syrup and fresh berries.</p>
                    <button class="btn btn-primary">Order Now</button>
                </div>
            </div>
        </div>

        <!-- Example Breakfast Item 2 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="img/omelette.jpg" class="card-img-top" alt="Omelette">
                <div class="card-body text-center">
                    <h5 class="card-title">Classic Omelette</h5>
                    <p class="card-text">Three-egg omelette filled with cheese, ham, and fresh veggies.</p>
                    <button class="btn btn-primary">Order Now</button>
                </div>
            </div>
        </div>

        <!-- Example Breakfast Item 3 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="img/fruit_bowl.jpg" class="card-img-top" alt="Fruit Bowl">
                <div class="card-body text-center">
                    <h5 class="card-title">Fresh Fruit Bowl</h5>
                    <p class="card-text">A mix of seasonal fruits for a refreshing start to your day.</p>
                    <button class="btn btn-primary">Order Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
