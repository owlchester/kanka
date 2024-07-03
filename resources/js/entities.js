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


registerStoryActions();
registerStoryLoadMore();
registerTrustDomain();
