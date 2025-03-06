<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::all();
        return view('admin.meals.index', compact('meals'));
    }

    public function create()
    {
        return view('admin.meals.create');
    }

    public function store(Request $request)
    {
        // dd($request->file('image'));
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'meal_type' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $meal = new Meal();
        $meal->name = $validated['name'];
        $meal->meal_type = $validated['meal_type'];
        $meal->description = $validated['description'] ?? null;

        if ($request->hasFile('image')) {
            $meal->image = $request->file('image')->store('meals', 'public');
        }

        $meal->price = $validated['price'];

        $meal->save();

        return redirect()->route('admin.meals.index')->with('success', 'Meal added successfully.');
    }


    public function edit(Meal $meal)
    {
        return view('admin.meals.edit', compact('meal'));
    }

    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'meal_type' => 'required|in:Breakfast,Lunch,Dinner',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($meal->image) {
                Storage::disk('public')->delete($meal->image);
            }
            $data['image'] = $request->file('image')->store('meals', 'public');
        }

        $meal->update($data);

        return redirect()->route('admin.meals.index')->with('success', 'Meal updated successfully.');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();
        return redirect()->route('admin.meals.index')->with('success', 'Meal deleted successfully.');
    }
}
