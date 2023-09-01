
<div class="card @if (!isset($onlyForm)) mt-4 @endif">
    <div class="card-body">
        @if (!isset($onlyForm))
        <h3 class="card-title">
            {{ __('front/newsletter.title') }}
        </h3>
        <div class="text-neutral-content">{{ __('front/newsletter.headline', ['kanka' => config('app.name')]) }}</div>

        <a class="btn2 btn-ghost" data-animate="collapse" data-target="#newsletter-collapse" href="#newsletter-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
            {{ __('front/newsletter.actions.learn_more') }}
        </a>


        <div class="hidden my-2" id="newsletter-collapse">
        @endif
            <div id="mc_embed_signup">
                <form action="https://kanka.us19.list-manage.com/subscribe/post?u=e971e01b5e0f6f2597dad7d8f&amp;id=2fb0754d39" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                        <div class="mc-field-group form-group row">
                            <label for="mce-EMAIL" class="col-sm-2 col-form-label">{{ __('auth.login.fields.email') }}  <span class="asterisk text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="email" value="" name="EMAIL" class=" required email" required id="mce-EMAIL">
                            </div>
                        </div>
                        <div class="mc-field-group form-group row">
                            <label for="mce-FNAME" class="col-sm-2 col-form-label">{{ __('front/newsletter.fields.firstname') }}</label>
                            <div class="col-sm-10">
                                <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
                            </div>
                        </div>
                        <div class="mc-field-group form-group row">
                            <label for="mce-LNAME" class="col-sm-2 col-form-label">{{ __('front/newsletter.fields.lastname') }}</label>
                            <div class="col-sm-10">
                                <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">{{ __('settings.menu.notifications') }}</div>

                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input type="checkbox" value="2" name="group[4868][2]" id="mce-group[4868]-4868-1" checked="checked" class="form-check-input">
                                    <label for="mce-group[4868]-4868-1" class="form-check-label">
                                        {{ __('front/newsletter.groups.all') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>

                        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_e971e01b5e0f6f2597dad7d8f_2fb0754d39" tabindex="-1" value=""></div>

                        <div class="mc-field-group form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <div class="clear">
                                    <input type="submit" value="{{ __('front/newsletter.actions.subscribe') }}" name="subscribe" id="mc-embedded-subscribe" class="btn2 btn-primary">
                                </div>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
                    <!--End mc_embed_signup-->

        @if (!isset($onlyForm))</div>@endif
    </div>
</div>
