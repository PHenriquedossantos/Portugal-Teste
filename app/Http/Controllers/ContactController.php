<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
  protected ContactService $service;

  public function __construct(ContactService $service)
  {
    $this->service = $service;
  }

  public function create(Person $person)
  {
    $data = $this->service->createContact($person);

    return view('contacts.form', $data);
  }

  public function store(StoreContactRequest $request, Person $person)
  {
    $data   = $request->validated();
    $result = $this->service->storeContact($data, $person);

    if ($result['exists']) 
    {
      return back()->withErrors([
        'number' => 'Esse contato já existe no sistema.'
      ])->withInput();
    }

    return redirect()->route('people.show', $person)->with('success','Contato adicionado.');
  }

  public function show(Person $person, Contact $contact)
  {
    $data = $this->service->showOrFail($person, $contact);

    return view('contacts.show', $data);
  }

  public function edit(Person $person, Contact $contact)
  {
    $data = $this->service->editOrFail($person, $contact);

    return view('contacts.form', $data);
  }

  public function update(UpdateContactRequest $request, Person $person, Contact $contact)
  {
    $data = $request->validated();
    $result = $this->service->updateContact($data, $person, $contact);

    if ($result['exists'])
    {
      return back()->withErrors([
        'number' => 'Esse contato já existe no sistema.'
      ])->withInput();
    }

    return redirect()->route('people.contacts.show', [$person, $contact])->with('success','Contato atualizado.');
  }

  public function destroy(Person $person, Contact $contact)
  {
    $this->service->destroyContact($person, $contact);

    return redirect()->route('people.show', $person)->with('success','Contato removido.');
  }
}
