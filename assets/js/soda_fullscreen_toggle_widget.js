(function($) {
    'use strict';

    const registeredButtons = new Set();
    let changeListenersBound = false;

    const callWithPromise = (callback) => {
        try {
            const result = callback();
            if (result && typeof result.then === 'function') {
                return result;
            }
            return Promise.resolve(result);
        } catch (error) {
            return Promise.reject(error);
        }
    };

    const isFullscreen = () => {
        return document.fullscreenElement ||
            document.webkitFullscreenElement ||
            document.mozFullScreenElement ||
            document.msFullscreenElement ||
            false;
    };

    const requestFullscreen = () => {
        const target = document.documentElement;

        if (target.requestFullscreen) {
            return callWithPromise(() => target.requestFullscreen());
        }
        if (target.webkitRequestFullscreen) {
            return callWithPromise(() => target.webkitRequestFullscreen());
        }
        if (target.mozRequestFullScreen) {
            return callWithPromise(() => target.mozRequestFullScreen());
        }
        if (target.msRequestFullscreen) {
            return callWithPromise(() => target.msRequestFullscreen());
        }

        return Promise.reject(new Error('Fullscreen API not supported'));
    };

    const exitFullscreen = () => {
        if (document.exitFullscreen) {
            return callWithPromise(() => document.exitFullscreen());
        }
        if (document.webkitExitFullscreen) {
            return callWithPromise(() => document.webkitExitFullscreen());
        }
        if (document.webkitCancelFullScreen) {
            return callWithPromise(() => document.webkitCancelFullScreen());
        }
        if (document.mozCancelFullScreen) {
            return callWithPromise(() => document.mozCancelFullScreen());
        }
        if (document.msExitFullscreen) {
            return callWithPromise(() => document.msExitFullscreen());
        }

        return Promise.reject(new Error('Fullscreen API not supported'));
    };

    const updateButtonState = (button, active) => {
        const $button = $(button);
        const enterText = $button.data('enter-text') || '';
        const exitText = $button.data('exit-text') || enterText;
        const $label = $button.find('.soda-fullscreen-toggle__label');
        const displayMode = $button.data('display') || 'text';
        const targetText = active ? exitText : enterText;

        if ($label.length) {
            $label.text(targetText);
        } else if (displayMode === 'text') {
            $button.text(targetText);
        }

        $button.attr('aria-pressed', active ? 'true' : 'false');
        $button.attr('aria-label', targetText);

        if (displayMode === 'icon') {
            $button.attr('title', targetText);
        } else {
            $button.removeAttr('title');
        }

        $button.toggleClass('is-active', Boolean(active));
    };

    const syncAllButtons = () => {
        const active = Boolean(isFullscreen());
        registeredButtons.forEach((button) => updateButtonState(button, active));
    };

    const toggleFullscreen = () => {
        if (isFullscreen()) {
            return exitFullscreen();
        }
        return requestFullscreen();
    };

    const bindChangeListeners = () => {
        if (changeListenersBound) {
            return;
        }

        changeListenersBound = true;

        const events = ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'];
        events.forEach((eventName) => {
            document.addEventListener(eventName, syncAllButtons);
        });
    };

    const bindButton = (button) => {
        if (!button || registeredButtons.has(button)) {
            return;
        }

        registeredButtons.add(button);
        updateButtonState(button, Boolean(isFullscreen()));

        $(button).on('click', (event) => {
            event.preventDefault();
            toggleFullscreen()
                .then(syncAllButtons)
                .catch(() => {
                    syncAllButtons();
                });
        });
    };

    const initScope = ($scope) => {
        const button = $scope.find('.soda-fullscreen-toggle__button').get(0);
        if (!button) {
            return;
        }

        bindButton(button);
        bindChangeListeners();
    };

    const initWidget = () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/soda_fullscreen_toggle.default', initScope);
    };

    if (window.elementorFrontend && window.elementorFrontend.hooks) {
        initWidget();
    } else {
        $(window).on('elementor/frontend/init', initWidget);
    }
})(jQuery);
