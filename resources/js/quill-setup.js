import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Custom toolbar configuration
const toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],
  ['blockquote', 'code-block'],
  [{ 'header': 1 }, { 'header': 2 }],
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],
  [{ 'indent': '-1'}, { 'indent': '+1' }],
  [{ 'direction': 'rtl' }],
  [{ 'size': ['small', false, 'large', 'huge'] }],
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  [{ 'color': [] }, { 'background': [] }],
  [{ 'font': [] }],
  [{ 'align': [] }],
  ['link', 'image', 'video'],
  ['clean']
];

// Initialize Quill
export function initializeQuill(selector) {
  const quill = new Quill(selector, {
    theme: 'snow',
    modules: {
      toolbar: toolbarOptions,
      history: {
        delay: 2000,
        maxStack: 500,
        userOnly: true
      }
    },
    placeholder: 'Start writing your amazing content here... ✍️',
    readOnly: false
  });

  // Auto-save functionality
  let autoSaveTimer;
  quill.on('text-change', function() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
      // Auto-save logic here
      console.log('Auto-saving...');
    }, 2000);
  });

  // Word count
  quill.on('text-change', function() {
    const text = quill.getText();
    const wordCount = text.trim().split(/\s+/).length;
    document.getElementById('word-counter').textContent = wordCount;
  });

  return quill;
}