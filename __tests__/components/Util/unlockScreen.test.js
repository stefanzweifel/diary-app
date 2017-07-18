import Vue from 'vue/dist/vue.js';
import UnlockScreen from './../../../resources/assets/js/components/Util/UnlockScreen.vue';

import store from './../../../resources/assets/js/store/index.js';

describe('UnlockScreen', () => {

    Vue.component('unlock-form', UnlockScreen);

    beforeEach(() => {
        document.body.innerHTML = `
            <div id="app">
                <unlock-form></unlock-form>
            </div>
        `;
    });

    it('can mount', async () => {
        await createVm();

        expect(document.body.innerHTML).toMatchSnapshot();
    });

    it('password is empty when component is initialized', async () => {
        const {component} = await createVm();

        expect(component.password).toEqual('');

    });

});

async function createVm() {

    const vm = new Vue({
        el: '#app',
        store
    });

    await Vue.nextTick(() => {});

    return { app: vm, component: vm.$children[0] };
}