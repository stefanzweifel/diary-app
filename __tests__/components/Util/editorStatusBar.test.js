import EditorStatusBar from './../../../resources/assets/js/components/EditorStatusBar.vue';
import Vue from 'vue/dist/vue.js';

describe('EditorStatusBar', () => {
    Vue.component('editor-status-bar', EditorStatusBar);

    beforeEach(() => {
        document.body.innerHTML = `
            <div id="app">
                <editor-status-bar content="This is the content"></editor-status-bar>
            </div>
        `;
    });

    it('can mount', async () => {
        await createVm();

        expect(document.body.innerHTML).toMatchSnapshot();
    });

    it('displays word count', async () => {

        document.body.innerHTML = `
            <div id="app">
                <editor-status-bar content="This is the content"></editor-status-bar>
            </div>
        `;

        const app = await createVm();

        expect(app.component.wordCount).toEqual(4);
        expect(document.body.innerHTML).toContain('4 Words');

    });

    it('set word count to 0 if no content is given', async () => {


        document.body.innerHTML = `
            <div id="app">
                <editor-status-bar content=""></editor-status-bar>
            </div>
        `;

        const app = await createVm();

        expect(app.component.wordCount).toEqual(0);

    });

});

async function createVm() {
    const vm = new Vue({
        el: '#app',
    });

    await Vue.nextTick(() => {});

    return { app: vm, component: vm.$children[0] };
}