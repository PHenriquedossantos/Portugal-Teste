@extends('layouts.app')

@section('title','Detalhe do Contato')

@section('content')

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="h4 fw-bold mb-0">Contato</h1>
    <div class="text-secondary">
      Pessoa: <strong>{{ $person->name }}</strong>
    </div>
  </div>

  <div class="d-flex gap-2">
    <a href="{{ route('people.contacts.edit',[$person,$contact]) }}" class="btn btn-outline-secondary btn-pill px-3">
      <i class="bi bi-pencil me-1"></i> Editar
    </a>

    <form action="{{ route('people.contacts.destroy',[$person,$contact]) }}" method="POST">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger btn-pill px-3"
              onclick="return confirm('Remover este contato?')">
        <i class="bi bi-trash me-1"></i> Excluir
      </button>
    </form>
  </div>
</div>

<div class="card-elev p-4 p-md-5">
  <div class="row g-3">
    <div class="col-12 col-md-6">
      <div class="text-secondary small">Country Code</div>
      <div class="fw-semibold fs-5">{{ $contact->country_code }}</div>
    </div>
    <div class="col-12 col-md-6">
      <div class="text-secondary small">Número</div>
      <div class="fw-semibold fs-5">{{ $contact->number }}</div>
    </div>

    <div class="col-12">
      <div class="text-secondary small">Criado em</div>
      <div class="fw-semibold">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
    </div>
  </div>
</div>

<div class="mt-3">
  <a href="{{ route('people.show',$person) }}" class="text-decoration-none fw-semibold">
    ← Voltar para pessoa
  </a>
</div>

@endsection
