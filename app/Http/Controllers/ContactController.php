<?php

namespace App\Http\Controllers;

use App\Enums\ContactType;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Inertia\Inertia;
use function request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with([
            'contactable'
        ])
            ->latest()
            ->paginate(15);

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts
        ]);
    }

    public function store(StoreContactRequest $request)
    {
        $on_type = "App\Models\\" . ucfirst($request->on_type);
        if ($request->is_primary) {
            Contact::where('on_id', $request->on_id)
                ->where('on_type', $on_type)
                ->update(['is_primary' => 0]);
        }

        $validated = $request->validated();
        $validated['on_type'] = $on_type;
        Contact::create($validated);

        return redirect()
            ->route($request->route()
                ->getName())
            ->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact)
    {
        $contact->load([
            'contactable',
        ]);

        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }


    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
