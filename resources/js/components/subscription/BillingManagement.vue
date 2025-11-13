<template>
    <div>

        <div v-show="paymentMethodsLoadStatus != 2" class="text-center">
            <i class="fa-solid fa-spin fa-spinner"></i>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2
    && paymentMethods.length > 0">
            <div v-for="(method, key) in paymentMethods"
                 v-bind:key="'method-'+key"
                 class="bg-box shadow-xs mb-5 p-4 rounded flex gap-2 md:gap-4"
            >
                <div class="grow">
                    <div class="font-extrabold">
                        {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }} ending in {{ method.last_four }}
                    </div>
                    <div class="">
                        Expires {{ method.exp_month }} {{ method.exp_year }}
                    </div>
                </div>
                <div class="">
                    <button role="button" v-on:click.stop="removePaymentMethod( method.id )" title="Remove" class="btn2 btn-outline btn-error btn-sm">
                        Remove card
                    </button>
                </div>
            </div>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2 && paymentMethods.length == 0" class="flex gap-2 mb-5">
            <p class="help-block text-neutral-content grow">
                {{ translate('add_one') }}
            </p>
            <a href="#" v-on:click.close="toggleShowNewPaymentMethod" class="btn2 btn-outline">
                <i class="fa-regular fa-credit-card" aria-hidden="true"></i> {{ translate('actions.add_new') }}
            </a>
        </div>
        <dialog class="dialog rounded-2xl text-center" id="modal-card" ref="cardModal" aria-modal="true" aria-labelledby="modal-card-label">
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between  w-full">
                <h4 id="modal-card-label" class="text-lg font-normal">
                    {{ translate('new_card') }}
                </h4>
                <button type="button" class="rounded-full" @click="closeModal('cardModal')" title="Close">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="text-justify py-4 px-4 md:px-6">
                <div class="mb-2 w-full field text-left">
                    <label>{{ translate('card_name') }}</label>
                    <input id="card-holder-name" type="text" v-model="name" class="w-full">
                </div>

                <div class="mb-2 w-full">
                    <label>{{ translate('card') }}</label>
                    <div id="card-element">
                    </div>

                    <p class="text-red-500 my-2" v-html="addPaymentStatusError" v-if="addPaymentStatusError">
                    </p>
                </div>

                <p class="help-block text-neutral-content mb-2">
                    {{ translate('helper') }}
                </p>

                <div class="flex justify-between items-center gap-2 w-full">
                    <button type="button" class="btn2 btn-outline" @click="closeModal('cardModal')">Close</button>

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
                object.src = 'https://' + URL;
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

                console.log('wa');

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
                        console.log('error', result.error.message);
                        this.addPaymentStatus = 3;
                        this.addPaymentStatusError = result.error.message;
                    } else {
                        this.savePaymentMethod(result.setupIntent.payment_method);
                        this.addPaymentStatus = 2;
                        this.addPaymentStatusError = '';
                        this.card.clear();
                        this.name = '';
                        this.closeModal('cardModal');
                    }
                }.bind(this));
            },

            /*  Saves the payment method for the user and re-loads the payment methods.*/
            savePaymentMethod(method) {
                console.log('save?');
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
                let cls = 'btn2 btn-primary';
                if (this.isLoading) {
                    cls += ' loading';
                }
                return cls;
            }
        },
    }
</script>
