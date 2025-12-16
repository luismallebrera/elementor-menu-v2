// Pinned Gallery JS

document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.utils.toArray('.pinned-gallery').forEach((pinnedGallery) => {
        const pinnedImages = pinnedGallery.querySelectorAll('.pinned-image');

        function setImagesProperties() {
            gsap.set(pinnedImages, { height: window.innerHeight });
        }

        setImagesProperties();
        window.addEventListener('resize', setImagesProperties);

        pinnedImages.forEach((pImage, i, arr) => {
            if (i < arr.length - 1) {
                const durationMultiplier = arr.length - i - 1;

                ScrollTrigger.create({
                    trigger: pImage,
                    start: function() {
                        const centerPin = (window.innerHeight - pImage.querySelector('img').offsetHeight) / 2;
                        return "top +=" + centerPin;
                    },
                    end: function() {
                        const durationHeight = pImage.offsetHeight * durationMultiplier + (pImage.offsetHeight - pImage.querySelector('img').offsetHeight)/2;
                        return "+=" + durationHeight;
                    },
                    pin: true,
                    pinSpacing: false,
                    scrub: true,
                });

                const animationProperties = {
                    scale: 0.75,
                    opacity: 0.5,
                    zIndex: 0,
                    duration: 1,
                    ease: "none"
                };

                ScrollTrigger.create({
                    trigger: pImage,
                    start: function() {
                        const centerPin = (window.innerHeight - pImage.querySelector('img').offsetHeight) / 2;
                        return "top +=" + centerPin;
                    },
                    end: function() {
                        const durationHeight = pImage.offsetHeight + (pImage.offsetHeight - pImage.querySelector('img').offsetHeight) / 2;
                        return "+=" + durationHeight;
                    },
                    scrub: true,
                    animation: gsap.to(pImage.querySelector('img'), animationProperties),
                });
            }
        });
    });

    // Pinned Sections
    if (window.innerWidth > 479) {
        var pinnedSection = gsap.utils.toArray('.pinned-element');
        pinnedSection.forEach(function(pinElement) {
            var parentNode = pinElement.parentNode;
            var scrollingElement = parentNode.querySelector('.scrolling-element');
            if (!scrollingElement) return;

            ScrollTrigger.create({
                trigger: pinElement,
                start: function() {
                    const startPin = (window.innerHeight - pinElement.offsetHeight)/2;
                    return "top +=" + startPin;
                },
                end: () => `+=${scrollingElement.offsetHeight - pinElement.offsetHeight}`,
                pin: pinElement,
            });
        });
    }
});