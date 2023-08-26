/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import { createStore } from 'vuex';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
const store = createStore({
    state: {
        item: {}
    }
});

app.use(store)

// importar componentes globais
// ------ Views ------- //
import Console from './components/Console/ConsoleComponent.vue';
import Games from './components/Games/GamesComponent.vue';

// servir componentes globais
// ------ Views ------- //
app.component('console-component', Console);
app.component('games-component', Games);

// filtro de formatação de data global
app.config.globalProperties.$filters = {
    tempoDeCriacao(d) {
        if (!d) return "";

        // Data do registro criado (vinda do banco de dados)
        const createdDate = new Date(d);

        // Data e hora atual
        const currentDate = new Date();

        // Calcula a diferença em milissegundos entre as duas datas
        const timeDifference = currentDate - createdDate;

        // Converte a diferença de milissegundos para segundos, minutos, horas e dias
        const seconds = Math.floor(timeDifference / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        const time = `Inserido á: ${days} dias, ${hours % 24} horas, ${minutes % 60
            } minutos.`;

        return time;
    }
},
    /**
     * The following block of code may be used to automatically register your
     * Vue components. It will recursively scan this directory for the Vue
     * components and automatically register them with their "basename".
     *
     * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
     */

    // Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
    //     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
    // });

    /**
     * Finally, we will attach the application instance to a HTML element with
     * an "id" attribute of "app". This element is included with the "auth"
     * scaffolding. Otherwise, you will need to add an element yourself.
    */

    app.mount('#app');
