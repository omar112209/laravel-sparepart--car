import './bootstrap';

/* ===== LOADING OVERLAY ===== */
(function () {
    const overlay = document.getElementById('loading-overlay');
    if (!overlay) return;
    window.addEventListener('load', function () {
        setTimeout(function () {
            overlay.classList.add('hide');
            document.body.style.overflow = '';
        }, 400);
    });
    setTimeout(function () {
        if (!overlay.classList.contains('hide')) {
            overlay.classList.add('hide');
            document.body.style.overflow = '';
        }
    }, 5000);
})();

/* ===== BUTTON LOADING STATE ===== */
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-loading-click');
    if (!btn || btn.classList.contains('btn-loading')) return;
    const form = btn.closest('form');
    if (form) {
        if (!form.checkValidity()) return;
    }
    btn.classList.add('btn-loading');
});

/* ===== IMAGE LAZY LOAD ===== */
(function () {
    if (!('IntersectionObserver' in window)) return;
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            const img = entry.target;
            const src = img.getAttribute('data-src');
            if (src) {
                img.src = src;
                img.removeAttribute('data-src');
            }
            img.classList.add('loaded');
            observer.unobserve(img);
        });
    }, { rootMargin: '200px' });
    document.querySelectorAll('.img-lazy').forEach(function (img) {
        observer.observe(img);
    });
})();

/* ===== SCROLL REVEAL ===== */
(function () {
    if (!('IntersectionObserver' in window)) return;
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal').forEach(function (el) {
        observer.observe(el);
    });
})();

/* ===== TOAST ===== */
(function () {
    window.showToast = function (message, type) {
        type = type || 'info';
        var container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        var icons = { success: 'fa-check', error: 'fa-times', info: 'fa-info' };
        var toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = '<span class="toast-icon ' + type + '"><i class="fa ' + (icons[type] || icons.info) + '"></i></span>'
            + '<span>' + message + '</span>'
            + '<button class="toast-close">&times;</button>';
        container.appendChild(toast);
        toast.querySelector('.toast-close').addEventListener('click', function () {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(40px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(function () { toast.remove(); }, 300);
        });
        setTimeout(function () {
            if (toast.parentNode) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(40px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(function () { toast.remove(); }, 300);
            }
        }, 4000);
    };
})();

/* ===== SKELETON PLACEHOLDER FOR IMAGES ===== */
(function () {
    document.querySelectorAll('.img-skeleton').forEach(function (wrapper) {
        var img = wrapper.querySelector('img');
        if (!img) return;
        if (img.complete && img.naturalWidth > 0) {
            wrapper.classList.add('loaded');
        } else {
            img.addEventListener('load', function () { wrapper.classList.add('loaded'); });
            img.addEventListener('error', function () { wrapper.classList.add('loaded'); });
        }
    });
})();
