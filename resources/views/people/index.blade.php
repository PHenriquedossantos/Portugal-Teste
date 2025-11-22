@extends('layouts.app')

@section('title','Pessoas')

@section('content')

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
  <div>
    <h1 class="h3 fw-bold mb-0">Pessoas</h1>
    <div class="text-secondary">Gerencie pessoas e seus contatos.</div>
  </div>
  <a href="{{ route('people.create') }}" class="btn btn-primary btn-pill px-4">
    <i class="bi bi-plus-circle me-1"></i> Nova Pessoa
  </a>
</div>

<div class="card-elev p-3 p-md-4">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th class="text-center">Contatos</th>
          <th class="text-end">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($people as $person)
          <tr>
            <td class="fw-semibold">
              {{ $person->name }}
            </td>
            <td>{{ $person->email }}</td>
            <td class="text-center">
              <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                {{ $person->contacts()->count() }}
              </span>
            </td>
            <td class="text-end">
              <a href="{{ route('people.show',$person) }}" class="btn btn-sm btn-soft btn-pill px-3">
                <i class="bi bi-eye me-1"></i> Ver
              </a>
              <a href="{{ route('people.edit',$person) }}" class="btn btn-sm btn-outline-secondary btn-pill px-3">
                <i class="bi bi-pencil me-1"></i> Editar
              </a>

              <form action="{{ route('people.destroy',$person) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger btn-pill px-3"
                        onclick="return confirm('Remover esta pessoa?')">
                  <i class="bi bi-trash me-1"></i> Excluir
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center text-secondary py-5">
              Nenhuma pessoa cadastrada.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $people->links() }}
  </div>
</div>

@endsection
