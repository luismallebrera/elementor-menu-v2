'use strict';

(function (window) {
    const documentRef = window.document;
    const DEFAULT_SPEED = 0.65;

    const normaliseScope = (scope) => {
        if (!scope) {
            return documentRef;
        }

        if (scope.jquery) {
            return scope[0] || documentRef;
        }

        if (Array.isArray(scope)) {
            return scope[0] || documentRef;
        }

        return scope;
    };

    const destroyJarallaxInstance = (node) => {
        if (!node) {
            return;
        }

        if (node.jarallax && typeof node.jarallax.destroy === 'function') {
            node.jarallax.destroy();
            return;
        }

        if (typeof window.jarallax === 'function' && node.classList && node.classList.contains('jarallax')) {
            window.jarallax(node, 'destroy');
        }
    };

    const parseSpeed = (node) => {
        if (!node) {
            return DEFAULT_SPEED;
        }

        const attr = node.getAttribute('data-soda-parallax-speed');

        if (attr === null || attr === '') {
            return DEFAULT_SPEED;
        }

        const parsed = parseFloat(attr);

        if (Number.isNaN(parsed)) {
            return DEFAULT_SPEED;
        }

        return parsed;
    };

    const initBackgroundParallax = (scope) => {
        if (typeof window.jarallax !== 'function') {
            return;
        }

        const context = normaliseScope(scope) || documentRef;
        const targets = context.querySelectorAll('[data-soda-parallax="true"]');

        if (!targets.length) {
            return;
        }

        targets.forEach((node) => destroyJarallaxInstance(node));

        targets.forEach((node) => {
            const speed = parseSpeed(node);

            window.jarallax(node, {
                speed,
                type: 'scroll',
            });
        });
    };

    const initElementParallax = (scope) => {
        if (typeof window.jarallaxElement !== 'function') {
            return;
        }

        const context = normaliseScope(scope) || documentRef;
        const nodes = context.querySelectorAll('[data-jarallax-element]');

        if (!nodes.length) {
            return;
        }

        window.jarallaxElement(nodes);
    };

    const initScope = (scope) => {
        initBackgroundParallax(scope);
        initElementParallax(scope);
    };

    const onDomReady = () => initScope(documentRef);

    if (documentRef.readyState === 'loading') {
        documentRef.addEventListener('DOMContentLoaded', onDomReady, { once: true });
    } else {
        onDomReady();
    }

    if (window.elementorFrontend && window.elementorFrontend.hooks) {
        const hookCallback = (scope) => {
            initScope(normaliseScope(scope));
        };

        window.elementorFrontend.hooks.addAction('frontend/element_ready/section', hookCallback);
        window.elementorFrontend.hooks.addAction('frontend/element_ready/container', hookCallback);
        window.elementorFrontend.hooks.addAction('frontend/element_ready/widget', hookCallback);
    }
})(window);
