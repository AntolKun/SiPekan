<?php

namespace App\Http\Controllers;

use App\Models\MortalityRecord;
use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MortalityController extends Controller
{
  public function index(Request $request)
  {
    $query = MortalityRecord::with('fish');

    // Filter by date range
    if ($request->has('start_date') && $request->has('end_date')) {
      $query->whereBetween('recorded_date', [
        $request->get('start_date'),
        $request->get('end_date')
      ]);
    }

    $records = $query->orderBy('recorded_date', 'desc')->paginate(20);

    // Statistics
    $totalMortality = MortalityRecord::whereMonth('recorded_date', now()->month)
      ->whereYear('recorded_date', now()->year)
      ->sum('quantity');

    $totalLoss = MortalityRecord::whereMonth('recorded_date', now()->month)
      ->whereYear('recorded_date', now()->year)
      ->sum('loss_amount');

    $totalStock = Fish::sum('stock');
    $mortalityRate = $totalStock > 0 ? ($totalMortality / $totalStock) * 100 : 0;

    return view('mortality.index', compact('records', 'totalMortality', 'totalLoss', 'mortalityRate'));
  }

  public function create()
  {
    $fish = Fish::where('stock', '>', 0)->orderBy('name')->get();
    $reasons = MortalityRecord::$reasons;

    return view('mortality.create', compact('fish', 'reasons'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'fish_id' => 'required|exists:fish,id',
      'quantity' => 'required|integer|min:1',
      'reason' => 'nullable|string',
      'recorded_date' => 'required|date',
    ]);

    DB::beginTransaction();
    try {
      $fish = Fish::findOrFail($validated['fish_id']);

      // Check if stock is sufficient
      if ($fish->stock < $validated['quantity']) {
        throw new \Exception("Stok tidak mencukupi! Stok saat ini: {$fish->stock} ekor");
      }

      // Calculate loss amount
      $lossAmount = $fish->purchase_price * $validated['quantity'];

      // Create mortality record (stock will be updated automatically via boot method)
      MortalityRecord::create([
        'fish_id' => $validated['fish_id'],
        'quantity' => $validated['quantity'],
        'reason' => $validated['reason'],
        'loss_amount' => $lossAmount,
        'recorded_date' => $validated['recorded_date'],
      ]);

      DB::commit();

      return redirect()->route('mortality.index')
        ->with('success', 'Catatan kematian ikan berhasil disimpan!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function show(MortalityRecord $mortality)
  {
    $mortality->load('fish');
    return view('mortality.show', compact('mortality'));
  }

  public function edit(MortalityRecord $mortality)
  {
    $fish = Fish::orderBy('name')->get();
    $reasons = MortalityRecord::$reasons;

    return view('mortality.edit', compact('mortality', 'fish', 'reasons'));
  }

  public function update(Request $request, MortalityRecord $mortality)
  {
    $validated = $request->validate([
      'fish_id' => 'required|exists:fish,id',
      'quantity' => 'required|integer|min:1',
      'reason' => 'nullable|string',
      'recorded_date' => 'required|date',
    ]);

    DB::beginTransaction();
    try {
      $oldQuantity = $mortality->quantity;
      $oldFishId = $mortality->fish_id;

      // Kembalikan stok lama
      if ($oldFishId) {
        $oldFish = Fish::find($oldFishId);
        if ($oldFish) {
          $oldFish->increment('stock', $oldQuantity);
        }
      }

      // Calculate new loss amount
      $fish = Fish::findOrFail($validated['fish_id']);
      $lossAmount = $fish->purchase_price * $validated['quantity'];

      // Update mortality record
      $mortality->update([
        'fish_id' => $validated['fish_id'],
        'quantity' => $validated['quantity'],
        'reason' => $validated['reason'],
        'loss_amount' => $lossAmount,
        'recorded_date' => $validated['recorded_date'],
      ]);

      // Update new stock
      $fish->decrement('stock', $validated['quantity']);

      DB::commit();

      return redirect()->route('mortality.index')
        ->with('success', 'Catatan kematian berhasil diupdate!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function destroy(MortalityRecord $mortality)
  {
    DB::beginTransaction();
    try {
      // Kembalikan stok
      $fish = $mortality->fish;
      if ($fish) {
        $fish->increment('stock', $mortality->quantity);
      }

      $mortality->delete();

      DB::commit();

      return redirect()->route('mortality.index')
        ->with('success', 'Catatan kematian berhasil dihapus!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withErrors(['error' => $e->getMessage()]);
    }
  }
}
