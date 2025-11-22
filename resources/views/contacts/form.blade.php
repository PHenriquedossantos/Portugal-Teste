@extends('layouts.app')

@section('title', $contact->exists ? 'Editar Contato' : 'Novo Contato')

@push('styles')
  {{-- Select2 (necessário para o componente) --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

<div class="mb-3">
  <h1 class="h3 fw-bold mb-0">
    {{ $contact->exists ? 'Editar contato' : 'Adicionar contato' }}
  </h1>
  <div class="text-secondary">
    Pessoa: <strong>{{ $person->name }}</strong>
  </div>
</div>

<div class="card shadow-sm rounded-3 p-4 p-md-5">
  <form method="POST"
        action="{{ $contact->exists
                      ? route('people.contacts.update',[$person,$contact])
                      : route('people.contacts.store',$person) }}">
    @csrf
    @if($contact->exists) @method('PUT') @endif

    <div class="row g-3">

      {{-- País --}}
      <div class="col-12">
        <label for="countrySelect" class="form-label fw-semibold">País</label>

        @php
          $oldCountry = old('country_code', $contact->country_code);
          $oldLabel = old('country_label', $contact->country_label ?? null);
        @endphp

        <select id="countrySelect" name="country_code"
                class="form-select @error('country_code') is-invalid @enderror"
                aria-label="Selecionar país"
                required>
          @if($oldCountry)
            <option selected value="{{ $oldCountry }}">
              {{ $oldLabel ?? $oldCountry }}
            </option>
          @endif
        </select>

        @error('country_code')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

        <div class="form-text">Busque pelo nome do país.</div>
      </div>

      {{-- Número --}}
      <div class="col-12">
        <label for="number" class="form-label fw-semibold">Número (9 dígitos)</label>
        <input id="number"
               type="text"
               name="number"
               inputmode="numeric"
               pattern="\d{9}"
               maxlength="9"
               class="form-control @error('number') is-invalid @enderror"
               placeholder="Ex.: 912345678"
               value="{{ old('number', $contact->number) }}"
               required
               aria-describedby="numberHelp">
        @error('number')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div id="numberHelp" class="form-text">Apenas 9 dígitos — sem espaços ou símbolos.</div>
      </div>

    </div>

    <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
      <button class="btn btn-primary btn-lg rounded-pill">
        <i class="bi bi-check2-circle me-1"></i>
        {{ $contact->exists ? 'Salvar alterações' : 'Adicionar contato' }}
      </button>

      <a href="{{ route('people.show',$person) }}" class="btn btn-outline-secondary btn-lg rounded-pill">
        Cancelar
      </a>
    </div>
  </form>
</div>

@endsection

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(function(){
      $('#countrySelect').select2({
        placeholder: 'Digite para buscar um país...',
        allowClear: true,
        ajax: {
          url: "{{ route('countries.search') }}",
          dataType: 'json',
          delay: 250,
          data: params => ({ q: params.term }),
          processResults: data => ({ results: data }),
          cache: true
        },
        templateResult: function(item) {
          return item.text || item.id || '';
        },
        templateSelection: function(item) {
          return item.text || item.id || '';
        },
        width: '100%'
      });
      $('input[name="number"]').on('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0,9);
      });
      $('input[name="number"]').on('keypress', function(e) {
        const ch = String.fromCharCode(e.which);
        if (!(/[0-9]/.test(ch))) {
          e.preventDefault();
        }
      });
    });
  </script>
@endpush
