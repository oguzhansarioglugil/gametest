<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HardwareBrand;
use App\Models\HardwareModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HardwareManagementController extends Controller
{
    /**
     * Hardware Brands Management
     */
    public function brands()
    {
        $brands = HardwareBrand::withCount('models')->paginate(20);
        return view('admin.hardware.brands.index', compact('brands'));
    }

    public function createBrand()
    {
        return view('admin.hardware.brands.create');
    }

    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:hardware_brands,name',
            'logo' => 'nullable|string|max:500'
        ]);

        HardwareBrand::create($request->only(['name', 'logo']));

        return redirect()->route('admin.hardware.brands.index')
                        ->with('success', 'Donanım markası başarıyla eklendi.');
    }

    public function editBrand(HardwareBrand $brand)
    {
        return view('admin.hardware.brands.edit', compact('brand'));
    }

    public function updateBrand(Request $request, HardwareBrand $brand)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hardware_brands', 'name')->ignore($brand->id)
            ],
            'logo' => 'nullable|string|max:500'
        ]);

        $brand->update($request->only(['name', 'logo']));

        return redirect()->route('admin.hardware.brands.index')
                        ->with('success', 'Donanım markası başarıyla güncellendi.');
    }

    public function destroyBrand(HardwareBrand $brand)
    {
        if ($brand->models()->count() > 0) {
            return back()->with('error', 'Bu markaya ait modeller var. Önce modelleri silin.');
        }

        $brand->delete();

        return back()->with('success', 'Donanım markası başarıyla silindi.');
    }

    /**
     * Hardware Models Management
     */
    public function models(Request $request)
    {
        $query = HardwareModel::with('brand');

        // Brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('brand', function($brandQuery) use ($search) {
                      $brandQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $models = $query->orderBy('type')
                       ->orderBy('brand_id')
                       ->orderBy('name')
                       ->paginate(50);

        $brands = HardwareBrand::orderBy('name')->get();

        return view('admin.hardware.models.index', compact('models', 'brands'));
    }

    public function createModel()
    {
        $brands = HardwareBrand::orderBy('name')->get();
        return view('admin.hardware.models.create', compact('brands'));
    }

    public function storeModel(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:hardware_brands,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:cpu,gpu',
            'description' => 'nullable|string|max:1000'
        ]);

        // Aynı marka, tip ve isimde model var mı kontrol et
        $exists = HardwareModel::where('brand_id', $request->brand_id)
                              ->where('type', $request->type)
                              ->where('name', $request->name)
                              ->exists();

        if ($exists) {
            return back()->withInput()
                        ->withErrors(['name' => 'Bu marka ve tip için aynı isimde model zaten mevcut.']);
        }

        HardwareModel::create($request->only(['brand_id', 'name', 'type', 'description']));

        return redirect()->route('admin.hardware.models.index')
                        ->with('success', 'Donanım modeli başarıyla eklendi.');
    }

    public function editModel(HardwareModel $model)
    {
        $brands = HardwareBrand::orderBy('name')->get();
        return view('admin.hardware.models.edit', compact('model', 'brands'));
    }

    public function updateModel(Request $request, HardwareModel $model)
    {
        $request->validate([
            'brand_id' => 'required|exists:hardware_brands,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:cpu,gpu',
            'description' => 'nullable|string|max:1000'
        ]);

        // Aynı marka, tip ve isimde model var mı kontrol et (kendisi hariç)
        $exists = HardwareModel::where('brand_id', $request->brand_id)
                              ->where('type', $request->type)
                              ->where('name', $request->name)
                              ->where('id', '!=', $model->id)
                              ->exists();

        if ($exists) {
            return back()->withInput()
                        ->withErrors(['name' => 'Bu marka ve tip için aynı isimde model zaten mevcut.']);
        }

        $model->update($request->only(['brand_id', 'name', 'type', 'description']));

        return redirect()->route('admin.hardware.models.index')
                        ->with('success', 'Donanım modeli başarıyla güncellendi.');
    }

    public function destroyModel(HardwareModel $model)
    {
        if ($model->isInUse()) {
            return back()->with('error', 'Bu donanım modeli kullanımda olduğu için silinemez.');
        }

        $model->delete();

        return back()->with('success', 'Donanım modeli başarıyla silindi.');
    }

    /**
     * Bulk Actions
     */
    public function bulkDeleteModels(Request $request)
    {
        $request->validate([
            'model_ids' => 'required|array',
            'model_ids.*' => 'exists:hardware_models,id'
        ]);

        $models = HardwareModel::whereIn('id', $request->model_ids)->get();
        $deletedCount = 0;
        $errors = [];

        foreach ($models as $model) {
            if (!$model->isInUse()) {
                $model->delete();
                $deletedCount++;
            } else {
                $errors[] = $model->brand->name . ' ' . $model->name;
            }
        }

        $messages = [];
        if ($deletedCount > 0) {
            $messages[] = $deletedCount . ' donanım modeli başarıyla silindi.';
        }
        if (count($errors) > 0) {
            $messages[] = 'Şu modeller kullanımda olduğu için silinemedi: ' . implode(', ', $errors);
        }

        $type = count($errors) > 0 && $deletedCount === 0 ? 'error' : 'success';

        return back()->with($type, implode(' ', $messages));
    }

    /**
     * Quick stats for dashboard
     */
    public function getStats()
    {
        return [
            'total_brands' => HardwareBrand::count(),
            'total_models' => HardwareModel::count(),
            'cpu_models' => HardwareModel::where('type', 'cpu')->count(),
            'gpu_models' => HardwareModel::where('type', 'gpu')->count(),
        ];
    }
}
