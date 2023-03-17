<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        return view('parts', [
            'parts'=>Part::with('car')->allowedSearch('name', 'serialnumber')->get(),
            'cars'=>Car::all()
        ]);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serialnumber' => 'required|string|max:255',
            'car_id' => 'integer|nullable',
        ]);
        return Part::create([
            'name' => $request->input('name'),
            'serialnumber' => $request->input('serialnumber'),
            'car_id' => $request->input('car_id'),
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
            'serialnumber' => 'required|string|max:255',
            'car_id' => 'integer|nullable',
        ]);

        return Part::find($id)->update([
            'name' => $request->input('name'),
            'serialnumber' => $request->input('serialnumber'),
            'car_id' => $request->input('car_id'),
        ]);
    }

    public function destroy(string $id)
    {
        return Part::destroy($id);
    }
}
