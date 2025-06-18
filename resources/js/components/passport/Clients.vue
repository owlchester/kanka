<style scoped>
</style>

<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <span class="text-lg">
                        OAuth Clients
                    </span>

                    <a class="btn2 btn-primary btn-outline btn-sm" tabindex="-1" @click="showCreateClientForm">
                        Create New Client
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Current Clients -->
                <p class="mb-0" v-if="clients.length === 0">
                    You have not created any OAuth clients.
                </p>

                <table class="table table-borderless mb-0" v-if="clients.length > 0">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Name</th>
                            <th>Secret</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="client in clients">
                            <!-- ID -->
                            <td style="vertical-align: middle;">
                                {{ client.id }}
                            </td>

                            <!-- Name -->
                            <td style="vertical-align: middle;">
                                {{ client.name }}
                            </td>

                            <!-- Secret -->
                            <td style="vertical-align: middle;">
                                <code>******</code>
                            </td>

                            <!-- Edit Button -->
                            <td style="vertical-align: middle;">
                                <a class="cursor-pointer" tabindex="-1" @click="edit(client)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td class="text-right" style="vertical-align: middle;">
                                <a class="btn2 btn-error btn-outline btn-xs" @click="deleteConfirm(client)" v-if="!this.confirmClient || this.confirmClient.id != client.id">
                                    Delete
                                </a>
                                <a class="btn2 btn-error btn-xs" @click="deleteConfirm(client)" v-else>
                                    Confirm delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Client Modal -->
        <dialog class="dialog rounded-2xl" id="modal-create-client" ref="createModal" aria-modal="true" aria-labelledby="modal-create-client-label">
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between w-full">
                <h4 id="modal-create-client-label" class="text-lg font-normal">
                    Create Client
                </h4>
                <button type="button" class="rounded-full" @click="closeModal('createModal')" title="Close">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="p-4">
                <!-- Form Errors -->
                <div class="rounded p-4 bg-red-100 text-red-800 w-full" v-if="createForm.errors.length > 0">
                    <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                    <br>
                    <ul>
                        <li v-for="error in createForm.errors">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <!-- Create Client Form -->
                <form role="form" class="w-full" @submit.prevent="store" autocomplete="off">
                    <!-- Name -->
                    <div class="mb-5">
                        <label class="font-extrabold required">Client name</label>

                        <input id="create-client-name" type="text" class="rounded border w-full p-2" name="name" placeholder="Name the token" v-model="createForm.name" @keyup.enter="store" ref="createName">

                        <span class="text-sm text-neutral-content">
                            Something your users will recognize and trust.
                        </span>
                    </div>

                    <!-- Redirect URL -->
                    <div class="">
                        <label class="font-extrabold required">Redirect URL</label>

                        <input type="text" class="rounded border w-full p-2" name="redirect"
                               @keyup.enter="store" v-model="createForm.redirect">

                        <span class="text-sm text-neutral-content">
                            Your application's authorization callback URL.
                        </span>
                    </div>
                </form>

                <div class="flex justify-between items-center gap-2 w-full">
                    <button type="button" class="btn2 btn-outline" @click="closeModal('createModal')">Close</button>

                    <button type="button" class="btn2 btn-primary" @click="store">
                        Create
                    </button>
                </div>
            </article>
        </dialog>

        <!-- Edit Client Modal -->
        <dialog class="dialog rounded-2xl" id="modal-edit-client" ref="editModal" aria-modal="true" aria-labelledby="modal-edit-client-label">
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
                <h4 id="modal-edit-client-label" class="text-lg font-normal">
                    Create Client
                </h4>
                <button type="button" class="rounded-full" @click="closeModal('editModal')" title="Close">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="p-4">
                <!-- Form Errors -->
                <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                    <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                    <ul>
                        <li v-for="error in editForm.errors">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <!-- Edit Client Form -->
                <form role="form" class="flex flex-col gap-5" autocomplete="off">
                    <!-- Name -->
                    <div class="">
                        <label class="font-extrabold required">Name</label>

                        <input id="edit-client-name" type="text" class="w-full"
                                                    @keyup.enter="update" v-model="editForm.name" ref="editName">

                        <span class="text-sm text-neutral-content">
                            Something your users will recognize and trust.
                        </span>
                    </div>

                    <!-- Redirect URL -->
                    <div class="">
                        <label class="font-extrabold required">Redirect URL</label>

                        <input type="text" class="w-full" name="redirect"
                                        @keyup.enter="update" v-model="editForm.redirect">

                        <span class="text-sm text-neutral-content">
                            Your application's authorization callback URL.
                        </span>
                    </div>
                </form>

                <div class="flex justify-between items-center gap-2 w-full">
                    <button type="button" class="btn2 btn-outline" @click="closeModal('editModal')">Close</button>

                    <button type="button" class="btn2 btn-primary" @click="update">
                        Create
                    </button>
                </div>
            </article>
        </dialog>

        <!-- Access Token Modal -->
        <dialog class="dialog rounded-2xl" id="modal-access-token" ref="accessModal" aria-modal="true" aria-labelledby="modal-access-token-label">
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
                <h4 id="modal-access-token-label" class="text-lg font-normal">
                    OAuth Client Secret
                </h4>
                <button type="button" class="rounded-full" @click="closeModal('accessModal')" title="Close">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="text-justify p-4">
                <p class="mb-2">
                    Here is your oauth client secret token. This is the only time it will be shown so don't lose it!
                    You may now use this token to make API requests.
                </p>
                <input type="text" class="w-full" rows="1">{{ secret }}</input>

                <button type="button" class="btn2 btn-outline" @click="closeModal('accessModal')">Close</button>
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
                secret: null,

                clients: [],
                confirmClient: null,

                createForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    redirect: ''
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
                this.getClients();
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
                axios.get('/oauth/clients')
                        .then(response => {
                            this.clients = response.data;
                        });
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                this.openModal('createModal');
                this.$refs.createName.focus();
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/oauth/clients',
                    this.createForm, 'createModal'
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.redirect = client.redirect;

                this.openModal('editModal');
                this.$refs.editName.focus();
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/oauth/clients/' + this.editForm.id,
                    this.editForm, 'editModal'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getClients();

                        form.name = '';
                        form.redirect = '';
                        form.errors = [];

                        if (method === 'post') {
                            this.showSecret(response.data.secret);
                        }

                        this.closeModal(modal);
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                axios.delete('/oauth/clients/' + client.id)
                        .then(response => {
                            this.getClients();
                            window.showToast('OAuth client deleted succesfully.');
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
            deleteConfirm(client) {
                if(this.confirmClient && client.id === this.confirmClient.id) {
                    return this.destroy(client);
                }
                this.confirmClient = client;
            },


            /**
             * Show the given access token to the user.
             */
            showSecret(secret) {
                this.closeModal('createModal');

                this.secret = secret;

                this.openModal('accessModal');
            },
        }
    }
</script>
