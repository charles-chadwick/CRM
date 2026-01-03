<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use function ucfirst;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $on_type = $this->handlePrimaryStatus($request);

        $validated = $request->validated();
        $validated['on_type'] = $on_type;

        $existing_contacts_count = Contact::where('on_id', $request->on_id)
            ->where('on_type', $on_type)
            ->count();

        if ($existing_contacts_count === 0) {
            $validated['is_primary'] = true;
        }

        Contact::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Contact created successfully.');
    }

    private function handlePrimaryStatus(ContactRequest $request) : string
    {
        $on_type = "App\\Models\\".ucfirst($request->on_type);
        $contact = Contact::where('on_id', $request->on_id)
            ->where('on_type', $on_type);


        if ($request->is_primary) {
            $contact->update(['is_primary' => 0]);
        }

        return $on_type;
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $this->handlePrimaryStatus($request);

        $contact->update($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->back()
            ->with('success', 'Contact deleted successfully.');
    }
}
