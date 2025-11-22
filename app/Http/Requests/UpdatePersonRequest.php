<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $person = $this->route('person');
    $personId = $person ? ($person->id ?? $person) : null;

    return [
      'name' => ['required', 'string', 'min:6'],
      'email' => [
        'required',
        'email',
        Rule::unique('people')->ignore($personId)->whereNull('deleted_at'),
      ],
    ];
  }
}
