const themeToggle = document.querySelector('[data-theme-toggle]');
const root = document.documentElement;

function setTheme(dark) {
    root.dataset.theme = dark ? 'dark' : 'light';
    themeToggle.setAttribute('aria-pressed', String(dark));
    themeToggle.title = dark ? 'تفعيل الوضع الفاتح' : 'تفعيل الوضع الداكن';
}

setTheme(root.dataset.theme === 'dark');
themeToggle.addEventListener('click', () => {
    const dark = root.dataset.theme !== 'dark';
    setTheme(dark);
    try {
        localStorage.setItem('darkMode', String(dark));
    } catch {
        // The page can still change theme if browser storage is disabled.
    }
});

const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.getElementById('site-navigation');
const menuLinks = menu.querySelectorAll('ul a');
const mobileLayout = window.matchMedia('(max-width: 880px)');

function setMenu(open) {
    menu.toggleAttribute('data-open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
}

function updateCurrentLink() {
    const section = window.location.hash || '#top';
    for (const link of menuLinks) {
        if (link.hash === section) {
            link.setAttribute('aria-current', 'location');
        } else {
            link.removeAttribute('aria-current');
        }
    }
}

menuToggle.addEventListener('click', () => setMenu(!menu.hasAttribute('data-open')));
menu.addEventListener('click', (event) => {
    if (event.target.closest('a')) {
        setMenu(false);
    }
});
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menu.hasAttribute('data-open')) {
        setMenu(false);
        menuToggle.focus();
    }
});
mobileLayout.addEventListener('change', () => setMenu(false));
if (menu.hasAttribute('data-section-navigation')) {
    window.addEventListener('hashchange', updateCurrentLink);
    updateCurrentLink();
}

const projectFilters = document.querySelector('[data-project-filters]');
if (projectFilters) {
    const filters = projectFilters.querySelectorAll('button[data-filter]');
    const projects = document.querySelectorAll('[data-project-category]');
    projectFilters.hidden = false;
    projectFilters.addEventListener('click', (event) => {
        const selected = event.target.closest('button[data-filter]');
        if (!selected) {
            return;
        }

        for (const filter of filters) {
            filter.setAttribute('aria-pressed', String(filter === selected));
        }
        for (const project of projects) {
            project.hidden = selected.dataset.filter !== 'all' && selected.dataset.filter !== project.dataset.projectCategory;
        }
    });
}

const quoteActions = document.querySelector('[data-quote-actions]');
if (quoteActions) {
    const quotes = Array.from(document.querySelectorAll('[data-quote]'));
    let active = 0;

    function showQuote(index) {
        active = (index + quotes.length) % quotes.length;
        quotes.forEach((quote, position) => {
            quote.hidden = position !== active;
        });
    }

    quoteActions.querySelector('[data-quote-previous]').addEventListener('click', () => showQuote(active - 1));
    quoteActions.querySelector('[data-quote-next]').addEventListener('click', () => showQuote(active + 1));
    showQuote(0);
    quoteActions.hidden = false;
}

document.querySelector('[data-form-feedback]')?.focus();

const passwordToggle = document.querySelector('[data-password-toggle]');
if (passwordToggle) {
    const password = document.getElementById(passwordToggle.getAttribute('aria-controls'));

    passwordToggle.addEventListener('click', () => {
        const visible = password.type === 'password';
        password.type = visible ? 'text' : 'password';
        passwordToggle.setAttribute('aria-pressed', String(visible));
        passwordToggle.title = visible ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور';
    });
    passwordToggle.hidden = false;
}
