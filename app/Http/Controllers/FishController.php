<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FishController extends Controller
{
  public function index()
  {
    $fish = Fish::orderBy('name', 'asc')->get();
    return view('fish.index', compact('fish'));
  }

  public function create()
  {
    return view('fish.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'type' => 'nullable|string|max:255',
      'size' => 'nullable|string|max:255',
      'color' => 'nullable|string|max:255',
      'stock' => 'required|integer|min:0',
      'purchase_price' => 'required|numeric|min:0',
      'selling_price' => 'required|numeric|min:0',
      'tank_location' => 'nullable|string|max:255',
      'health_status' => 'required|in:sehat,sakit,karantina',
      'minimum_stock' => 'required|integer|min:0',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    if ($request->hasFile('photo')) {
      $validated['photo'] = $request->file('photo')->store('fish-photos', 'public');
    }

    Fish::create($validated);

    return redirect()->route('fish.index')
      ->with('success', 'Data ikan berhasil ditambahkan!');
  }

  public function show(Fish $fish)
  {
    return view('fish.show', compact('fish'));
  }

  public function edit(Fish $fish)
  {
    return view('fish.edit', compact('fish'));
  }

  public function update(Request $request, Fish $fish)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'type' => 'nullable|string|max:255',
      'size' => 'nullable|string|max:255',
      'color' => 'nullable|string|max:255',
      'stock' => 'required|integer|min:0',
      'purchase_price' => 'required|numeric|min:0',
      'selling_price' => 'required|numeric|min:0',
      'tank_location' => 'nullable|string|max:255',
      'health_status' => 'required|in:sehat,sakit,karantina',
      'minimum_stock' => 'required|integer|min:0',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    if ($request->hasFile('photo')) {
      // Delete old photo
      if ($fish->photo) {
        Storage::disk('public')->delete($fish->photo);
      }
      $validated['photo'] = $request->file('photo')->store('fish-photos', 'public');
    }

    $fish->update($validated);

    return redirect()->route('fish.index')
      ->with('success', 'Data ikan berhasil diupdate!');
  }

  public function destroy(Fish $fish)
  {
    if ($fish->photo) {
      Storage::disk('public')->delete($fish->photo);
    }

    $fish->delete();

    return redirect()->route('fish.index')
      ->with('success', 'Data ikan berhasil dihapus!');
  }
}
