<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::orderBy('name')->paginate(10);
        return view('people.index', compact('people'));
    }

    public function create()
    {
        return view('people.form', ['person' => new Person()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','min:6'],
            'email' => ['required','email',
                Rule::unique('people')->whereNull('deleted_at')
            ],
        ]);

        $person = Person::create($data);

        return redirect()->route('people.show', $person)->with('success','Pessoa criada.');
    }

    public function show(Person $person)
    {
        $person->load('contacts');
        return view('people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        return view('people.form', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $data = $request->validate([
            'name'  => ['required','string','min:6'],
            'email' => ['required','email',
                Rule::unique('people')->ignore($person->id)->whereNull('deleted_at')
            ],
        ]);

        $person->update($data);

        return redirect()->route('people.show', $person)->with('success','Pessoa atualizada.');
    }

    public function destroy(Person $person)
    {
        $person->delete();
        return redirect()->route('people.index')->with('success','Pessoa removida.');
    }
}
