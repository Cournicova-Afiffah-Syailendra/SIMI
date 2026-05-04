<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::latest()->get();
        return view('admin.inventories.index', compact('inventories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'total_stock' => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max'   => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('inventories', 'public');
        }

        Inventory::create([
            'name'            => $validated['name'],
            'category'        => $validated['category'],
            'total_stock'     => $validated['total_stock'],
            'available_stock' => $validated['total_stock'],
            'price'           => $validated['price'],
            'description'     => $validated['description'] ?? null,
            'image'           => $imagePath,
        ]);

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'total_stock' => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max'   => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $imagePath = $inventory->image;
        if ($request->hasFile('image')) {
            if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
                Storage::disk('public')->delete($inventory->image);
            }
            $imagePath = $request->file('image')->store('inventories', 'public');
        }

        $inventory->update([
            'name'            => $validated['name'],
            'category'        => $validated['category'],
            'total_stock'     => $validated['total_stock'],
            'available_stock' => $validated['total_stock'],
            'price'           => $validated['price'],
            'description'     => $validated['description'] ?? null,
            'image'           => $imagePath,
        ]);

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
            Storage::disk('public')->delete($inventory->image);
        }

        $inventory->delete();

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Data inventaris berhasil dihapus.');
    }
}
