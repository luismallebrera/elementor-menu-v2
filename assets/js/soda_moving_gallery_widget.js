// Moving Gallery JS
document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.utils.toArray('.moving-gallery').forEach((section, index) => {
        const w = section.querySelector('.wrapper-gallery');
        if (!w) return;
        const [x, xEnd] = (index % 2)
            ? [(section.offsetWidth - w.scrollWidth), 0]
            : [0, section.offsetWidth - w.scrollWidth];
        gsap.fromTo(w, { x }, {
            x: xEnd,
            scrollTrigger: {
                trigger: section,
                scrub: 0.5,
            }
        });
    });
});