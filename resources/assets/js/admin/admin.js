$(document).ready(function () {
    initTranslationForm();
});

function initTranslationForm()
{
    let selector = $('.form-translations');
    if (selector.length === 0) {
        return;
    }

    selector.submit(function (e) {
        e.preventDefault();

        $(this).find('.btn-submit').hide();
        $(this).find('.btn-ajax').show();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            context: this
        }).done(function (result, textStatus, xhr) {
            $(this).find('.btn-ajax').hide();
            $(this).find('.btn-submit').show();
            if (result.message) {
                $(this).find('.btn-submit').append(result.message);
                $(this).find('.success').delay(1000).fadeOut();
            }
        });
    });
}
