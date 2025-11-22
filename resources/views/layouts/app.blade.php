<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Portugal Teste')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      color-scheme: light;

      --brand:#0d6efd;
      --brand-2:#14b8a6;

      --bg:#f7f9fb;
      --surface:#ffffff;
      --surface-2:#f8fafc;

      --ink:#0f172a;
      --muted:#64748b;

      --border:rgba(15,23,42,.10);
      --shadow:0 16px 50px rgba(2,6,23,.08);
      --ring:0 0 0 .25rem rgba(13,110,253,.25);
    }

    :root[data-theme="dark"]{
      color-scheme: dark;

      --bg:#0b1220;
      --surface:#0f172a;
      --surface-2:#111827;

      --ink:#e5e7eb;
      --muted:#9aa4b2;

      --border:rgba(148,163,184,.18);
      --shadow:0 18px 60px rgba(0,0,0,.55);
      --ring:0 0 0 .25rem rgba(13,110,253,.35);
    }

    /* layout principal: body como flex column para footer se comportar */
    body{
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background: var(--bg);
      color: var(--ink);
    }

    /* main ocupa espaço disponível entre nav e footer */
    main {
      flex: 1 1 auto;
    }

    .app-nav{
      background: color-mix(in srgb, var(--surface) 92%, transparent);
      border-bottom: 1px solid var(--border);
      backdrop-filter: blur(8px);
    }

    .brand-badge{
      display:inline-flex; align-items:center; gap:.6rem;
      font-weight:900; letter-spacing:-.02em;
    }
    .brand-ico{
      width:34px;height:34px;border-radius:10px;
      display:flex;align-items:center;justify-content:center;
      background: rgba(13,110,253,.12);
      color: var(--brand);
    }

    .card-elev{
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 1rem;
      box-shadow: var(--shadow);
    }

    .table{
      color: var(--ink);
    }
    .table thead th{
      color: var(--muted);
      font-weight:800;
      font-size:.85rem;
      text-transform:uppercase;
      letter-spacing:.04em;
      border-bottom-color: var(--border);
    }
    .table td, .table th{
      border-bottom-color: var(--border);
    }

    .form-control, .form-select{
      background: var(--surface);
      border-color: var(--border);
      color: var(--ink);
    }
    .form-control::placeholder{
      color: color-mix(in srgb, var(--muted) 80%, transparent);
    }
    .form-control:focus, .form-select:focus{
      border-color: var(--brand);
      box-shadow: var(--ring);
      background: var(--surface);
      color: var(--ink);
    }

    .btn-pill{ border-radius: 999px; font-weight:800; }
    .btn-soft{
      background: rgba(13,110,253,.10);
      color: var(--brand);
      border: 0;
    }

    .theme-toggle{
      width:40px;height:40px;border-radius:999px;
      display:inline-flex;align-items:center;justify-content:center;
      border:1px solid var(--border);
      background: var(--surface);
      color: var(--ink);
    }

    .alert{
      border-radius: .9rem;
      border: 1px solid var(--border);
      background: var(--surface);
      color: var(--ink);
    }

    /* footer mais compacto e sem "empurrar" a página */
    footer{
      color: var(--muted);
      border-top: 1px solid var(--border);
      background: var(--surface);
      padding-top: .5rem;
      padding-bottom: .5rem;
    }

    *{ transition: background-color .2s ease, color .2s ease, border-color .2s ease; }
  </style>

  @stack('styles')
</head>
<body>

  <nav class="navbar navbar-expand-lg sticky-top app-nav">
    <div class="container py-2">
      <a class="navbar-brand brand-badge" href="{{ route('people.index') }}">
        <span class="brand-ico"><i class="bi bi-person-lines-fill"></i></span>
        Multi Contact <span class="text-primary">Management</span>
      </a>

      <div class="ms-auto d-flex gap-2 align-items-center">
        <a href="{{ route('people.create') }}" class="btn btn-primary btn-pill px-3">
          <i class="bi bi-plus-circle me-1"></i> Nova Pessoa
        </a>

        <button id="themeToggle" class="theme-toggle" type="button" aria-label="Alternar tema">
          <i id="themeIcon" class="bi bi-moon-stars"></i>
        </button>
      </div>
    </div>
  </nav>

  <main class="container py-4">
    {{-- Flash messages --}}
    @if(session('success'))
      <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <div class="fw-semibold mb-1">Corrija os campos abaixo:</div>
        <ul class="mb-0 ps-3">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>

  <footer class="py-3 mt-auto">
    <div class="container small d-flex flex-column flex-md-row justify-content-between">
      <div>© {{ date('Y') }} Multi Contact Management</div>
      <div class="mt-2 mt-md-0">Laravel 10 · PHP 8.1</div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    (function(){
      const root = document.documentElement;
      const key  = "theme";
      const btn  = document.getElementById('themeToggle');
      const icon = document.getElementById('themeIcon');

      function current(){
        return root.getAttribute('data-theme') || 'light';
      }
      function apply(t){
        root.setAttribute('data-theme', t);
        icon.className = (t === 'dark') ? 'bi bi-sun' : 'bi bi-moon-stars';
      }

      apply(localStorage.getItem(key) || 'light');

      btn?.addEventListener('click', () => {
        const next = current() === 'dark' ? 'light' : 'dark';
        localStorage.setItem(key, next);
        apply(next);
      });
    })();
  </script>

  @stack('scripts')
</body>
</html>
