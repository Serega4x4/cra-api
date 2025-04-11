<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        return Car::all();
    }

    public function store(CarStoreRequest $request)
    {
        return Car::create($request->validated());
    }

    public function show(Car $car)
    {
        return $car;
    }

    public function update(CarUpdateRequest $request, Car $car)
    {
        $car->update($request->validated());
        return $car;
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return response()->noContent();
    }

    public function getAvailableCars()
    {
        $cars = Car::with([
            'configurations' => function ($query) {
                $query->with('prices');
            },
            'configurations.prices',
        ])->get();

        return response()->json($cars);
    }
}
