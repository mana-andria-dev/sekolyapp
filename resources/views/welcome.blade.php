@extends('layouts.app')
@section('title', 'SekolyPro — Gestion scolaire')
@section('content')

@if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show shadow-lg border-0 rounded-3 text-center fw-bold fs-5" role="alert" style="background: linear-gradient(135deg, #28a745, #218838); color: #fff;">
            <i class="bi bi-check-circle-fill me-2"></i> 
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="container mt-4">
        <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0 rounded-3" role="alert">
            <h5 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Erreurs rencontrées :</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
@endif

<!-- HERO PARALLAX -->
<section class="d-flex align-items-center justify-content-center text-center section parallax" style="min-height:100vh; background-image:url('https://images.unsplash.com/photo-1596496057320-4f62f3f591f0?q=80&w=1600');">
    <div class="overlay-dark"></div>
    <div class="position-relative text-white">
        <h1 class="hero-title mb-4 gsap-hero">La gestion scolaire <span class="text-gold">révolutionnée</span></h1>
        <p class="mb-4 fs-5 gsap-hero">Centralisez tout : admissions, emplois du temps, notes, paiements et communication. <br>Ultra-rapide. Ultra-stylé. Ultra-arrogant.</p>
        <a href="#demo" class="btn btn-gold btn-lg me-2 gsap-hero" data-bs-toggle="modal" data-bs-target="#tenantModal">Créer votre établissement</a>
        <a href="#features" class="btn btn-outline-light btn-lg gsap-hero">Voir les fonctionnalités</a>
    </div>
</section>

<!-- FONCTIONNALITÉS -->
<section id="features" class="section-alt">
    <div class="container text-center">
        <h2 class="mb-5 gsap-section">Fonctionnalités puissantes</h2>
        <div class="row g-4">
            @php
            $features = [
                ['🎓','Gestion des élèves','Fiches complètes, inscriptions, présences, dossiers.'],
                ['🧑‍🏫','Gestion des enseignants','Affectations, absences, communication ciblée.'],
                ['🗓️','Emplois du temps','Planification intelligente, conflits détectés automatiquement.'],
                ['📝','Notes & évaluations','Barèmes, moyennes, bulletins PDF.'],
                ['💳','Paiements & facturation','Stripe intégré, relances automatiques.'],
                ['📣','Communication','Messagerie interne, emails/SMS, annonces parents & élèves.'],
            ];
            @endphp
            @foreach($features as $f)
            <div class="col-md-4">
                <div class="feature-card gsap-card text-center p-4">
                    <div class="fs-1 mb-3">{{ $f[0] }}</div>
                    <h5 class="fw-bold mb-2">{{ $f[1] }}</h5>
                    <p class="text-white-50">{{ $f[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- AVANTAGES AVEC MOCKUP -->
<section id="benefits" class="section parallax" style="background-image:url('https://images.unsplash.com/photo-1581091215364-1c0031c03c1f?q=80&w=1600');">
    <div class="overlay-dark"></div>
    <div class="container position-relative text-white">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?q=80&w=1600&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg gsap-mockup" alt="Mockup tableau de bord">
            </div>
            <div class="col-md-6">
                <h2 class="mb-4 gsap-section">Un gain de temps phénoménal</h2>
                <ul class="mb-4 text-white-50">
                    <li>• Automatisations administratives</li>
                    <li>• Dashboard clair et KPIs instantanés</li>
                    <li>• Multitenant : espace dédié pour chaque établissement</li>
                    <li>• Sécurité renforcée : rôles, permissions, journaux</li>
                </ul>
                <a href="#demo" class="btn btn-gold me-2 gsap-hero" data-bs-toggle="modal" data-bs-target="#tenantModal">Demarrer</a>
                <a href="#contact" class="btn btn-outline-light gsap-hero">Parler à un expert</a>
            </div>
        </div>
    </div>
</section>

<!-- STATISTIQUES -->
<section id="stats" class="section-alt text-center">
    <div class="container">
        <h2 class="mb-5 gsap-section">Les chiffres parlent</h2>
        <div class="row g-4">
            <div class="col-md-3"><div class="stat-number gsap-stat" data-counter="500">0</div>Établissements</div>
            <div class="col-md-3"><div class="stat-number gsap-stat" data-counter="25000">0</div>Élèves</div>
            <div class="col-md-3"><div class="stat-number gsap-stat" data-counter="99.99">0</div>Disponible 99 % du temps</div>
            <div class="col-md-3"><div class="stat-number gsap-stat" data-counter="24">0</div>Support (h/24)</div>
        </div>
    </div>
</section>

<!-- TÉMOIGNAGES CAROUSEL -->
<section id="testimonials" class="section-alt position-relative parallax" style="background-image:url('https://images.unsplash.com/photo-1596496057320-4f62f3f591f0?q=80&w=1600');">
    <div class="overlay-dark"></div>
    <div class="container position-relative text-center text-white">
        <h2 class="mb-5 gsap-section">Ce que nos utilisateurs disent</h2>

        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php
                    $testimonials = [
                        ['Rakotoarimalala Martin','Directeur établissement','“SchoolPro a transformé notre gestion quotidienne. Tout est clair, rapide et sûr.”','https://randomuser.me/api/portraits/men/32.jpg'],
                        ['Mirana Andriamahefa','Professeure','“Les fonctionnalités sont incroyables, nos élèves et parents adorent l’interface.”','https://randomuser.me/api/portraits/women/44.jpg'],
                        ['Jean Josefa Rabearivelo','Responsable administratif','“Les rapports automatiques et le dashboard sont des gains de temps énormes.”','https://randomuser.me/api/portraits/men/56.jpg'],
                    ];
                @endphp

                @foreach($testimonials as $key => $t)
                <div class="carousel-item @if($key==0) active @endif">
                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                        <img src="{{ $t[3] }}" class="rounded-circle mb-3" width="80" height="80" alt="{{ $t[0] }}">
                        <h5 class="fw-bold">{{ $t[0] }}</h5>
                        <small class="text-white-50 mb-3">{{ $t[1] }}</small>
                        <p class="fst-italic">"{{ $t[2] }}"</p>
                    </div>
                </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>

            <div class="carousel-indicators mt-4">
                @foreach($testimonials as $key => $t)
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $key }}" @if($key==0) class="active" aria-current="true" @endif aria-label="Slide {{ $key+1 }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- CTA DEMO -->
<section id="demo" class="cta-section text-center section">
    <div class="container">
        <h2 class="mb-4 gsap-section">Prêt à demarrer ?</h2>
        <p class="mb-4 gsap-section">Découvrez comment SekolyPro transforme la gestion scolaire en expérience royale.</p>
        <a href="#contact" class="btn btn-dark btn-lg gsap-hero">Réserver un compte</a>
    </div>
</section>

<!-- MODAL FORMULAIRE TENANT -->
<div class="modal fade" id="tenantModal" tabindex="-1" aria-labelledby="tenantModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark-custom text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-gold" id="tenantModalLabel">Créer votre compte établissement</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('tenant.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nom de l’établissement</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select class="form-select" name="type" required>
              <option value="">Sélectionner</option>
              <option value="ecole">École</option>
              <option value="college">Collège</option>
              <option value="lycee">Lycée</option>
              <option value="universite">Université</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Adresse</label>
            <textarea required class="form-control" name="address">{{ old('address') }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" class="form-control" name="logo" required>
          </div>
          <button class="btn btn-gold w-100">Créer le compte</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script>
    gsap.registerPlugin(ScrollTrigger);

    // Animation HERO
    gsap.from(".gsap-hero", {
        opacity: 0, y: 50, duration: 1.5, stagger: 0.3, ease: "power3.out"
    });

    // Animation section + features
    gsap.utils.toArray(".gsap-section").forEach(el => {
        gsap.from(el, {
            opacity:0, y:80, duration:1.2,
            scrollTrigger: {trigger: el, start:"top 85%", toggleActions:"play none none reverse"}
        });
    });

    gsap.utils.toArray(".gsap-card, .gsap-mockup").forEach(el=>{
        gsap.from(el, {opacity:0, y:50, scale:0.9, duration:1, scrollTrigger:{trigger:el, start:"top 90%", toggleActions:"play none none reverse"}});
    });

    // Compteurs animés
    gsap.utils.toArray('.gsap-stat').forEach((el)=>{
        let end=parseFloat(el.dataset.counter);
        let obj={val:0};
        ScrollTrigger.create({
            trigger: el, start:"top 90%", once:true,
            onEnter:()=>{ gsap.to(obj,{val:end,duration:2,ease:"power1.out",onUpdate:()=>{el.innerText=Math.floor(obj.val);}}); }
        });
    });
</script>
@endsection
