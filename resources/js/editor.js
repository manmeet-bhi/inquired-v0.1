import Quill from 'quill';

document.addEventListener('DOMContentLoaded', function () {
    console.log('Editor script loaded');
    const editorElement = document.getElementById('content-editor');
    console.log('Editor element:', editorElement);

    if (!editorElement) {
        console.log('No editor element found');
        return;
    }

    console.log('Initializing Quill...');
    const quill = new Quill('#content-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'script': 'sub' }, { 'script': 'super' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Start writing your amazing content here... ✍️'
    });

    console.log('Quill initialized:', quill);

    // Load existing content
    const hiddenTextarea = document.querySelector('textarea[name="content"]');
    if (hiddenTextarea && hiddenTextarea.value) {
        console.log('Loading existing content:', hiddenTextarea.value);
        quill.root.innerHTML = hiddenTextarea.value;
    }

    // Sync content on every change
    quill.on('text-change', function () {
        if (hiddenTextarea) {
            hiddenTextarea.value = quill.root.innerHTML;
            console.log('Content synced:', hiddenTextarea.value.substring(0, 50) + '...');
        }
    });

    // Sync with form on submit (backup)
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            console.log('Form submitting, syncing content');
            if (hiddenTextarea) {
                hiddenTextarea.value = quill.root.innerHTML;
                console.log('Final content:', hiddenTextarea.value);
            }
        });
    }

    // Word counter
    const wordCounters = document.querySelectorAll('#word-counter');
    if (wordCounters.length > 0) {
        quill.on('text-change', function () {
            const text = quill.getText();
            const words = text.trim() ? text.trim().split(/\s+/).length : 0;
            wordCounters.forEach(counter => {
                counter.textContent = words;
            });
        });

        // Initial count
        const text = quill.getText();
        const words = text.trim() ? text.trim().split(/\s+/).length : 0;
        wordCounters.forEach(counter => {
            counter.textContent = words;
        });
    }
});