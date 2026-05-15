import { Controller } from '@hotwired/stimulus';
import { Jodit } from 'jodit';
import 'jodit/es2021/jodit.min.css';
import 'ace-builds';
import 'ace-builds/src-noconflict/mode-html';
import 'ace-builds/src-noconflict/theme-idle_fingers';

export default class extends Controller {
    static values = {
        uploadUrl: String,
    };

    connect() {
        this.editor = Jodit.make(this.element, this.buildOptions());
    }

    disconnect() {
        if (this.editor) {
            this.editor.destruct();
            this.editor = null;
        }
    }

    buildOptions() {
        return {
            height: 400,
            style: {
                overflowWrap: 'break-word',
                wordBreak: 'break-word',
            },
            sourceEditor: 'ace',
            sourceEditorCDNUrlsJS: [],
            imageProcessor: { replaceDataURIToBlobIdInView: false },
            buttons: [
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'brush', 'font', 'fontsize', '|',
                'align', '|',
                'ul', 'ol', '|',
                'paragraph', '|',
                'link', 'image', '|',
                'source',
            ],
            uploader: this.buildUploaderConfig(),
            events: {
                afterInsertImage: (image) => this.normalizeInsertedImage(image),
            },
        };
    }

    buildUploaderConfig() {
        if (!this.hasUploadUrlValue || this.uploadUrlValue === '') {
            return { insertImageAsBase64URI: true };
        }

        return {
            insertImageAsBase64URI: false,
            url: this.uploadUrlValue,
            filesVariableName: () => 'upload',
            isSuccess: (response) => response?.uploaded === 1,
            process: (response) => ({
                files: [response.url],
                baseurl: '',
                isImages: [true],
            }),
            getMessage: (response) => response?.message ?? 'Upload failed',
        };
    }

    normalizeInsertedImage(image) {
        if (!(image instanceof HTMLImageElement)) {
            return;
        }

        image.style.maxWidth = '100%';
        image.removeAttribute('width');
        image.removeAttribute('height');
    }
}
