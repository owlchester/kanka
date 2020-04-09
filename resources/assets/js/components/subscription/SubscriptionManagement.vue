<template>
    <div>
        <div v-show="paymentMethodsLoadStatus != 2" class="text-center">
            <i class="fa fa-spin fa-spinner"></i>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2
    && paymentMethods.length > 0">
        </div>
        <div v-show="paymentMethodsLoadStatus == 2 && paymentMethods.length == 0">
            <p class="help-block">
                {{ $t('settings.subscription.payment_method.add_one' )}}
            </p>
        </div>

        <div v-show="paymentMethodSelected">
            <h4 class="mt-3 mb-3">{{ $t('settings.subscription.subscription.select' )}}</h4>

            <div class="row" v-show="plansLoadStatus == 2">
                <div v-for="plan in plans" class="col-xs-6">
                        <div class="box box-widget widget-user widget-patron">
                            <div v-bind:class="planHeaderClass(plan)">
                                <h3 class="widget-user-username">{{ plan.name }}</h3>
                                <h5 class="widget-user-desc">{{ this.currency }}{{ plan.price}}</h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" v-bind:src="plan.image" v-bind:alt="plan.name">
                            </div>
                            <div class="box-body">
                                <dl class="row">
                                    <template v-for="(feature, value) in plan.benefits">
                                        <div class="col-xs-9 col-sm-8" v-html="value"></div>
                                        <div class="col-xs-3 col-sm-4" v-html="feature"></div>
                                    </template>
                                </dl>

                                <div class="text-center">
                                    <button v-show="savingSubscriptionStatus == 0" class="btn btn-primary mt-3" id="add-card-button" v-on:click="updateSubscription(plan.key)">
                                        {{ $t('settings.subscription.subscription.actions.subscribe' )}}
                                    </button>
                                    <button v-show="savingSubscriptionStatus != 0" class="btn btn-primary" disabled="disabled">
                                        <i class="fa fa-spin fa-spinner"></i> {{ $t('settings.subscription.subscription.actions.processing' )}}
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'api_token',
            'currency'
        ],

        data(){
            return {
                stripe: '',
                elements: '',
                card: '',
                intentToken: '',

                name: '',

                paymentMethods: [],
                paymentMethodsLoadStatus: 0,
                paymentMethodSelected: 0,

                plans: [],
                plansLoadStatus: 0,

                selectedPlan: '',

                savingSubscriptionStatus: 0,
            }
        },


        mounted(){
            this.includeStripe('js.stripe.com/v3/', function(){
                this.configureStripe();
            }.bind(this) );

            this.loadIntent();
            this.loadPaymentMethods();
            this.loadPlans();
        },

        methods: {
            /*
                Includes Stripe.js dynamically
            */
            includeStripe(URL, callback) {
                let documentTag = document, tag = 'script',
                        object = documentTag.createElement(tag),
                        scriptTag = documentTag.getElementsByTagName(tag)[0];
                object.src = '//' + URL;
                if (callback) {
                    object.addEventListener('load', function (e) {
                        callback(null, e);
                    }, false);
                }
                scriptTag.parentNode.insertBefore(object, scriptTag);
            },

            /*
                Configures Stripe by setting up the elements and
                creating the card element.
            */
            configureStripe() {
                this.stripe = Stripe(this.api_token);

                this.elements = this.stripe.elements();
            },
            /*
                Loads the payment intent key for the user to pay.
            */
            loadIntent() {
                axios.get('/subscription-api/setup-intent')
                        .then(function (response) {
                            this.intentToken = response.data;
                        }.bind(this));
            },

            /*
                Loads all of the payment methods for the
                user.
            */
            loadPaymentMethods() {
                this.paymentMethodsLoadStatus = 1;
                axios.get('/subscription-api/payment-methods')
                        .then(function (response) {
                            this.paymentMethods = response.data;
                            this.paymentMethodsLoadStatus = 2;
                            this.paymentMethodSelected = response.data[0]; // only support one payment method
                        }.bind(this));
            },

            /*
                Loads all of the plans.
            */
            loadPlans() {
                this.plansLoadStatus = 1;
                axios.get('/subscription-api/plans')
                        .then(function (response) {
                            this.plans = response.data;
                            this.plansLoadStatus = 2;
                        }.bind(this));
            },

            updateSubscription(planId) {
                this.savingSubscriptionStatus = 1;
                axios.put('/subscription-api/subscription', {
                    plan: planId,
                    payment: this.paymentMethodSelected.id
                }).then(function (response) {
                    this.savingSubscriptionStatus = 0;
                    alert('You Are Subscribed!');
                }.bind(this));
            },

            planHeaderClass(plan) {
                return 'widget-user-header bg-' + plan.colour + '-active';
            },

            toggleShowNewPaymentMethod() {
                this.showNewPaymentMethod = !this.showNewPaymentMethod;
            }
        },
    }
</script>
