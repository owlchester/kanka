import Vue from 'vue'

Vue.component('abilities', require('./components/abilities/Abilities.vue').default);
Vue.component('ability', require('./components/abilities/Ability.vue').default);
Vue.component('ability_form', require('./components/abilities/AbilityForm.vue').default);
Vue.component('parent', require('./components/abilities/Parent.vue').default);

const app = new Vue({
    el: '#abilities',
});
