<?php

namespace App\Services;

use App\Models\Person;
use App\Models\Contact;

class ContactService
{
  public function createContact(Person $person)
  {
    return [
      'person'  => $person,
      'contact' => new Contact(),
    ];
  }

  public function storeContact(array $data, Person $person)
  {
    $exists = Contact::whereNull('deleted_at')->where('country_code', $data['country_code'])->where('number', $data['number'])->exists();

    return [
      'exists'  => $exists,
      'created' => $exists ? null : $person->contacts()->create($data),
    ];
  }

  public function showOrFail(Person $person, Contact $contact)
  {
    abort_unless($contact->person_id === $person->id, 404);

    return compact('person', 'contact');
  }

  public function editOrFail(Person $person, Contact $contact)
  {
    abort_unless($contact->person_id === $person->id, 404);

    return compact('person', 'contact');
  }

  public function updateContact(array $data, Person $person, Contact $contact)
  {
    abort_unless($contact->person_id === $person->id, 404);

    $exists = Contact::whereNull('deleted_at')->where('country_code', $data['country_code'])->where('number', $data['number'])->where('id', '!=', $contact->id)->exists();

    if ($exists) { return ['exists' => true]; }

    $contact->update($data);

    return ['exists' => false, 'updated' => $contact];
  }

  public function destroyContact(Person $person, Contact $contact)
  {
    abort_unless($contact->person_id === $person->id, 404);

    $contact->delete();

    return true;
  }
}
