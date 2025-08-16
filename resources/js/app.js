// Tailwind / Laravel bootstrap si besoin
// import './bootstrap';

import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

// Reveal basique des éléments [data-animate]
const revealEls = document.querySelectorAll("[data-animate]");
revealEls.forEach((el) => {
  gsap.from(el, {
    opacity: 0,
    y: 24,
    duration: 0.8,
    ease: "power3.out",
    scrollTrigger: {
      trigger: el,
      start: "top 85%",
      toggleActions: "play none none reverse",
    },
  });
});

// Hero title pop
const heroTitle = document.querySelector(".hero-title");
if (heroTitle) {
  gsap.from(heroTitle, {
    opacity: 0,
    y: 18,
    duration: 0.9,
    ease: "power3.out",
    delay: 0.1,
  });
}

// Parallax cartes mockup
const parallax = (selector, y = 30) => {
  document.querySelectorAll(selector).forEach((el) => {
    gsap.to(el, {
      y: () => (ScrollTrigger.maxScroll(window) ? y : 0),
      ease: "none",
      scrollTrigger: {
        trigger: el,
        scrub: 0.5,
      },
    });
  });
};
parallax(".parallax", 40);
parallax(".parallax-slow", 24);
parallax(".parallax-fast", 64);

// Compteurs
const counters = document.querySelectorAll("[data-counter]");
counters.forEach((el) => {
  const end = parseFloat(el.getAttribute("data-counter"));
  const decimals = parseInt(el.getAttribute("data-decimals") || "0", 10);

  let obj = { val: 0 };
  ScrollTrigger.create({
    trigger: el,
    start: "top 85%",
    once: true,
    onEnter: () => {
      gsap.to(obj, {
        val: end,
        duration: 1.6,
        ease: "power2.out",
        onUpdate: () => {
          el.textContent = obj.val.toLocaleString(undefined, {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
          });
        },
      });
    },
  });
});

// Carousel simple (auto défilement)
const carousel = document.querySelector(".carousel");
if (carousel) {
  const speed = 0.6; // ajustable
  let cards = carousel.querySelectorAll(".carousel-card");
  if (cards.length) {
    // duplique pour boucle infinie
    carousel.append(...Array.from(cards).map(c => c.cloneNode(true)));

    let tl = gsap.timeline({ repeat: -1, defaults: { ease: "none" } });
    const cardWidth = cards[0].offsetWidth + 24; // marge
    const total = cardWidth * (carousel.children.length);

    gsap.set(carousel, { x: 0 });
    tl.to(carousel, { x: -total / 2, duration: (total / 2) * speed });

    // pause au hover
    carousel.addEventListener("mouseenter", () => tl.pause());
    carousel.addEventListener("mouseleave", () => tl.play());
  }
}
