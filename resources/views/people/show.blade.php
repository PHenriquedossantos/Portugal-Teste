@extends('layouts.app')

@section('title','Detalhe da Pessoa')

@section('content')

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="h3 fw-bold mb-0">{{ $person->name }}</h1>
    <div class="text-secondary">{{ $person->email }}</div>
  </div>

  <div class="d-flex gap-2">
    <a href="{{ route('people.edit',$person) }}" class="btn btn-outline-secondary btn-pill px-3">
      <i class="bi bi-pencil me-1"></i> Editar
    </a>

    <form action="{{ route('people.destroy',$person) }}" method="POST">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger btn-pill px-3"
              onclick="return confirm('Remover esta pessoa?')">
        <i class="bi bi-trash me-1"></i> Excluir
      </button>
    </form>
  </div>
</div>

{{-- Card principal --}}
<div class="card-elev p-4 p-md-5 mb-3">
  <div class="row g-3">
    <div class="col-12 col-md-6">
      <div class="text-secondary small">ID</div>
      <div class="fw-semibold">{{ $person->id }}</div>
    </div>
    <div class="col-12 col-md-6">
      <div class="text-secondary small">Criado em</div>
      <div class="fw-semibold">{{ $person->created_at->format('d/m/Y H:i') }}</div>
    </div>
  </div>
</div>

{{-- Contatos --}}
<div class="d-flex align-items-center justify-content-between mb-2">
  <h2 class="h5 fw-bold mb-0">Contatos</h2>
  <a href="{{ route('people.contacts.create',$person) }}" class="btn btn-primary btn-pill px-3">
    <i class="bi bi-plus-circle me-1"></i> Novo contato
  </a>
</div>

<div class="card-elev p-3 p-md-4">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>Country Code</th>
          <th>Número</th>
          <th class="text-end">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($person->contacts as $contact)
          <tr>
            <td class="fw-semibold">{{ $contact->country_code }}</td>
            <td>{{ $contact->number }}</td>
            <td class="text-end">
              <a href="{{ route('people.contacts.show',[$person,$contact]) }}" class="btn btn-sm btn-soft btn-pill px-3">
                <i class="bi bi-eye me-1"></i> Ver
              </a>
              <a href="{{ route('people.contacts.edit',[$person,$contact]) }}" class="btn btn-sm btn-outline-secondary btn-pill px-3">
                <i class="bi bi-pencil me-1"></i> Editar
              </a>

              <form action="{{ route('people.contacts.destroy',[$person,$contact]) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger btn-pill px-3"
                        onclick="return confirm('Remover este contato?')">
                  <i class="bi bi-trash me-1"></i> Excluir
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="text-center text-secondary py-5">
              Nenhum contato cadastrado.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">
  <a href="{{ route('people.index') }}" class="text-decoration-none fw-semibold">
    ← Voltar para lista
  </a>
</div>

@endsection
