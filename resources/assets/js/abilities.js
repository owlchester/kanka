import Abilities from "./components/abilities/Abilities"
import Ability from "./components/abilities/Ability"
import Parent from "./components/abilities/Parent"
import AbilityForm from "./components/abilities/AbilityForm"
import VueInternationalization from 'vue-i18n'
import Locale from "./vue-i18n-locales.generated"
import * as uiv from 'uiv'

window.Vue = require('vue');

Vue.component('abilities', Abilities);
Vue.component('ability', Ability);
Vue.component('ability_form', AbilityForm);
Vue.component('parent', Parent);

// Boostrap
Vue.use(uiv);

// Translations
Vue.use(VueInternationalization);
const lang = document.documentElement.lang.substr(0, 2);

const i18n = new VueInternationalization({
    locale: lang,
    fallbackLocale: 'en',
    messages: Locale
});

const app = new Vue({
    el: '#abilities',
    i18n
});
