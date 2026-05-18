import { Controller } from '@hotwired/stimulus';
import Trix from 'trix';
import 'trix/dist/trix.css';

export default class extends Controller {
    connect() {
        this.toolbarElement = document.getElementById(this.element.getAttribute('toolbar'));
        this.inputElement = document.getElementById(this.element.getAttribute('input'));

        if (this.inputElement && this.inputElement.value !== '') {
            this.element.replaceChildren(this.parseFragment(this.inputElement.value));
        }

        this.boundOnBeforeInitialize = this.onBeforeInitialize.bind(this);
        this.boundOnBlur = this.onBlur.bind(this);
        this.boundOnFileAccept = this.onFileAccept.bind(this);

        this.element.addEventListener('trix-before-initialize', this.boundOnBeforeInitialize);
        this.element.addEventListener('trix-blur', this.boundOnBlur);
        this.element.addEventListener('trix-file-accept', this.boundOnFileAccept);
    }

    disconnect() {
        this.element.removeEventListener('trix-before-initialize', this.boundOnBeforeInitialize);
        this.element.removeEventListener('trix-blur', this.boundOnBlur);
        this.element.removeEventListener('trix-file-accept', this.boundOnFileAccept);
    }

    onBeforeInitialize() {
        if (!this.toolbarElement) {
            return;
        }

        const parsed = new DOMParser().parseFromString(Trix.config.toolbar.getDefaultHTML(), 'text/html');
        const fileTools = parsed.querySelector('[data-trix-button-group="file-tools"]');
        if (fileTools) {
            fileTools.remove();
        }

        this.toolbarElement.replaceChildren(...parsed.body.childNodes);
    }

    onBlur() {
        if (!this.inputElement) {
            return;
        }

        this.inputElement.dispatchEvent(new Event('change', { bubbles: true }));
    }

    onFileAccept(event) {
        event.preventDefault();
    }

    parseFragment(html) {
        const parsed = new DOMParser().parseFromString(html, 'text/html');
        const fragment = document.createDocumentFragment();
        fragment.append(...parsed.body.childNodes);

        return fragment;
    }
}
