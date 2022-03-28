import Abilities from "./components/abilities/Abilities"
import Ability from "./components/abilities/Ability"
import Parent from "./components/abilities/Parent"
import AbilityForm from "./components/abilities/AbilityForm"
import * as uiv from 'uiv'

window.Vue = require('vue');

Vue.component('abilities', Abilities);
Vue.component('ability', Ability);
Vue.component('ability_form', AbilityForm);
Vue.component('parent', Parent);

// Boostrap
Vue.use(uiv);

const app = new Vue({
    el: '#abilities',
});
