import Conversation from "./components/Conversation";
import Message from "./components/conversation/Message";
import Messages from "./components/conversation/Messages";
import Form from "./components/conversation/Form";

window.Vue = require('vue');

Vue.component('conversation', Conversation);
Vue.component('conversation-messages', Messages);
Vue.component('conversation-message', Message);
Vue.component('conversation-form', Form);

const app = new Vue({
    el: '#conversation'
});



var conversationBody, conversationSend, conversationMessage, conversationContext;
var conversationLoadPrevious;
var conversationToggles, conversationBox;
var conversationCurrentConversation;

$(document).ready(function() {
    conversationBody = $('#conversation_body');
    conversationToggles = $('[data-toggle="conversation"]');

    if (conversationToggles.length > 0) {
        initConversations();
    }

    if (conversationBody.length === 1) {
        initConversation();
    }
});

/**
 *
 */
function initConversations()
{
    conversationBox = $('#conversation_box');

    conversationToggles.each(function(i) {
        $(this).on('click', function(e) {
            e.preventDefault();

            // Don't re-load if already viewing
            if (conversationCurrentConversation == $(this).attr('href')) {
                return false;
            }
            conversationCurrentConversation = $(this).attr('href');

            conversationBox.html('<i class="fa fa-spinner fa-spin"></i>');
            $(this).parent().addClass('active');

            $.ajax(
                $(this).attr('href')
            ).done(function(data) {
                conversationBox.html(data);
                initConversation();
                window.crudInitAjaxModal();
            });

            return false;
        });
    });
}

/**
 *
 */
function initConversation()
{
    // Save references
    conversationBody = $('#conversation_body');
    conversationSend = $('#conversation_send');
    conversationContext = $("input[name='context']");
    conversationMessage = $("input[name='message']");

    // Load the first messages
    // $.ajax(
    //     conversationBody.data('url')
    // ).done(function(data) {
    //     conversationBody.html(data);
    //     scrollToBottom(conversationBody);
    //     initLoadPrevious();
    // });
    scrollToBottom(conversationBody);
    initLoadPrevious();
    registerActions();

    conversationSend.on('submit', function (e) {
        e.preventDefault();
        var text = conversationContext.val();
        if (!text || text.length === 0 || !text.trim()) {
            return false;
        }

        newest = $('.box-comment').last().data('id');
        conversationMessage.val(text);
        conversationContext.prop('disabled', true);
        $.ajax({
           type: "POST",
           url: $(this).attr('action') + '?newest=' + newest,
           data: $(this).serialize()
        }).done(function(data) {
            // Add new messages
            conversationBody.append(data);
            conversationContext.val('');
            conversationMessage.val('');
            conversationContext.prop('disabled', false);
            conversationContext.focus();

            // Scroll to bottom
            scrollToBottom(conversationBody);
            registerActions();
        }).fail(function (data) {
           console.error("Failed Post", data);
        });
        return false;
    });
}

function initLoadPrevious()
{
    conversationLoadPrevious = $('#conversation_load_previous');
    if (conversationLoadPrevious.length === 1) {
        conversationLoadPrevious.on('click', function (e) {
            //console.log('load previous url', $(this).data('url'));
            conversationLoadPrevious.html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax(
                $(this).data('url')
            ).done(function (data) {
                conversationLoadPrevious.remove();
                conversationBody.prepend(data);
                initLoadPrevious();
            });
        });
    }
}
/**
 * Scroll to the bottom of an element.
 * @param element
 */
function scrollToBottom(element)
{
    element.scrollTop(element.prop('scrollHeight'));
}

function registerActions()
{
    // Delete confirm dialog
    $.each($('.delete-message'), function (index) {
        $(this).click(function (e) {
            var name = $(this).data('name');
            var target = $(this).data('delete-target');
            $('#delete-confirm-name').text(name);
            $('#delete-confirm-submit').data('target', target);
        });
    });
}
