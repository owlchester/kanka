<style scoped>
</style>

<template>
    <div>
        <div>
            <div class="card card-default">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span>
                            Personal Access Tokens
                        </span>

                        <a class="cursor-pointer" tabindex="-1" @click="showCreateTokenForm">
                            Create New Token
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- No Tokens Notice -->
                    <p class="mb-0" v-if="tokens.length === 0">
                        You have not created any personal access tokens.
                    </p>

                    <!-- Personal Access Tokens -->
                    <table class="table table-borderless mb-0" v-if="tokens.length > 0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="token in tokens">
                                <!-- Client Name -->
                                <td style="vertical-align: middle;">
                                    {{ token.name }}
                                </td>

                                <!-- Delete Button -->
                                <td style="vertical-align: middle;">
                                    <a class="cursor-pointer text-danger" @click="revoke(token)">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Token Modal -->

        <dialog class="dialog rounded-2xl text-center" id="modal-create-token" ref="createModal" aria-modal="true" aria-labelledby="modal-create-token-label">
            <header>
                <h4 id="modal-create-token-label">
                    Create Token
                </h4>
                <button type="button" class="rounded-full" @click="closeModal('createModal')" title="Close">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="text-justify">
                <!-- Form Errors -->
                <div class="rounded p-4 bg-red-100 text-red-800 w-full" v-if="form.errors.length > 0">
                    <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                    <br>
                    <ul>
                        <li v-for="error in form.errors">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <!-- Create Token Form -->
                <form role="form" class="w-full mb-5" @submit.prevent="store">
                    <!-- Name -->
                    <label class="font-extrabold required">Token name</label>

                    <input id="create-token-name" type="text" class="rounded border w-full p-2" name="name" placeholder="Name the token" v-model="form.name" ref="createName">


                    <!-- Scopes -->
                    <div class="form-group row" v-if="scopes.length > 0">
                        <label class="col-md-4 col-form-label">Scopes</label>

                        <div class="col-md-6">
                            <div v-for="scope in scopes">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               @click="toggleScope(scope.id)"
                                               :checked="scopeIsAssigned(scope.id)">

                                        {{ scope.id }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="grid grid-cols-2 gap-2 w-full">
                    <button type="button" class="w-full rounded px-6 py-2.5 uppercase font-extrabold hover:bg-gray-200 hover:shadow-sm" @click="closeModal('createModal')">Close</button>

                    <button type="button" class="w-full rounded px-6 py-2.5 uppercase border border-blue-500 bg-white text-blue-500 font-extrabold hover:bg-blue-500 hover:text-white hover:shadow-sm" @click="store">
                        Create
                    </button>
                </div>
            </article>
        </dialog>

        <!-- Access Token Modal -->
        <dialog class="dialog rounded-2xl text-center" id="modal-access-token" ref="accessModal" aria-modal="true" aria-labelledby="modal-access-token-label">
            <header>
                <h4 id="modal-access-token-label">
                    Personal Access Token
                </h4>
                <button type="button" class="rounded-full" @click="closeModal('accessModal')" title="Close">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="text-justify">
                <p class="mb-2">
                    Here is your new personal access token. This is the only time it will be shown so don't lose it!
                    You may now use this token to make API requests.
                </p>
                <textarea class="form-control" rows="10">{{ accessToken }}</textarea>

                <button type="button" class="w-full rounded px-6 py-2.5 hover:bg-gray-200 font-extrabold uppercase" @click="closeModal('accessModal')">Close</button>
            </article>
        </dialog>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                accessToken: null,

                tokens: [],
                scopes: [],

                form: {
                    name: '',
                    scopes: [],
                    errors: []
                }
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getTokens();
                this.getScopes();
            },

            /**
             * Get all of the personal access tokens for the user.
             */
            getTokens() {
                axios.get('/oauth/personal-access-tokens')
                        .then(response => {
                            this.tokens = response.data;
                        });
            },

            /**
             * Get all of the available scopes.
             */
            getScopes() {
                axios.get('/oauth/scopes')
                        .then(response => {
                            this.scopes = response.data;
                        });
            },

            /**
             * Show the form for creating new tokens.
             */
            showCreateTokenForm() {
                this.openModal('createModal');
                this.$refs.createName.focus();
            },

            /**
             * Create a new personal access token.
             */
            store() {
                this.accessToken = null;

                this.form.errors = [];

                axios.post('/oauth/personal-access-tokens', this.form)
                        .then(response => {
                            this.form.name = '';
                            this.form.scopes = [];
                            this.form.errors = [];

                            this.tokens.push(response.data.token);

                            this.showAccessToken(response.data.accessToken);
                        })
                        .catch(error => {
                            if (typeof error.response.data === 'object') {
                                this.form.errors = _.flatten(_.toArray(error.response.data.errors));
                            } else {
                                this.form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
            },

            /**
             * Toggle the given scope in the list of assigned scopes.
             */
            toggleScope(scope) {
                if (this.scopeIsAssigned(scope)) {
                    this.form.scopes = _.reject(this.form.scopes, s => s == scope);
                } else {
                    this.form.scopes.push(scope);
                }
            },

            /**
             * Determine if the given scope has been assigned to the token.
             */
            scopeIsAssigned(scope) {
                return _.indexOf(this.form.scopes, scope) >= 0;
            },

            /**
             * Show the given access token to the user.
             */
            showAccessToken(accessToken) {
                this.closeModal('createModal');

                this.accessToken = accessToken;

                this.openModal('accessModal');
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                axios.delete('/oauth/personal-access-tokens/' + token.id)
                        .then(response => {
                            this.getTokens();
                        });
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
        }
    }
</script>
