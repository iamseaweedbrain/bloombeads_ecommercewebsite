<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomDesign;
use App\Models\Component;
use App\Models\User;

class CustomDesignController extends Controller
{
    /**
     * Display a listing of all submitted custom designs.
     */
    public function index(Request $request)
    {
        $filter = $request->query('status', 'all');
        $query = CustomDesign::with('user');

        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'quoted') {
            $query->where('status', 'quoted');
        } elseif ($filter === 'complete') {
            $query->where('status', 'complete');
        } elseif ($filter === 'declined') {
            $query->where('status', 'declined');
        }

        $designs = $query->orderBy('created_at', 'desc')
                         ->paginate(20)
                         ->withQueryString();

        return view('admin.approvals', [
            'designs' => $designs,
            'activeFilter' => $filter,
        ]);
    }

    /**
     * Show the details of a single custom design.
     */
    public function show(CustomDesign $design)
    {
        $design->load('user');
        
        $componentIds = $design->design_data;
        $uniqueIds = array_unique(array_filter($componentIds));
        $components = Component::findMany($uniqueIds);

        $componentsWithUrls = $components->keyBy('id')->map(function ($component) {
            $component->full_image_url = asset($component->image_path); 
            return $component;
        });

        return view('admin.approval_details', [
            'design' => $design,
            'components' => $componentsWithUrls,
        ]);
    }

    /**
     * Update the status and price of a custom design.
     */
    public function update(Request $request, CustomDesign $design)
    {
        $validated = $request->validate([
            'final_price' => 'required_if:status,quoted|nullable|numeric|min:0',
            'status' => 'required|in:pending,quoted,complete,declined',
        ]);

        $newStatus = $validated['status'];
        $oldStatus = $design->status;

        if ($newStatus === 'declined' && $oldStatus !== 'declined') {
            
            $componentIds = $design->design_data;
            $counts = array_count_values(array_filter($componentIds)); 

            if (!empty($counts)) {
                $componentsToRestock = Component::find(array_keys($counts));
                
                foreach ($componentsToRestock as $component) {
                    $quantityToRestock = $counts[$component->id];
                    $component->increment('stock', $quantityToRestock);
                }
            }
        }

        $design->update([
            'final_price' => $validated['final_price'] ?? $design->final_price,
            'status' => $newStatus,
        ]);

        return redirect()->route('admin.approvals.show', $design)->with('success', 'Design status has been updated!');
    }
}