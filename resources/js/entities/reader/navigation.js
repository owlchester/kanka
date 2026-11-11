export const readHash = (hash) => {
    try {
        return decodeURIComponent(hash.replace(/^#/, ''));
    } catch {
        return '';
    }
};

export const postIdFromHash = (hash) => readHash(hash).match(/^post-([1-9]\d*)$/)?.[1] ?? null;

export const sectionSlug = (text) => text.normalize('NFKD')
    .replace(/\p{M}/gu, '')
    .toLowerCase()
    .replace(/[^\p{L}\p{N}]+/gu, '-')
    .replace(/^-|-$/g, '')
    .slice(0, 64) || 'section';

export const collectSections = (story, storyLabel) => {
    if (!story) {
        return [];
    }

    const sections = [];
    story.querySelectorAll('.box-entity-entry, .post-block').forEach((block) => {
        const isPost = block.classList.contains('post-block');
        const label = isPost ? block.querySelector('.post-title')?.textContent.trim() : storyLabel;
        if (block.id && label) {
            sections.push({ id: block.id, label, nested: false });
        }

        const body = block.querySelector(isPost ? '.post-body' : '.entity-content');
        body?.querySelectorAll('h1, h2, h3, h4, h5, h6').forEach((heading) => {
            // Embedded interactive components aren't part of the author's outline.
            if (heading.closest('.js-map-preview')) {
                return;
            }
            const label = heading.textContent.trim().replace(/\s+/g, ' ');
            if (!label) {
                return;
            }
            if (!heading.id) {
                const base = `reader-section-${block.id}-${sectionSlug(label)}`;
                let id = base;
                let suffix = 2;
                while (heading.ownerDocument.getElementById(id)) {
                    id = `${base}-${suffix++}`;
                }
                heading.id = id;
            }
            sections.push({ id: heading.id, label, nested: true });
        });
    });
    return sections;
};

export const scrollToSection = (target) => {
    const post = target.closest('.post-block');
    if (post) {
        post.querySelector('.entity-content')?.classList.remove('hidden');
        post.querySelector('.element-toggle')?.classList.remove('animate-collapsed');
        post.querySelector('.post-title')?.classList.remove('collapsed');
    }
    for (let parent = target.parentElement; parent; parent = parent.parentElement) {
        if (parent.tagName === 'DETAILS') {
            parent.open = true;
        }
    }

    if (!target.hasAttribute('tabindex')) {
        target.setAttribute('tabindex', '-1');
    }
    target.focus({ preventScroll: true });
    const header = document.getElementById('header');
    const navigation = target.closest('.entity-grid')?.querySelector('.entity-mobile-navigation');
    const offset = (header?.getBoundingClientRect().height ?? 0)
        + (navigation?.getBoundingClientRect().height ?? 0) + 16;
    window.scrollTo({
        top: Math.max(0, window.scrollY + target.getBoundingClientRect().top - offset),
        behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth',
    });
};
