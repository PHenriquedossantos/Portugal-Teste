<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function create(Person $person)
    {
        return view('contacts.form', [
            'person'  => $person,
            'contact' => new Contact(),
        ]);
    }

    public function store(Request $request, Person $person)
    {
        $data = $request->validate([
            'country_code' => ['required','string','max:10'],
            'number'       => ['required','digits:9'],
        ]);

        $exists = Contact::whereNull('deleted_at')->where('country_code', $data['country_code'])->where('number', $data['number'])->exists();

        if ($exists) {
            return back()->withErrors(['number' => 'Esse contato já existe no sistema.'])->withInput();
        }

        $person->contacts()->create($data);

        return redirect()->route('people.show', $person)->with('success','Contato adicionado.');
    }

    public function show(Person $person, Contact $contact)
    {
        abort_unless($contact->person_id === $person->id, 404);

        return view('contacts.show', compact('person','contact'));
    }

    public function edit(Person $person, Contact $contact)
    {
        abort_unless($contact->person_id === $person->id, 404);

        return view('contacts.form', compact('person','contact'));
    }

    public function update(Request $request, Person $person, Contact $contact)
    {
        abort_unless($contact->person_id === $person->id, 404);

        $data = $request->validate([
            'country_code' => ['required','string','max:10'],
            'number'       => ['required','digits:9'],
        ]);

        $exists = Contact::whereNull('deleted_at')->where('country_code', $data['country_code'])->where('number', $data['number'])->where('id', '!=', $contact->id)->exists();

        if ($exists) {
            return back()->withErrors(['number' => 'Esse contato já existe no sistema.'])->withInput();
        }

        $contact->update($data);

        return redirect()->route('people.contacts.show', [$person, $contact])->with('success','Contato atualizado.');
    }

    public function destroy(Person $person, Contact $contact)
    {
        abort_unless($contact->person_id === $person->id, 404);

        $contact->delete();
        return redirect()->route('people.show', $person)->with('success','Contato removido.');
    }
}
