<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::query()

            ->when($request->search, function ($query, $search) {

                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('tax_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })

            ->orderBy('name')

            ->paginate(10)

            ->withQueryString()

            ->through(fn ($client) => [

                'id' => $client->id,

                'name' => $client->name,

                'tax_number' => $client->tax_number,

                'email' => $client->email,

                'phone' => $client->phone,

                'city' => $client->city,
            ]);

        return Inertia::render('Clients/Index', [

            'clients' => $clients,

            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Client::class);

        return Inertia::render('Clients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([

            'name' => ['required', 'max:255', 'unique:clients,name'],

            'tax_number' => ['required', 'max:50'],

            'first_name' => ['nullable', 'max:50'],

            'last_name' => ['nullable', 'max50'],

            'street' => ['nullable', 'max:50'],

            'postal_code' => ['nullable', 'max:50'],

            'city' => ['nullable', 'max:50'],

            'country' => ['nullable', 'max:50'],

            'email' => ['nullable', 'email'],

            'phone' => ['nullable'],
        ]);

        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client added to database');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return Inertia::render('Clients/Show', [
            'client' => $client,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $this->authorize('edit', Client::class);

        return Inertia::render('Clients/Edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {

        $this->authorize('update', $client);

        $validated = $request->validate([

            'name' => ['required', 'max:255'],

            'first_name' => ['nullable', 'max:50'],

            'last_name' => ['nullable', 'max50'],

            'tax_number' => ['required', 'max:50'],

            'street' => ['nullable', 'max:50'],

            'postal_code' => ['nullable', 'max:50'],

            'city' => ['nullable', 'max:50'],

            'country' => ['nullable', 'max:50'],

            'email' => ['nullable', 'email'],

            'phone' => ['nullable'],

        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Clients data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        if ($client->invoices()->exists()) {

            return back()->withErrors([
                'delete' => 'The client has issued invoices.',
            ]);
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Clients data deleted');
    }

    public function search(Request $request)
    {
        return Client::query()

            ->where('name', 'like', '%'.$request->q.'%')

            ->orWhere('email', 'like', '%'.$request->q.'%')

            ->limit(10)

            ->get([
                'id',
                'name',
                'email',
            ]);
    }
}
