// panels-scroll.js
// Modernized version of your GSAP horizontal-panels + parallax code.
// Requirements: GSAP + ScrollTrigger should be loaded on the page.

document.addEventListener('DOMContentLoaded', () => {
  // quick guard
  if (!document.querySelector('.panels-container')) return;

  // Register ScrollTrigger plugin
  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
    console.error('GSAP and ScrollTrigger must be loaded before this script.');
    return;
  }
  gsap.registerPlugin(ScrollTrigger);

  // Use GSAP util to get arrays
  const tracks = gsap.utils.toArray('.panels');

  // Defaults
  gsap.defaults({ ease: 'none' });

  tracks.forEach((track) => {
    const trackWrapperEls = gsap.utils.toArray(track.querySelectorAll('.panels-container'));
    const allImgs = gsap.utils.toArray(track.querySelectorAll('.image'));

    // compute total width of all panel wrappers
    const trackWrapperWidth = () => trackWrapperEls.reduce((sum, el) => sum + el.offsetWidth, 0);

    // horizontal translate for the wrapper(s)
    const scrollTween = gsap.to(trackWrapperEls, {
      x: () => -trackWrapperWidth() + window.innerWidth,
      // Keep easing none for a smooth scrub
      ease: 'none',
      scrollTrigger: {
        trigger: track,
        pin: true,
        scrub: 1,
        start: 'center center',
        // Use the wrapper width so the end matches the sum of contents
        end: () => '+=' + (trackWrapperWidth() - window.innerWidth),
        invalidateOnRefresh: true,
        anticipatePin: true,
      },
    });

    // Parallax for images: from -20vw to 20vw mapped to the containerAnimation
    allImgs.forEach((img) => {
      // Optional: ensure the image element is layer-accelerated by CSS for smoother transforms:
      // .image { will-change: transform; backface-visibility: hidden; }
      gsap.fromTo(
        img,
        { x: '-20vw' },
        {
          x: '20vw',
          scrollTrigger: {
            trigger: img.parentNode, // use the panel wrapper as the trigger
            containerAnimation: scrollTween,
            start: 'left right',
            end: 'right left',
            scrub: true,
            invalidateOnRefresh: true,
          },
        }
      );
    });
  });

  // Optional: if you dynamically change layout, call ScrollTrigger.refresh()
});
