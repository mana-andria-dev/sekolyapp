<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sekoly — Gestion scolaire')</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Police premium -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- CSS personnalisé -->
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0A0A0A; color: white; overflow-x:hidden; }
        h1,h2,h3,h4,h5,h6 { font-family: 'Montserrat', sans-serif; }
        .text-gold { color: #FFD700; }
        .bg-dark-custom { background-color: #0A0A0A; }
        .btn-gold { background-color: #FFD700; color: #000; font-weight: bold; }
        .btn-gold:hover { opacity: 0.9; color: #000; }
        .section { padding: 100px 0; position: relative; }
        .section-alt { padding: 100px 0; background-color: rgba(255,255,255,0.05); }
        .hero-title { font-size: 3rem; font-weight: 900; line-height:1.1; }
        .feature-card { background-color: rgba(255,255,255,0.05); border-radius: 15px; padding: 30px; transition: all 0.4s; }
        .feature-card:hover { transform: translateY(-10px) scale(1.05); box-shadow: 0 20px 40px rgba(0,0,0,0.7); }
        .stat-number { font-size: 3rem; font-weight: 900; color: #FFD700; }
        .parallax { background-attachment: fixed; background-position: center; background-size: cover; background-repeat: no-repeat; }
        .overlay-dark { position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); }
        .cta-section { background-color:#FFD700; color:#000; }
    </style>

    @yield('head')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark-custom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-gold" href="#">SekolyPro</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
        <li class="nav-item"><a class="nav-link" href="#benefits">Avantages</a></li>
        <li class="nav-item"><a class="nav-link" href="#stats">Chiffres</a></li>
        <li class="nav-item"><a class="btn btn-gold ms-2" href="#contact">Contact</a></li>
        <!-- <li class="nav-item"><a class="btn btn-gold ms-2" href="#demo">Demo</a></li> -->
      </ul>
    </div>
  </div>
</nav>

<!-- Main content -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="mt-5 py-5 border-top border-white/10 text-white-50">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5 class="text-gold fw-bold">SekolyPro</h5>
        <p>La solution arrogante qui propulse votre établissement à l’ère digitale.</p>
      </div>
      <div class="col-md-4">
        <h6>Produit</h6>
        <ul class="list-unstyled">
          <li><a href="#features" class="text-white text-decoration-none">Fonctionnalités</a></li>
          <li><a href="#benefits" class="text-white text-decoration-none">Avantages</a></li>
          <li><a href="#demo" class="text-white text-decoration-none">Tarifs</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h6>Contact</h6>
        <p>Email: support@SekolyPro.app</p>
        <p>© {{ date('Y') }} SekolyPro. Tous droits réservés.</p>
      </div>
    </div>
  </div>
</footer>

<!-- GSAP -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>
