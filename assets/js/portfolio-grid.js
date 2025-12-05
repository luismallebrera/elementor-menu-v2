(function($) {
    var portgridlEl = function ($scope, $) {

		if ($("body:not(.elementor-editor-active) .isotope-items-wrap-el").length) {

			// init Isotope
			var $loadmorexen =$('.container-after-list');
			// Initialize Isotope
			//const $isotopeContainer = $(".isotope-items-wrap-el");
			const isoTransitionDuration = "0.5s";

			var $isotopeContainer = $('.isotope-items-wrap-el').isotope({
				itemSelector: ".isotope-item",
				layoutMode: "packery",
				transitionDuration: isoTransitionDuration,
				percentPosition: true
			});

			$isotopeContainer.imagesLoaded(function () {
				$isotopeContainer.isotope("layout");
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
			$(document).on("click", ".ttgr-cat-classic-item a, .ttgr-cat-item a", function(e) {
				e.preventDefault();
				const filterSelector = $(this).attr("data-filter");
				applyFilter(filterSelector); // Default behavior (no scroll reset)
			});



			// Active class management
			$(document).on("click", ".ttgr-cat-list a, .ttgr-cat-classic-list a", function() {
				const $this = $(this);
				if (!$this.hasClass("active")) {
					$(".ttgr-cat-list a, .ttgr-cat-classic-list a").removeClass("active");
					$this.addClass("active");
				}
			});

			//****************************
			// Isotope Load more button
			//****************************
			var itemcount = $('.isotope-items-wrap-el').data('load-item');
			var buttontext = $('.isotope-items-wrap-el').data('button-text');
			var initShow = itemcount; //number of items loaded on init & onclick load more button
			var counter = initShow; //counter for load more button
			var iso = $isotopeContainer.data('isotope'); // get Isotope instance

			loadMore(initShow); //execute function onload

			function loadMore(toShow) {
			  $isotopeContainer.find(".hidden").removeClass("hidden");

			  var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function(item) {
				return item.element;
			  });
			  $(hiddenElems).addClass('hidden');
			  $isotopeContainer.isotope('layout');

			  //when no more to load, hide show more button
			  if (hiddenElems.length == 0) {
				$(".iso-load-more-wrap-port-list").hide();
				//$(".full-width-section").addClass('xen-bottom-padding-120');
			  }
			  else {
				$(".iso-load-more-wrap-port-list").show();
			  };

			}

			  if (iso.filteredItems.length < initShow) {

			  }
			  else if (iso.filteredItems.length == initShow) {

			  }

			  else {
			//append load more button
			$loadmorexen.after('<div class="margin-top-40 soda-more-wrapper-port-list text-center  iso-load-more-wrap-port-list" ><a class="tt-btn tt-magnetic-item tt-btn-outline" id="load-more-port-list"> '+ buttontext +' </a></div>');
			  }
			//when load more button clicked
			$("#load-more-port-list").click(function() {
			  if ($('.ttgr-cat-classic-item a, .ttgr-cat-item a').data('clicked')) {
				//when filter button clicked, set initial value for counter
				counter = initShow;
				$('.ttgr-cat-classic-item a, .ttgr-cat-item a').data('clicked', false);

			  } else {
				counter = counter;
			  };

			  counter = counter + initShow;

			  loadMore(counter);
			});
			//when filter button clicked
			$(document).on("click", ".ttgr-cat-list a, .ttgr-cat-classic-list a", function(e) {
				$(this).data('clicked', true);
			  	loadMore(initShow);
			});
		}
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/soda-portfolio-grid.default', portgridlEl);
    });


})(jQuery);
