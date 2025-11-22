<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;


class PersonController extends Controller
{
  protected PersonService $service;

  public function __construct(PersonService $service)
  {
    $this->service = $service;
  }

  public function index()
  {
    $people = $this->service->paginate(10);
    return view('people.index', compact('people'));
  }

  public function create()
  {
    return view('people.form', ['person' => new Person()]);
  }

  public function store(StorePersonRequest $request)
  {
    $data   = $request->validated();
    $person = $this->service->create($data);

    return redirect()->route('people.show', $person)->with('success', 'Pessoa criada.');
  }


  public function show(Person $person)
  {
    $person = $this->service->loadWithContacts($person);
    return view('people.show', compact('person'));
  }

  public function edit(Person $person)
  {
    return view('people.form', compact('person'));
  }

  public function update(UpdatePersonRequest $request, Person $person)
  {
    $data   = $request->validated();
    $person = $this->service->update($person, $data);

    return redirect()->route('people.show', $person)->with('success','Pessoa atualizada.');
  }

  public function destroy(Person $person)
  {
    $this->service->delete($person);
    return redirect()->route('people.index')->with('success','Pessoa removida.');
  }
}
