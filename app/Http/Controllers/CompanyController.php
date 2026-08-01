<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        //$company = Company::first() ;
        $company = Company::firstOrCreate([], [
            'name' => '',
            'tax_number' => '',
            'email' => '',
            'phone' => '',
            'street' => '',
            'city' => '',
            'postal_code' => '',
            'country' => '',
            'bank_account' => '',
            'website' => '',
        ]);
        
        return Inertia::render('Company', [
            'company' => $company,

        ]);
    }

    public function edit()
    {
        $company = Company::first() ;
        

        return Inertia::render('Company/Edit', [
            'company' => $company,

        ]);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([

            'name' => ['required', 'max:255'],

            'tax_number' => ['required', 'max:50'],

            'email' => ['nullable', 'email'],

            'phone' => ['nullable', 'max:50'],

            'street' => ['nullable', 'max:50'],

            'postal_code' => ['nullable', 'max:50'],

            'country' => ['nullable', 'max:50'],

            'city' => ['nullable', 'max:50'],

        ]);

        $company->update($validated);

        return redirect()
            ->route('company')
            ->with('success', 'Company data updated.');
    }
}
