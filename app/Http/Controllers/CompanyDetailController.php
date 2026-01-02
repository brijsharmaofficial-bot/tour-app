<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetail;
use Illuminate\Http\Request;

class CompanyDetailController extends Controller
{
    public function index()
    {
        $companies = CompanyDetail::latest()->paginate(10);
        return view('company_details.index', compact('companies'));
    }

    public function create()
    {
        return view('company_details.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        CompanyDetail::create($request->all());

        return redirect()->route('company-details.index')
            ->with('success', 'Company details added successfully.');
    }

    public function edit(CompanyDetail $companyDetail)
    {
        return view('company_details.edit', compact('companyDetail'));
    }

    public function update(Request $request, CompanyDetail $companyDetail)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $companyDetail->update($request->all());

        return redirect()->route('company-details.index')
            ->with('success', 'Company details updated successfully.');
    }

    public function destroy(CompanyDetail $companyDetail)
    {
        $companyDetail->delete();

        return redirect()->route('company-details.index')
            ->with('success', 'Company deleted successfully.');
    }
}
