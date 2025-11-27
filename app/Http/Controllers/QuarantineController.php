<?php

namespace App\Http\Controllers;

use App\Models\QuarantineRecord;
use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuarantineController extends Controller
{
  public function index(Request $request)
  {
    $query = QuarantineRecord::with('fish');

    // Filter by status
    if ($request->has('status') && in_array($request->get('status'), ['aktif', 'selesai'])) {
      $query->where('status', $request->get('status'));
    }

    $records = $query->orderBy('start_date', 'desc')->paginate(20);

    // Statistics
    $activeQuarantine = QuarantineRecord::where('status', 'aktif')->count();
    $totalQuarantineFish = QuarantineRecord::where('status', 'aktif')->sum('quantity');

    return view('quarantine.index', compact('records', 'activeQuarantine', 'totalQuarantineFish'));
  }

  public function create()
  {
    $fish = Fish::whereIn('health_status', ['sehat', 'sakit'])
      ->where('stock', '>', 0)
      ->orderBy('name')
      ->get();

    return view('quarantine.create', compact('fish'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'fish_id' => 'required|exists:fish,id',
      'quantity' => 'required|integer|min:1',
      'start_date' => 'required|date',
      'treatment' => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
      $fish = Fish::findOrFail($validated['fish_id']);

      // Check if stock is sufficient
      if ($fish->stock < $validated['quantity']) {
        throw new \Exception("Stok tidak mencukupi! Stok saat ini: {$fish->stock} ekor");
      }

      // Create quarantine record
      QuarantineRecord::create([
        'fish_id' => $validated['fish_id'],
        'quantity' => $validated['quantity'],
        'start_date' => $validated['start_date'],
        'treatment' => $validated['treatment'],
        'status' => 'aktif',
      ]);

      DB::commit();

      return redirect()->route('quarantine.index')
        ->with('success', 'Ikan berhasil dimasukkan ke karantina!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function show(QuarantineRecord $quarantine)
  {
    $quarantine->load('fish');
    return view('quarantine.show', compact('quarantine'));
  }

  public function edit(QuarantineRecord $quarantine)
  {
    $fish = Fish::orderBy('name')->get();
    return view('quarantine.edit', compact('quarantine', 'fish'));
  }

  public function update(Request $request, QuarantineRecord $quarantine)
  {
    $validated = $request->validate([
      'fish_id' => 'required|exists:fish,id',
      'quantity' => 'required|integer|min:1',
      'start_date' => 'required|date',
      'end_date' => 'nullable|date|after_or_equal:start_date',
      'treatment' => 'nullable|string',
      'status' => 'required|in:aktif,selesai',
    ]);

    $quarantine->update($validated);

    return redirect()->route('quarantine.index')
      ->with('success', 'Data karantina berhasil diupdate!');
  }

  public function destroy(QuarantineRecord $quarantine)
  {
    DB::beginTransaction();
    try {
      // If still active, update fish status back to healthy
      if ($quarantine->status === 'aktif') {
        $quarantine->fish->update(['health_status' => 'sehat']);
      }

      $quarantine->delete();

      DB::commit();

      return redirect()->route('quarantine.index')
        ->with('success', 'Data karantina berhasil dihapus!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withErrors(['error' => $e->getMessage()]);
    }
  }

  // Complete quarantine
  public function complete(QuarantineRecord $quarantine)
  {
    DB::beginTransaction();
    try {
      $quarantine->update([
        'status' => 'selesai',
        'end_date' => now(),
      ]);

      DB::commit();

      return back()->with('success', 'Karantina berhasil diselesaikan!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withErrors(['error' => $e->getMessage()]);
    }
  }
}
