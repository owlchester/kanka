/**
 * Mount the Vue map preview on any `field:map` mention rendered inline in an entity's
 * or post's entry. Kept out of the main bundle (dynamic import) so pages without a map
 * mention never pull in Leaflet. Re-run on the `kanka.default` pub-sub so mentions that
 * arrive later (paginated/anchor-loaded posts) still get mounted.
 */
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
        let elements = document.querySelectorAll('.element-toggle');
        elements.forEach((e) => {
            e.classList.add('animate-collapsed');
            let target = document.querySelector(e.dataset.target);
            target.classList.add('hidden');
        });
    });

    const expand = document.querySelector('.btn-post-expand');
    expand?.addEventListener('click', function (e) {
        e.preventDefault();
        let elements = document.querySelectorAll('.element-toggle');
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
 * When loading an entity, a post anchor might be set but not visible due to pagination
 */
const registerLoadAnchorPost = () => {
    let postId = window.location.hash.substring(1); // Remove the '#' character
    if (!postId) {
        return;
    }
    let selector = document.getElementById(postId);
    if (selector) {
        return;
    }

    // Try loading from the backend
    let config = document.getElementById('post-anchor-loader');
    if (!config) {
        return;
    }

    let realPostId = postId.match(/\d+$/);
    let url = config.dataset.url.replace('/0', '/' + realPostId);
    axios.get(url)
        .then(res => {
            config.insertAdjacentHTML('afterbegin', res.data);
            window.triggerEvent();

            selector = document.getElementById(postId);
            window.scrollTo({
                top: selector.offsetTop,
                behavior: 'smooth'
            });
        });
};


registerStoryActions();
registerStoryLoadMore();
registerTrustDomain();
registerLoadAnchorPost();
scanAndMountMapPreviews();
window.onEvent(scanAndMountMapPreviews);
