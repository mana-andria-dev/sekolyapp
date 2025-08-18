<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex">
    {{-- Sidebar Bootstrap --}}
    <aside class="bg-dark text-white d-flex flex-column justify-content-between vh-100 p-3" style="width: 250px;">
        {{-- Logo --}}
        <div>
            <h4 class="text-center fw-bold mb-4 text-primary">SekolyPro</h4>

            {{-- Menu --}}
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Etablissement
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('admin.students.index') }}"
                       class="nav-link text-white {{ request()->routeIs('admin.students.*') ? 'active bg-primary' : '' }}">
                        🎓 Elèves
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('admin.teachers.index') }}"
                       class="nav-link text-white {{ request()->routeIs('admin.teachers.*') ? 'active bg-primary' : '' }}">
                        🧑 Enseignants
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('admin.classes.index') }}"
                       class="nav-link text-white {{ request()->routeIs('admin.classes.*') ? 'active bg-primary' : '' }}">
                        🏫 Classes
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('admin.assignments.index') }}" 
                       class="nav-link text-white {{ request()->routeIs('admin.assignments.*') ? 'active bg-primary' : '' }}">
                        📝 Devoirs
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('subjects.index') }}"
                       class="nav-link text-white {{ request()->routeIs('subjects.*') ? 'active bg-primary' : '' }}">
                        📚 Matières
                    </a>
                </li>

            </ul>

        </div>

        {{-- Footer --}}
        <div class="border-top border-secondary pt-3">
            <a href="{{ route('logout') }}" class="nav-link text-white">
                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
            </a>
        </div>
    </aside>


    {{-- Main Content --}}
    <div class="flex-grow-1">
        {{-- Topbar --}}
        <nav class="navbar navbar-light bg-white shadow-sm p-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('title')</span>
                <div>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
