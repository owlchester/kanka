<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'    => 'These credentials do not match our records.',
    'helpers'   => [
        'password'  => 'Show / Hide password',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Password',
        ],
        'login_with_facebook'   => 'Login with Facebook',
        'login_with_google'     => 'Login with Google',
        'login_with_twitter'    => 'Login with Twitter',
        'new_account'           => 'Register a new account',
        'or'                    => 'OR',
        'password_forgotten'    => 'Forgot your password?',
        'remember_me'           => 'Remember me',
        'submit'                => 'Login',
        'title'                 => 'Login',
    ],
    'register'  => [
        'already_account'           => 'Already have an account?',
        'email'                     => [
            'body'  => '<p>Welcome to kanka.io!</p><p>Your account has been created using your email address.</p>',
            'login' => 'Log in',
            'title' => 'Getting Started with Kanka',
        ],
        'errors'                    => [
            'email_already_taken'   => 'An account with this email is already registered.',
            'general_error'         => 'An error occurred while registering your account. Please try again.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Username',
            'password'  => 'Password',
            'tos'       => 'I agree to the <a href=":privacyUrl" target="_blank">Privacy Policy</a>.',
        ],
        'register_with_facebook'    => 'Register with Facebook',
        'register_with_google'      => 'Register with Google',
        'register_with_twitter'     => 'Register with Twitter',
        'submit'                    => 'Register',
        'title'                     => 'Register',
        'welcome_email'             => [
            'header'        => 'Welcome to Kanka :name!',
            'header_sub'    => 'Congratulations, you have taken the first step in the creation of your world on :kanka!',
            'section_1'     => 'Where to now?',
            'section_10'    => 'Patrons',
            'section_11'    => 'Create your world,',
            'section_2'     => 'The most important resource is :discord, where you will find plenty of our dedicated users, an onboarding team, as well as the founder of Kanka, who can answer any questions that you may have.',
            'section_3'     => 'Our :faq also covers the most recurring questions.',
            'section_4'     => 'Our :youtube has videos covering the basics of Kanka. While not all topics are covered yet, we regularly add new videos.',
            'section_5'     => 'Youtube Channel',
            'section_6'     => 'Contact us',
            'section_7'     => 'If you haven’t found an answer to your questions, or simply want to get in touch, you can find us on :facebook, or you can email us at :email. We are a small team of 2 friends, but we make sure to answer every email we receive, so please do not hesitate!',
            'section_8'     => 'One last thing',
            'section_9'     => 'We have made sure that all the core features in Kanka are free, and we will always keep it that way. However, if you want to support us in this project, you can join our ranks of :patrons, and gain access to additional features, as well as our eternal gratitude!',
            'title'         => 'Getting started with Kanka',
        ],
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Email Address',
            'password'              => 'Password',
            'password_confirmation' => 'Confirm your password',
        ],
        'send'      => 'Send Password Reset Link',
        'submit'    => 'Reset password',
        'title'     => 'Reset password',
    ],
    'throttle'  => 'Too many login attempts. Please try again in :seconds seconds.',
];
