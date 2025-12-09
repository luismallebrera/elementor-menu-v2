(function () {
	'use strict';

	function clamp(value, min, max) {
		return Math.min(Math.max(value, min), max);
	}

	function setTransform(state) {
		var inner = state.inner;
		inner.style.transform = 'translate(' + state.x + 'px, ' + state.y + 'px) scale(' + state.scale + ')';
	}

	function updateScale(state, nextScale, centerX, centerY) {
		var previousScale = state.scale;
		state.scale = clamp(nextScale, state.minZoom, state.maxZoom);

		var scaleDelta = state.scale / previousScale;
		state.x = centerX - (centerX - state.x) * scaleDelta;
		state.y = centerY - (centerY - state.y) * scaleDelta;

		setTransform(state);
	}

	function initPanZoom($scope) {
		var container = $scope[0];
		if (!container) {
			return;
		}

		var viewport = container.querySelector('.soda-image-pan-zoom__viewport');
		var inner = container.querySelector('.soda-image-pan-zoom__inner');
		var image = inner ? inner.querySelector('img') : null;
		if (!viewport || !inner) {
			return;
		}

		var enableWheel = container.getAttribute('data-enable-wheel') === 'true';
		var enableDrag = container.getAttribute('data-enable-drag') === 'true';
		var minZoomAttr = parseFloat(container.getAttribute('data-min-zoom'));
		var maxZoomAttr = parseFloat(container.getAttribute('data-max-zoom'));
		var initialZoomAttr = parseFloat(container.getAttribute('data-initial-zoom'));
		var stepAttr = parseFloat(container.getAttribute('data-zoom-step'));

		var minZoom = isNaN(minZoomAttr) ? 1 : minZoomAttr;
		var maxZoom = isNaN(maxZoomAttr) ? 4 : maxZoomAttr;
		var initialZoom = isNaN(initialZoomAttr) ? minZoom : initialZoomAttr;
		var step = isNaN(stepAttr) ? 0.2 : Math.abs(stepAttr);

		if (minZoom <= 0) {
			minZoom = 0.1;
		}
		if (maxZoom <= minZoom) {
			maxZoom = minZoom + 0.5;
		}
		initialZoom = clamp(initialZoom, minZoom, maxZoom);
		step = Math.max(0.01, step);

		var rect = viewport.getBoundingClientRect();
		var state = {
			inner: inner,
			scale: clamp(initialZoom, minZoom, maxZoom),
			x: 0,
			y: 0,
			minZoom: minZoom,
			maxZoom: maxZoom,
			step: step,
			hasInteracted: false,
			imageWidth: 0,
			imageHeight: 0
		};

		var isPointerDown = false;
		var startX = 0;
		var startY = 0;
		var initialX = 0;
		var initialY = 0;

		setTransform(state);

		function updateImageDimensions() {
			if (!image) {
				return;
			}
			state.imageWidth = image.naturalWidth || image.width || inner.offsetWidth;
			state.imageHeight = image.naturalHeight || image.height || inner.offsetHeight;
			if (state.imageWidth === 0 || state.imageHeight === 0) {
				var bounds = inner.getBoundingClientRect();
				if (bounds.width && bounds.height) {
					state.imageWidth = bounds.width / state.scale;
					state.imageHeight = bounds.height / state.scale;
				}
			}
		}

		function centerImage() {
			if (!image) {
				setTransform(state);
				return;
			}
			var viewportRect = viewport.getBoundingClientRect();
			var scaledWidth = state.imageWidth * state.scale;
			var scaledHeight = state.imageHeight * state.scale;
			state.x = (viewportRect.width - scaledWidth) / 2;
			state.y = (viewportRect.height - scaledHeight) / 2;
			setTransform(state);
		}

		function initializeLayout() {
			updateImageDimensions();
			centerImage();
		}

		if (image) {
			if (image.complete) {
				initializeLayout();
			} else {
				image.addEventListener('load', initializeLayout, { once: true });
				image.addEventListener('error', initializeLayout, { once: true });
			}
		} else {
			setTransform(state);
		}

		function handlePointerDown(event) {
			if (!enableDrag) {
				return;
			}
			event.preventDefault();
			isPointerDown = true;
			state.hasInteracted = true;
			viewport.classList.add('is-dragging');
			startX = event.clientX;
			startY = event.clientY;
			initialX = state.x;
			initialY = state.y;
			if (typeof viewport.setPointerCapture === 'function') {
				viewport.setPointerCapture(event.pointerId);
			}
			if (typeof viewport.focus === 'function') {
				viewport.focus();
			}
		}

		function handlePointerMove(event) {
			if (!isPointerDown) {
				return;
			}
			event.preventDefault();
			var deltaX = event.clientX - startX;
			var deltaY = event.clientY - startY;
			state.x = initialX + deltaX;
			state.y = initialY + deltaY;
			setTransform(state);
		}

		function handlePointerUp(event) {
			if (!isPointerDown) {
				return;
			}
			isPointerDown = false;
			viewport.classList.remove('is-dragging');
			if (typeof viewport.releasePointerCapture === 'function' && viewport.hasPointerCapture && viewport.hasPointerCapture(event.pointerId)) {
				viewport.releasePointerCapture(event.pointerId);
			}
		}

		function handleWheel(event) {
			if (!enableWheel) {
				return;
			}
			event.preventDefault();
			state.hasInteracted = true;
			rect = viewport.getBoundingClientRect();
			var offsetX = event.clientX - rect.left - state.x;
			var offsetY = event.clientY - rect.top - state.y;
			var direction = event.deltaY > 0 ? -1 : 1;
			var nextScale = state.scale + direction * state.step;
			updateScale(state, nextScale, offsetX, offsetY);
		}

		function zoom(delta) {
			rect = viewport.getBoundingClientRect();
			var centerX = rect.width / 2;
			var centerY = rect.height / 2;
			var nextScale = state.scale + delta;
			state.hasInteracted = true;
			updateScale(state, nextScale, centerX, centerY);
		}

		function handleResize() {
			updateImageDimensions();
			if (!state.hasInteracted) {
				centerImage();
			}
		}

		function observeResizeTarget(target) {
			if (typeof window.ResizeObserver === 'undefined' || !target) {
				return null;
			}
			var observer = new ResizeObserver(function () {
				handleResize();
			});
			observer.observe(target);
			return observer;
		}

		viewport.addEventListener('pointerdown', handlePointerDown, { passive: false });
		viewport.addEventListener('pointermove', handlePointerMove, { passive: false });
		viewport.addEventListener('pointerup', handlePointerUp);
		viewport.addEventListener('pointerleave', handlePointerUp);
		viewport.addEventListener('pointercancel', handlePointerUp);

		if (enableWheel) {
			viewport.addEventListener('wheel', handleWheel, { passive: false });
		}

		var zoomInButton = container.querySelector('[data-action="zoom-in"]');
		var zoomOutButton = container.querySelector('[data-action="zoom-out"]');

		if (zoomInButton) {
			zoomInButton.addEventListener('click', function () {
				zoom(state.step);
			});
		}

		if (zoomOutButton) {
			zoomOutButton.addEventListener('click', function () {
				zoom(-state.step);
			});
		}

		container.addEventListener('keydown', function (event) {
			if (!container.contains(document.activeElement)) {
				return;
			}
			if (event.key === '+' || event.key === '=') {
				event.preventDefault();
				zoom(state.step);
			} else if (event.key === '-' || event.key === '_') {
				event.preventDefault();
				zoom(-state.step);
			}
		});

		window.addEventListener('resize', handleResize);
		var resizeObserver = observeResizeTarget(viewport);
		requestAnimationFrame(function () {
			handleResize();
		});
	}

	function registerElementorHook() {
		if (typeof window.elementorFrontend === 'undefined' || !window.elementorFrontend.hooks || typeof window.elementorFrontend.hooks.addAction !== 'function') {
			return false;
		}

		window.elementorFrontend.hooks.addAction('frontend/element_ready/soda-image-pan-zoom.default', function ($scope) {
			initPanZoom($scope);
		});

		return true;
	}

	function waitForElementor() {
		if (!registerElementorHook()) {
			window.requestAnimationFrame(waitForElementor);
		}
	}

	if (typeof window.jQuery !== 'undefined') {
		window.jQuery(window).on('elementor/frontend/init', registerElementorHook);
	}

	waitForElementor();
})();
