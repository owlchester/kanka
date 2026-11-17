import { postIdFromHash, scrollToSection } from './entities/reader/navigation';

const mountReaders = () => {
    const nodes = document.querySelectorAll('.js-entity-reader:not([data-reader-mounted])');
    if (nodes.length) {
        import('./entities/reader').then(({ mountReaders }) => mountReaders(nodes));
    }
};
mountReaders();

/**
 * Mount the Vue map preview on any `field:map` mention rendered inline in an entity's
 * or post's entry. Kept out of the main bundle (dynamic import) so pages without a map
 * mention never pull in Leaflet. Re-run on the `kanka.default` pub-sub so mentions that
 * arrive later (paginated/anchor-loaded posts) still get mounted.
 */
const mountEventParticipants = () => {
    if (document.querySelector('.js-event-participants')) {
        import('./events/participants').then(({ mountParticipants }) => mountParticipants());
    }
};
mountEventParticipants();
window.onEvent(mountEventParticipants);

const scanAndMountMapPreviews = () => {
    const nodes = document.querySelectorAll('.js-map-preview:not(.js-map-preview-mounted)');
    if (!nodes.length) {
        return;
    }

    nodes.forEach((node) => node.classList.add('js-map-preview-mounted'));
    import('./maps/preview-runtime.js').then(({ mountMapPreviews }) => mountMapPreviews(nodes));
};

/**
 * Expand/Collapse all posts on the overview of an entity
 */
const registerStoryActions = () => {
    const collapse = document.querySelector('.btn-post-collapse');
    collapse?.addEventListener('click', function (e) {
        e.preventDefault();
        let elements = document.querySelectorAll('.post-block .element-toggle');
        elements.forEach((e) => {
            e.classList.add('animate-collapsed');
            let target = document.querySelector(e.dataset.target);
            target.classList.add('hidden');
        });
    });

    const expand = document.querySelector('.btn-post-expand');
    expand?.addEventListener('click', function (e) {
        e.preventDefault();
        let elements = document.querySelectorAll('.post-block .element-toggle');
        elements.forEach((e) => {
            e.classList.remove('animate-collapsed');
            let target = document.querySelector(e.dataset.target);
            target.classList.remove('hidden');
        });
    });
};


/*
 *
 */
const registerStoryLoadMore = () => {
    const more = document.querySelector('.story-load-more');
    more?.addEventListener('click', function (e) {
        e.preventDefault();

        this.classList.add('loading');

        axios.get(this.dataset.url)
            .then(result => {
                more.parentNode.remove();
                console.log(result);
                document.querySelector('.entity-posts').insertAdjacentHTML('beforeend', result.data);
                registerStoryLoadMore();
                registerStoryActions();
                window.triggerEvent();
            })
            .catch(() => {
                more.classList.remove('loading');
            });
        return false;
    });
};

/**
 * When clicking on an entity link to an external domain, give the user the opportunity
 * to trust the domain to not be asked again in the future if they are okay with leaving kanka.
 */
const registerTrustDomain = () => {
    const btn = document.querySelector('.domain-trust');
    if (!btn) {
        return;
    }
    btn.addEventListener('click', function (e) {
        const cookieName = 'kanka_trusted_domains';

        let keyValue = document.cookie.match('(^|;) ?' + cookieName + '=([^;]*)(;|$)');
        keyValue = keyValue ? keyValue[2] : '';

        // If not yet in it
        const newDomain = btn.dataset.domain;
        if (!keyValue.includes(newDomain)) {
            if (keyValue) {
                keyValue += '|';
            }
            keyValue += newDomain;
        }

        let expires = new Date();
        expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = cookieName + '=' + keyValue + ';path=/;expires=' + expires.toUTCString() + ';sameSite=Strict';
    });
};

/**
 * Highlight every literal occurrence of the search term passed by the command center.
 * Text fragments only highlight one match, so this works across all rendered entity content.
 */
let searchHighlightScrolled = false;

const highlightSearchTerm = () => {
    const term = new URLSearchParams(window.location.search).get('highlight')?.trim();
    if (!term) {
        return;
    }

    const roots = document.querySelectorAll('.box-entity-entry .entity-content, .post-block .entity-content');
    if (!roots.length) {
        return;
    }

    const escapedTerm = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const matcher = new RegExp(escapedTerm, 'gi');
    const marks = [];
    const excludedTags = new Set(['BUTTON', 'INPUT', 'OPTION', 'SCRIPT', 'SELECT', 'STYLE', 'TEXTAREA']);

    roots.forEach((root) => {
        const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
        const textNodes = [];
        let node;

        while ((node = walker.nextNode())) {
            const parent = node.parentElement;
            if (!parent || excludedTags.has(parent.tagName) || parent.closest('mark')) {
                continue;
            }
            textNodes.push(node);
        }

        textNodes.forEach((textNode) => {
            matcher.lastIndex = 0;
            if (!matcher.test(textNode.nodeValue)) {
                return;
            }

            matcher.lastIndex = 0;
            const fragment = document.createDocumentFragment();
            let lastIndex = 0;
            let match;

            while ((match = matcher.exec(textNode.nodeValue)) !== null) {
                if (match.index > lastIndex) {
                    fragment.append(document.createTextNode(textNode.nodeValue.slice(lastIndex, match.index)));
                }

                const mark = document.createElement('mark');
                mark.className = 'kanka-search-highlight';
                mark.textContent = match[0];
                fragment.append(mark);
                marks.push(mark);
                lastIndex = match.index + match[0].length;
            }

            if (lastIndex < textNode.nodeValue.length) {
                fragment.append(document.createTextNode(textNode.nodeValue.slice(lastIndex)));
            }
            textNode.replaceWith(fragment);
        });
    });

    marks.forEach((mark) => {
        const post = mark.closest('.post-block');
        const content = mark.closest('.entity-content');
        if (post && content?.classList.contains('hidden')) {
            content.classList.remove('hidden');
            post.querySelector('.element-toggle')?.classList.remove('animate-collapsed');
        }
    });

    if (!searchHighlightScrolled && marks.length > 0) {
        searchHighlightScrolled = true;
        requestAnimationFrame(() => marks[0].scrollIntoView({ behavior: 'smooth', block: 'center' }));
    }
};

/**
 * When loading an entity, a post anchor might be set but not visible due to pagination
 */
const loadingAnchorPosts = new Set();
const registerLoadAnchorPost = () => {
    const id = postIdFromHash(window.location.hash);
    if (!id) {
        return;
    }
    const postId = `post-${id}`;
    let selector = document.getElementById(postId);
    if (selector) {
        scrollToSection(selector);
        return;
    }

    // Try loading from the backend
    let config = document.getElementById('post-anchor-loader');
    if (!config || loadingAnchorPosts.has(id)) {
        return;
    }

    loadingAnchorPosts.add(id);
    const url = config.dataset.url.replace(/\/0(?=\/|\?|$)/, '/' + id);
    axios.get(url)
        .then(res => {
            config.insertAdjacentHTML('afterbegin', res.data);
            window.triggerEvent();

            selector = document.getElementById(postId);
            if (selector && postIdFromHash(window.location.hash) === id) {
                scrollToSection(selector);
            }
        })
        .catch(() => {
            // An inaccessible or deleted post must not break the rest of the reader.
        })
        .finally(() => loadingAnchorPosts.delete(id));
};


registerStoryActions();
registerStoryLoadMore();
registerTrustDomain();
registerLoadAnchorPost();
window.addEventListener('hashchange', registerLoadAnchorPost);
scanAndMountMapPreviews();
highlightSearchTerm();
window.onEvent(scanAndMountMapPreviews);
window.onEvent(highlightSearchTerm);
