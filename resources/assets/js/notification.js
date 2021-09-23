
/**
 * Notifications: List and Count selector, and seconds for the timeout to refresh the list.
 * Refresh the ui every minute, while the ajax call for new content is done once every 2 minutes
 * for all open tabs.
 */
var notificationList, notificationCount, userID, notificationRefreshTimeout = 60 * 1000;

$(document).ready(function () {
    // Setup
    notificationList = $('#header-notification-list');
    notificationCount = $('#header-notification-count');
    let menu = $('.notifications-menu');
    if (menu) {
        userID = menu.data('user-id');
    } else {
        userID = 0;
    }

    // If we are on the notification page, just clear everything
    if ($('#notification-clear').length === 1) {
        refreshNotifications();
    }
    if (notificationList.length === 1) {
        // Every thirty seconds, we check if the storage was changed.
        updateNotificationUI();
        handleReadAll();
    }
});

function updateNotificationUI() {
    // Only do an ajax call if we haven't done one in a while by looking at the local storage
    let last = localStorage.getItem('last_notification-' + userID);
    let now = new Date().getTime();
    let delay = now - (60 * 5000);

    if (!last || last < delay) {
        refreshNotifications();
    } else {
        // If we have up to date info, show it
        let count = localStorage.getItem('notification-count-' + userID);
        let body = localStorage.getItem('notification-body-' + userID);

        notificationList.html(body);

        if (count > 0) {
            notificationCount.html(count).show();
        } else {
            notificationCount.hide();
        }
        setTimeout(updateNotificationUI, notificationRefreshTimeout);
    }
}

/**
 * Get new data for notifications
 */
function refreshNotifications(url = false) {
    if (!url) {
        url = notificationList.data('url');
    }
    let now = new Date().getTime();
    localStorage.setItem('last_notification-' + userID, now);

    $.ajax(url)
        .done(function(result) {
            localStorage.setItem('notification-body-' + userID, result.body);
            localStorage.setItem('notification-count-' + userID, result.count);
            updateNotificationUI();
        }
    );
}

function handleReadAll() {
    $('#header-notification-mark-all-as-read').click(function (e) {
        refreshNotifications($(this).data('url'));
    });
}
