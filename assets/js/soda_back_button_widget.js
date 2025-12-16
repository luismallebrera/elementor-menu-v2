(function() {
    document.addEventListener('click', function(event) {
        var trigger = event.target.closest('.soda-back-button');
        if (!trigger) {
            return;
        }

        event.preventDefault();

        if (document.referrer && document.referrer !== window.location.href) {
            window.history.back();
            return;
        }

        var fallback = trigger.getAttribute('data-fallback');
        if (fallback) {
            window.location.href = fallback;
            return;
        }

        window.history.back();
    });
})();
