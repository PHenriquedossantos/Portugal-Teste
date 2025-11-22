<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $contact = $this->route('contact');
    $contactId = $contact ? ($contact->id ?? $contact) : null;

    return [
      'country_code' => ['required', 'string', 'max:10'],
      'number' => [
        'required',
        'digits:9',
        Rule::unique('contacts')
            ->ignore($contactId)
            ->where(function ($query) {
              return $query->where('country_code', $this->input('country_code'))
                           ->whereNull('deleted_at');
            }),
      ],
    ];
  }

  public function messages(): array
  {
    return [
      'number.digits' => 'O número deve conter exatamente 9 dígitos.',
      'number.unique' => 'Esse contato já existe no sistema.',
    ];
  }
}
