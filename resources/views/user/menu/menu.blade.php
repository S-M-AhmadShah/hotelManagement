@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Order Your Meals</h1>
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card">
                <img src="img/Breakfast.webp" class="card-img-top" alt="Breakfast">
                <div class="card-body text-center">
                    <h5 class="card-title">Breakfast</h5>
                    <a href="{{ route('menu.breakfast') }}" class="btn btn-primary">View Breakfast Menu</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="img/lunch.webp" class="card-img-top" alt="Lunch">
                <div class="card-body text-center">
                    <h5 class="card-title">Lunch</h5>
                    <a href="{{ route('menu.lunch') }}" class="btn btn-primary">View Lunch Menu</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="img/Dinner.jpg" height="337" class="card-img-top" alt="Dinner">
                <div class="card-body text-center">
                    <h5 class="card-title">Dinner</h5>
                    <a href="{{ route('menu.dinner') }}" class="btn btn-primary">View Dinner Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 25px;
        padding: 10px 20px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    .text-center h1 {
        font-family: 'Roboto', sans-serif;
        color: #343a40;
        font-weight: bold;
    }

    .container {
        padding-bottom: 30px;
    }

    @media (max-width: 768px) {
        .card {
            margin-bottom: 20px;
        }
    }
</style>
