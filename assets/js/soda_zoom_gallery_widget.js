gsap.utils.toArray('.zoom-gallery').forEach((zoomGallery) => {
	const zoomGalleryWrapper = zoomGallery.querySelector(".zoom-wrapper-gallery");
	const zoomWrapperThumb = zoomGallery.querySelector(".zoom-wrapper-thumb");
	const ZoomItem = zoomGallery.querySelector(".zoom-center .zoom-img-wrapper");
	const zoomImgsWrapper = zoomGallery.querySelectorAll('li:not(.zoom-center) .zoom-img-wrapper');

	if (!zoomGalleryWrapper || !zoomWrapperThumb || !ZoomItem) {
		return;
	}
	const heightRatio = parseFloat(zoomGalleryWrapper.dataset.heightratio) || 1;
	const zoomImgsHeight = ZoomItem.offsetWidth * heightRatio;
	const paddingBottom = (window.innerHeight - zoomImgsHeight) / 2;
	
	gsap.set(zoomGallery, {paddingBottom: paddingBottom });
	gsap.set(zoomGalleryWrapper, {height: zoomImgsHeight });
	gsap.set(zoomWrapperThumb, {top: - paddingBottom, height: window.innerHeight });

	gsap.to(zoomGallery, {
		scrollTrigger: {
			trigger: zoomGallery,
			start: function() {
				const startPin = (window.innerHeight - zoomGalleryWrapper.offsetHeight)/2;
				return "top +=" + startPin;
			},
			end: '+=200%',
			scrub: true,
			pin: true,
		}
	});

	gsap.to(zoomImgsWrapper, {
		scale:0.9,
		opacity:0,
		borderRadius: "0",
		ease: Linear.easeNone,
		scrollTrigger: {
			trigger: zoomGallery,
			start: function() {
				const startPin = (window.innerHeight - zoomGalleryWrapper.offsetHeight)/2;
				return "top +=" + startPin;
			},
			end: '+=25%',
			scrub: true,
		}
	});

	const state = Flip.getState(ZoomItem);      
	zoomWrapperThumb.appendChild(ZoomItem);
		
	const zoomAnimation = Flip.from(state, {
		borderRadius: "0",
		absolute: true			
	});
	
	ScrollTrigger.create({
		trigger: zoomGalleryWrapper,
		start: function() {
			const startPin = (window.innerHeight - zoomGalleryWrapper.offsetHeight)/2;
			return "top +=" + startPin;
		},
		end: '+=200%',
		scrub: true,
		animation: zoomAnimation,      
	});
});