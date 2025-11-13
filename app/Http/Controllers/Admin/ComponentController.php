<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Component;
use App\Models\ComponentCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ComponentController extends Controller
{
    public function index(Request $request)
    {
        $components = Component::with('componentCategory')
            ->orderBy('component_category_id', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(15);
            
        $categories = ComponentCategory::orderBy('sort_order', 'asc')->get();

        return view('admin.components.index', compact('components', 'categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'component_category_id' => 'required|exists:component_categories,id',
            'stock' => 'required|integer|min:0',
            'slot_size' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $validated['image']->store('custom-beads', 'public');

        Component::create([
            'name' => $validated['name'],
            'component_category_id' => $validated['component_category_id'],
            'stock' => $validated['stock'],
            'slot_size' => $validated['slot_size'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.components.index')->with('success', 'New component added successfully!');
    }
    public function edit(Component $component)
    {
        return response()->json([
            'name' => $component->name,
            'component_category_id' => $component->component_category_id,
            'stock' => $component->stock,
            'slot_size' => $component->slot_size,
            'image_path' => asset($component->image_path),
            'update_url' => route('admin.components.update', $component),
            'delete_url' => route('admin.components.destroy', $component),
        ]);
    }
    public function update(Request $request, Component $component)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'component_category_id' => 'required|exists:component_categories,id',
            'stock' => 'required|integer|min:0',
            'slot_size' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            if ($component->image_path) {
                Storage::disk('public')->delete($component->image_path);
            }
            $data['image_path'] = $request->file('image')->store('custom-beads', 'public');
        }

        $component->update($data);

        return redirect()->route('admin.components.index')->with('success', 'Component updated successfully!');
    }
    public function destroy(Component $component)
    {
        if ($component->image_path) {
            Storage::disk('public')->delete($component->image_path);
        }
        $component->delete();

        return redirect()->route('admin.components.index')->with('success', 'Component deleted successfully!');
    }
}