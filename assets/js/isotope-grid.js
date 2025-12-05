(function ($) {

	// ============================================================================
	// Isotope
	// More info: http://isotope.metafizzy.co
	// Note: "imagesloaded" blugin is required! https://imagesloaded.desandro.com/
	// ============================================================================

	// Initialize Isotope
	const $isotopeContainer = $(".isotope-items-wrap");
	const isoTransitionDuration = "0.5s";

	$isotopeContainer.imagesLoaded(function() {
		$isotopeContainer.isotope({
			itemSelector: ".isotope-item",
			layoutMode: "packery",
			transitionDuration: isoTransitionDuration,
			percentPosition: true
		});
	});

	// Filter function
	function applyFilter(filterSelector, resetScroll = false) {
		$isotopeContainer.isotope({ filter: filterSelector });

		// Refresh ScrollTrigger after the transition
		setTimeout(() => {
			if (resetScroll) {
				ScrollTrigger.refresh(true); // Reset scroll position
			} else {
				ScrollTrigger.refresh(); // Don't reset scroll position
			}
		}, parseFloat(isoTransitionDuration) * 1000);
	}

	// Event delegation for filter clicks
	$(document).on("click", ".ttgr-cat-classic-item a", function(e) {
		e.preventDefault();
		const filterSelector = $(this).attr("data-filter");
		applyFilter(filterSelector); // Default behavior (no scroll reset)
	});

	$(document).on("click", ".ttgr-cat-item a", function(e) {
		e.preventDefault();
		const filterSelector = $(this).attr("data-filter");
		applyFilter(filterSelector, true); // Reset scroll position
	});

	// Active class management
	$(document).on("click", ".ttgr-cat-list a, .ttgr-cat-classic-list a", function() {
		const $this = $(this);
		if (!$this.hasClass("active")) {
			$(".ttgr-cat-list a, .ttgr-cat-classic-list a").removeClass("active");
			$this.addClass("active");
		}
	});



	// ================================================================
	// Portfolio grid
	// ================================================================

	// If "pgi-cap-inside enabled
	// ===========================
	if ($("#portfolio-grid").hasClass("pgi-cap-inside")) {

		// Move "pgi-caption" to inside "pgi-image-wrap".
		$(".portfolio-grid-item").each(function() {
			$(this).find(".pgi-caption").appendTo($(this).find(".pgi-image-wrap"));
		});

		// Remove grid item title anchor tag if exist.
		if ($(".pgi-title a").length) {
			$(".pgi-title a").contents().unwrap();
		}
	}


	// Play video on hover
	// ====================
	$(".pgi-image-wrap").on("mouseenter touchstart", function() {
		$(this).find("video").each(function() {
			$(this).get(0).play();
		});
	}).on("mouseleave touchend", function() {
		$(this).find("video").each(function() {
			$(this).get(0).pause();
		});
	});


	// Portfolio grid categories filter
	// =================================

	// On category trigger click.
	$(".ttgr-cat-trigger").on("click", function() {
		$("body").addClass("ttgr-cat-nav-open");
		if ($("body").hasClass("ttgr-cat-nav-open")) {

			gsap.to(".portfolio-grid-item", { duration: 0.3, scale: 0.9 });
			gsap.to("#page-header, #tt-header, .ttgr-cat-trigger", { duration: 0.3, autoAlpha: 0 });

			// Make "ttgr-cat-nav" unclickable.
			$(".ttgr-cat-nav").off("click");

			// Catecories step in animations.
			let tl_ttgrIn = gsap.timeline({
				// Wait until the timeline is completed then make "ttgr-cat-nav" clickable again.
				onComplete: function() {
					ttCatNavClose();

					// Disable page scroll if open
					if ($("body").hasClass("tt-smooth-scroll") && !tt_isMobile) {
						lenis.stop();
					} else {
						$("html").addClass("tt-no-scroll");
					}
				}
			});
			tl_ttgrIn.to(".ttgr-cat-nav", { duration: 0.3, autoAlpha: 1 });
			tl_ttgrIn.from(".ttgr-cat-close-btn", { duration: 0.3, y: 10, autoAlpha: 0, ease: Power2.easeIn });
			tl_ttgrIn.from(".ttgr-cat-list > li", { duration: 0.3, y: 40, autoAlpha: 0, stagger: 0.07, ease: Power2.easeOut, clearProps:"all" }, "-=0.2");

			// On catecory link hover
			$(".ttgr-cat-list").on("mouseenter", function() {
				$(this).parents(".ttgr-cat-nav").addClass("ttgr-cat-nav-hover");
			}).on("mouseleave", function() {
				$(this).parents(".ttgr-cat-nav").removeClass("ttgr-cat-nav-hover");
			});

		}
	});

	// On close click function
	function ttCatNavClose() {
		const $ttgrCatNavList = $(".ttgr-cat-list");

		// Close nav when clicking outside the ".ttgr-cat-list"
		$(".ttgr-cat-nav, .ttgr-cat-close-btn, .ttgr-cat-item").on("click", function (e) {
			if ($("body").hasClass("ttgr-cat-nav-open") && !$ttgrCatNavList.is(e.target) && $ttgrCatNavList.has(e.target).length === 0) {

				$("body").removeClass("ttgr-cat-nav-open");

				// Catecories step out animations
				let tl_ttgrClose = gsap.timeline();
					tl_ttgrClose.to(".ttgr-cat-close-btn", { duration: 0.3, y: -10, autoAlpha: 0, ease: Power2.easeIn });
					tl_ttgrClose.to(".ttgr-cat-list > li", { duration: 0.3, y: -40, autoAlpha: 0, stagger: 0.07, ease: Power2.easeIn }, "-=0.3");
					tl_ttgrClose.to(".ttgr-cat-nav", { duration: 0.3, autoAlpha: 0, clearProps:"all" }, "+=0.2");
					tl_ttgrClose.to(".portfolio-grid-item", { duration: 0.3, scale: 1, clearProps:"all" }, "-=0.4");
					tl_ttgrClose.to("#page-header, #tt-header, .ttgr-cat-trigger", { duration: 0.3, autoAlpha: 1, clearProps:"all" }, "-=0.4");
					tl_ttgrClose.to(".ttgr-cat-list > li, .ttgr-cat-close-btn", { clearProps:"all" }); // clearProps only

				// Enable page scroll if closed
				if ($("body").hasClass("tt-smooth-scroll") && !tt_isMobile) {
					lenis.start();
				} else {
					$("html").removeClass("tt-no-scroll");
				}

			}




			// Refresh ScrollTrigger
			ScrollTrigger.refresh();
		});
	}

})(jQuery);
