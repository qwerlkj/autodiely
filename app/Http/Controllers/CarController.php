<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return view('cars', ['cars'=>Car::with('parts')->allowedSearch('name', 'registration_number')->get()]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'string|nullable',
            'is_registered' => 'boolean',
        ]);
        return Car::create([
            'name' => $request->input('name'),
            'registration_number' => $request->input('registration_number'),
            'is_registered' => $request->input('is_registered'),
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'string|nullable',
            'is_registered' => 'boolean',
        ]);
        return Car::find($id)->update([
            'name' => $request->input('name'),
            'registration_number' => $request->input('registration_number'),
            'is_registered' => $request->input('is_registered'),
        ]);
    }

    public function destroy(string $id)
    {
        return Car::destroy($id);
    }
}
