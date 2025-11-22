<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePersonRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'min:6'],
      'email' => [
        'required',
        'email',
        Rule::unique('people')->whereNull('deleted_at')
      ],
    ];
  }
}
