require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { createInertiaApp } from "@inertiajs/inertia-vue"
import { InertiaProgress } from '@inertiajs/progress'
import PortalVue from 'portal-vue';

Vue.mixin({ methods: { route } });
Vue.use(PortalVue);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, App, props}) {
        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    }
})

InertiaProgress.init({ color: '#4B5563' });
