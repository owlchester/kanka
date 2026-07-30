import { EditorView, basicSetup } from 'codemirror';
import { css } from '@codemirror/lang-css';
import { oneDark } from '@codemirror/theme-one-dark';
import { EditorState } from '@codemirror/state';

import '../../css/codemirror.css';

const registerStyleEditor = () => {
    document.querySelectorAll('textarea[data-codemirror]').forEach((textarea) => {
        if (textarea.dataset.codemirrorInitialized) {
            return;
        }

        const container = document.createElement('div');
        container.className = 'campaign-style-editor';
        container.setAttribute('aria-label', textarea.getAttribute('aria-label') ?? '');
        textarea.after(container);
        textarea.hidden = true;
        textarea.dataset.codemirrorInitialized = 'true';

        const editorView = new EditorView({
            state: EditorState.create({
                doc: textarea.value,
                extensions: [
                    basicSetup,
                    css(),
                    oneDark,
                    EditorView.lineWrapping,
                    EditorView.updateListener.of((update) => {
                        if (update.docChanged) {
                            textarea.value = update.state.doc.toString();
                        }
                    }),
                ],
            }),
            parent: container,
        });

        textarea.form?.addEventListener('submit', () => {
            textarea.value = editorView.state.doc.toString();
        });
    });
};

registerStyleEditor();
