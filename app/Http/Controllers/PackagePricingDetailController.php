<?php
namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackagePricingDetail;
use Illuminate\Http\Request;

class PackagePricingDetailController extends Controller
{
    public function index(Package $package)
    {
        $details = $package->pricingDetails()->latest()->get();
        return view('package_pricing.index', compact('package', 'details'));
    }

    public function show(package $package){
       return view('package_pricing.show', compact('package'));
    }

    public function create(Package $package)
    {
        return view('package_pricing.create', compact('package'));
    }

    public function store(Request $request, Package $package)
    {
        $request->validate([
            'hours' => 'required|integer|min:1',
            'kms'   => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $package->pricingDetails()->create($request->only('hours', 'kms', 'price'));
        return redirect()->route('package_pricing.index', $package)->with('success', 'Pricing detail added.');
    }

    public function edit(Package $package, PackagePricingDetail $detail)
    {
        return view('package_pricing.edit', compact('package', 'detail'));
    }

    public function update(Request $request, Package $package, PackagePricingDetail $detail)
    {
        $request->validate([
            'hours' => 'required|integer|min:1',
            'kms'   => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $detail->update($request->only('hours', 'kms', 'price'));
        return redirect()->route('package_pricing.index', $package)->with('success', 'Pricing updated.');
    }

    public function destroy(Package $package, PackagePricingDetail $detail)
    {
        $detail->delete();
        return redirect()->route('package_pricing.index', $package)->with('success', 'Pricing deleted.');
    }
}
