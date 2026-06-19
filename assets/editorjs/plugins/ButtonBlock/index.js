import { createApp } from 'vue';
import ButtonBlockComponent from './ButtonBlock.vue';

export default class ButtonBlock {
    static get toolbox() {
        return {
            title: 'Button',
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="8" rx="4"/><path d="M12 12h.01"/></svg>',
        };
    }

    static get sanitize() {
        return {
            title: false,
            url: false,
            newTab: false,
        };
    }

    constructor({ data, api, readOnly }) {
        this.data = {
            title: data?.title ?? '',
            url: data?.url ?? '',
            newTab: data?.newTab ?? false,
        };
        this.api = api;
        this.readOnly = readOnly;
        this._wrapper = null;
        this._app = null;
    }

    render() {
        this._wrapper = document.createElement('div');

        this._app = createApp(ButtonBlockComponent, {
            data: { ...this.data },
            readOnly: this.readOnly,
            onUpdate: (newData) => {
                this.data = { ...this.data, ...newData };
            },
        });

        this._app.mount(this._wrapper);
        return this._wrapper;
    }

    save() {
        return { ...this.data };
    }

    validate(data) {
        return data.title?.trim().length > 0 && data.url?.trim().length > 0;
    }

    destroy() {
        this._app?.unmount();
        this._app = null;
    }
}
