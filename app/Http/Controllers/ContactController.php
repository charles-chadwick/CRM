<?php

namespace App\Http\Controllers;

use App\Enums\ContactType;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
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
            'contacts' => ContactResource::collection($contacts),
        ]);
    }

    public function create()
    {
        return Inertia::render('Contacts/Form',
            [
                'on_type'       => request()->on_type,
                'on_id'         => request()->on_id,
                'contact_types' => ContactType::toSelect()
            ]);
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact)
    {
        $contact->load([
            'contactable',
        ]);

        return Inertia::render('Contacts/Show', [
            'contact' => new ContactResource($contact),
        ]);
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Contacts/Form', [
            'contact'       => $contact,
            'contact_types' => ContactType::toSelect()
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
