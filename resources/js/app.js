require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { createInertiaApp } from "@inertiajs/inertia-vue"
import { InertiaProgress } from '@inertiajs/progress'
import PortalVue from 'portal-vue';
import VueNumerals from 'vue-numerals';
import { Link } from '@inertiajs/inertia-vue'

Vue.config.productionTip = false

Vue.mixin({ methods: { route: window.route } });
Vue.use(PortalVue);
Vue.use(VueNumerals);
Vue.component('InertiaLink', Link)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

InertiaProgress.init({ color: '#4B5563' });

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, App, props}) {
        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    }
})
