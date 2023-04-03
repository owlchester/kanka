<template>
    <div>

        <div v-show="paymentMethodsLoadStatus != 2" class="text-center">
            <i class="fa-solid fa-spin fa-spinner"></i>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2
    && paymentMethods.length > 0">
            <div v-for="(method, key) in paymentMethods"
                 v-bind:key="'method-'+key"
                 class="box box-solid"
            >
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-2">
                            {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
                        </div>
                        <div class="col-xs-7">
                            {{ translate('ending') }}: {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
                        </div>
                        <div class="col-xs-3 text-right">
                            <span v-on:click.stop="removePaymentMethod( method.id )" title="Remove" class="text-red">
                                <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                <span class="sr-only">Remove card</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2 && paymentMethods.length == 0">
            <p class="help-block">
                {{ translate('add_one') }}
                <a href="#" v-on:click.close="toggleShowNewPaymentMethod">
                    <i class="far fa-credit-card" aria-hidden="true"></i> {{ translate('actions.add_new') }}
                </a>
            </p>
        </div>
        <dialog class="dialog rounded-2xl text-center" id="modal-card" ref="cardModal" aria-modal="true" aria-labelledby="modal-card-label">
            <header>
                <h4 id="modal-card-label">
                    {{ translate('new_card') }}
                </h4>
                <button type="button" class="rounded-full" @click="closeModal('accessModal')" title="Close">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="text-justify">
                <div class="mb-2 w-full">
                    <label>{{ translate('card_name') }}</label>
                    <input id="card-holder-name" type="text" v-model="name" class="form-control">
                </div>

                <div class="mb-2 w-full">
                    <label>{{ translate('card') }}</label>
                    <div id="card-element">
                    </div>
                </div>

                <p class="help-block mb-2">
                    {{ translate('helper') }}
                </p>

                <div class="grid grid-cols-2 gap-2">
                    <button type="button" class="w-full rounded px-6 py-2.5 uppercase font-extrabold hover:bg-gray-200 hover:shadow-sm" @click="closeModal('cardModal')">Close</button>

                    <button type="button" v-bind:class="saveBtnClass()" @click="submitPaymentMethod" ref="formBtn">
                        {{ translate('actions.save') }}
                    </button>
                </div>
            </article>
        </dialog>
    </div>
</template>

<script>
    export default {
        props: [
            'api_token',
            'trans'
        ],

        data(){
            return {
                stripe: '',
                elements: '',
                card: '',
                intentToken: '',

                name: '',
                addPaymentStatus: 0,
                addPaymentStatusError: '',

                paymentMethods: [],
                paymentMethodsLoadStatus: 0,
                paymentMethodSelected: 0,

                showNewPaymentMethod: false,
                savePaymentMethodStatus: 0,
                deletingPaymentMethodStatus: 0,
                json_trans: [],

                isLoading: false,
            }
        },


        mounted(){
            this.includeStripe('js.stripe.com/v3/', function(){
                this.configureStripe();
            }.bind(this) );

            this.loadIntent();
            this.loadPaymentMethods();

            this.json_trans = JSON.parse(this.trans);
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
                this.card = this.elements.create('card', {
                    hidePostalCode: true
                });

                this.card.mount('#card-element');
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

            submitPaymentMethod() {
                this.addPaymentStatus = 1;
                this.savePaymentMethodStatus = 1;
                this.isLoading = true;

                this.stripe.confirmCardSetup(
                    this.intentToken.client_secret, {
                        payment_method: {
                            card: this.card,
                            billing_details: {
                                name: this.name
                            }
                        }
                    }
                ).then(function (result) {
                    this.savePaymentMethodStatus = 0;

                    this.isLoading = false;
                    if (result.error) {
                        this.addPaymentStatus = 3;
                        this.addPaymentStatusError = result.error.message;
                    } else {
                        this.savePaymentMethod(result.setupIntent.payment_method);
                        this.addPaymentStatus = 2;
                        this.card.clear();
                        this.name = '';
                        this.toggleShowNewPaymentMethod();
                    }
                }.bind(this));
            },

            /*  Saves the payment method for the user and re-loads the payment methods.*/
            savePaymentMethod(method) {
                this.paymentMethodsLoadStatus = 0;
                axios.post('/subscription-api/payments', {
                    payment_method: method
                }).then(function () {
                    this.loadPaymentMethods();
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
                        }.bind(this));
            },

            removePaymentMethod(paymentID) {
                this.paymentMethodsLoadStatus = 0;
                axios.post('/subscription-api/remove-payment', {
                    id: paymentID
                }).then(function (response) {
                    this.loadPaymentMethods();
                }.bind(this));
            },

            toggleShowNewPaymentMethod() {
                this.openModal('cardModal');
                this.showNewPaymentMethod = !this.showNewPaymentMethod;
            },

            translate(key) {
                return this.json_trans[key] ?? 'unknown';
            },

            openModal(ref) {
                this.$refs[ref].showModal();
                this.$refs[ref].addEventListener('click', function (event) {
                    let rect = this.getBoundingClientRect();
                    let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
                        rect.left <= event.clientX && event.clientX <= rect.left + rect.width);
                    if (!isInDialog && event.target.tagName === 'DIALOG') {
                        this.close();
                    }
                });
            },
            closeModal(ref) {
                this.$refs[ref].close();
            },

            saveBtnClass() {
                let cls = 'w-full rounded px-6 py-2.5 uppercase border border-blue-500 bg-white text-blue-500 font-extrabold hover:bg-blue-500 hover:text-white hover:shadow-sm';
                if (this.isLoading) {
                    cls += ' loading';
                }
                return cls;
            }
        },
    }
</script>
