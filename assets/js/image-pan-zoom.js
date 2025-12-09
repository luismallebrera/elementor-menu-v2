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
		if (!viewport || !inner) {
			return;
		}

		var enableWheel = container.getAttribute('data-enable-wheel') === 'true';
		var enableDrag = container.getAttribute('data-enable-drag') === 'true';
		var minZoom = parseFloat(container.getAttribute('data-min-zoom')) || 1;
		var maxZoom = parseFloat(container.getAttribute('data-max-zoom')) || 4;
		var initialZoom = parseFloat(container.getAttribute('data-initial-zoom')) || 1;
		var step = parseFloat(container.getAttribute('data-zoom-step')) || 0.2;

		var rect = viewport.getBoundingClientRect();
		var state = {
			inner: inner,
			scale: clamp(initialZoom, minZoom, maxZoom),
			x: 0,
			y: 0,
			minZoom: minZoom,
			maxZoom: maxZoom,
			step: step
		};

		var isPointerDown = false;
		var startX = 0;
		var startY = 0;
		var initialX = 0;
		var initialY = 0;

		setTransform(state);

		function handlePointerDown(event) {
			if (!enableDrag) {
				return;
			}
			isPointerDown = true;
			viewport.classList.add('is-dragging');
			startX = event.clientX;
			startY = event.clientY;
			initialX = state.x;
			initialY = state.y;
			if (typeof viewport.setPointerCapture === 'function') {
				viewport.setPointerCapture(event.pointerId);
			}
		}

		function handlePointerMove(event) {
			if (!isPointerDown) {
				return;
			}
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
			updateScale(state, nextScale, centerX, centerY);
		}

		viewport.addEventListener('pointerdown', handlePointerDown);
		viewport.addEventListener('pointermove', handlePointerMove);
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
	}

	function registerElementorHook() {
		if (typeof window.elementorFrontend === 'undefined' || !window.elementorFrontend.hooks || typeof window.elementorFrontend.hooks.addAction !== 'function') {
			return;
		}

		window.elementorFrontend.hooks.addAction('frontend/element_ready/soda-image-pan-zoom.default', function ($scope) {
			initPanZoom($scope);
		});
	}

	if (typeof window.jQuery !== 'undefined') {
		window.jQuery(window).on('elementor/frontend/init', registerElementorHook);
	} else {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', registerElementorHook);
		} else {
			registerElementorHook();
		}
	}
})();
