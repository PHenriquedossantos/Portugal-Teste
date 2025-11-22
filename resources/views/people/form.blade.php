@extends('layouts.app')

@section('title', $person->exists ? 'Editar Pessoa' : 'Nova Pessoa')

@section('content')

<div class="mb-3">
  <h1 class="h3 fw-bold mb-0">
    {{ $person->exists ? 'Editar pessoa' : 'Cadastrar nova pessoa' }}
  </h1>
  <div class="text-secondary">Nome e email são únicos no sistema.</div>
</div>

<div class="card-elev p-4 p-md-5">
  <form method="POST"
        action="{{ $person->exists ? route('people.update',$person) : route('people.store') }}">
    @csrf
    @if($person->exists) @method('PUT') @endif

    <div class="row g-3">

      <div class="col-12">
        <label class="form-label fw-semibold">Nome</label>
        <input type="text"
               name="name"
               class="form-control"
               placeholder="Ex.: João da Silva"
               value="{{ old('name', $person->name) }}"
               required
               minlength="6">
        <div class="form-text">Mínimo de 6 caracteres.</div>
      </div>

      <div class="col-12">
        <label class="form-label fw-semibold">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               placeholder="email@exemplo.com"
               value="{{ old('email', $person->email) }}"
               required>
      </div>

    </div>

    <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
      <button class="btn btn-primary btn-pill px-4">
        <i class="bi bi-check2-circle me-1"></i>
        {{ $person->exists ? 'Salvar alterações' : 'Cadastrar pessoa' }}
      </button>

      <a href="{{ route('people.index') }}" class="btn btn-outline-secondary btn-pill px-4">
        Cancelar
      </a>
    </div>
  </form>
</div>

@endsection
