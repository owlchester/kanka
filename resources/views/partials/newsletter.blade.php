
<div class="card @if (!isset($onlyForm)) mt-4 @endif">
    <div class="card-body">
        @if (!isset($onlyForm))
        <h3 class="card-title">
            {{ __('front/newsletter.title') }}
        </h3>
        <div class="text-muted mb-2">{{ __('front/newsletter.headline') }}</div>

        <a class="btn btn-light" data-toggle="collapse" href="#newsletter-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
            {{ __('front/newsletter.actions.learn_more') }}
        </a>


        <div class="collapse" id="newsletter-collapse">
        @endif
            <!-- Begin Mailchimp Signup Form -->
            <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
            <style type="text/css">
                #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
                #mc_embed_signup .mc-field-group.input-group ul { margin: 0 20px;}
                #mc-embedded-subscribe { margin: 4px 0; }
                /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
                   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
            </style>
            <div id="mc_embed_signup">
                <form action="https://kanka.us19.list-manage.com/subscribe/post?u=e971e01b5e0f6f2597dad7d8f&amp;id=2fb0754d39" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                        <div class="indicates-required"><span class="asterisk">*</span> {{ __('voyager.generic.required') }}</div>
                        <div class="mc-field-group">
                            <label for="mce-EMAIL">{{ __('auth.login.fields.email') }}  <span class="asterisk">*</span>
                            </label>
                            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                        </div>
                        <div class="mc-field-group">
                            <label for="mce-FNAME">{{ __('front/newsletter.fields.firstname') }}</label>
                            <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
                        </div>
                        <div class="mc-field-group">
                            <label for="mce-LNAME">{{ __('front/newsletter.fields.lastname') }}</label>
                            <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
                        </div>
                        <div class="mc-field-group input-group">
                            <strong>{{ __('front/newsletter.fields.notifications') }} </strong>
                            <ul><li><input type="checkbox" value="4" name="group[4868][4]" id="mce-group[4868]-4868-0"><label for="mce-group[4868]-4868-0"> {{ __('front/newsletter.groups.newsletter') }}</label></li>
                                <li><input type="checkbox" value="2" name="group[4868][2]" id="mce-group[4868]-4868-1" @if (!empty($source) && $source == 'news') checked="checked" @endif><label for="mce-group[4868]-4868-1"> {{ __('front/newsletter.groups.news') }}</label></li>
                                <li><input type="checkbox" value="1" name="group[4868][1]" id="mce-group[4868]-4868-2" @if (!empty($source) && $source == 'vote') checked="checked" @endif><label for="mce-group[4868]-4868-2"> {{ __('front/newsletter.groups.community-votes') }}</label></li>
                            </ul>
                        </div>
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_e971e01b5e0f6f2597dad7d8f_2fb0754d39" tabindex="-1" value=""></div>
                        <div class="clear"><input type="submit" value="{{ __('front/newsletter.actions.subscribe') }}" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary"></div>
                    </div>
                </form>
            </div>
            <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
                    <!--End mc_embed_signup-->

        @if (!isset($onlyForm))</div>@endif
    </div>
</div>
