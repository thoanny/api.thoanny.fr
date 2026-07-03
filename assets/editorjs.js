// https://dev.to/neothone/editorjs-in-symfony-easyadmin-40ao

import './styles/editorjs.css';

import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import EditorjsList from '@editorjs/list';
import Embed from '@editorjs/embed';
import Quote from '@editorjs/quote';
import Table from '@editorjs/table';
import Warning from '@editorjs/warning';
import Delimiter from '@editorjs/delimiter';
import AnchorTune from 'editorjs-anchor';
import ImageTool from '@editorjs/image';
import AttachesTool from '@editorjs/attaches';
import CodeTool from '@editorjs/code';
import RawTool from '@editorjs/raw';

// Custom
import ButtonBlock from './editorjs/plugins/ButtonBlock/index.js';

const $editorjs = document.getElementById('editorjs');
if ($editorjs) {
    const inputTarget = $editorjs.dataset.inputTarget;
    const $inputTarget = document.getElementById(inputTarget);

    const editor = new EditorJS({
        holder: 'editorjs',
        placeholder: 'Let`s write an awesome story!',
        tools: {
            header: Header,
            quote: Quote,
            warning: Warning,
            delimiter: Delimiter,
            list: {
                class: EditorjsList,
                inlineToolbar: true,
            },
            embed: Embed,
            table: {
                class: Table,
                inlineToolbar: true,
            },
            anchorTune: AnchorTune,
            image: {
                class: ImageTool,
                config: {
                    endpoints: {
                        byFile: '/admin/file/upload',
                        byUrl: '/admin/file/fetch',
                    },
                },
            },
            attaches: {
                class: AttachesTool,
                config: {
                    endpoint: '/admin/file/upload',
                },
            },
            code: CodeTool,
            raw: RawTool,
            button: ButtonBlock,
        },
        tunes: ['anchorTune'],
        data:
            $inputTarget && $inputTarget.value
                ? JSON.parse($inputTarget.value)
                : null,
        onChange: () => {
            saveData();
        },
    });

    const saveData = () => {
        if (!$inputTarget) {
            return;
        }
        editor
            .save()
            .then((outputData) => {
                $inputTarget.value = JSON.stringify(outputData);
            })
            .catch((error) => {
                console.log('Saving failed: ', error);
            });
    };
}
