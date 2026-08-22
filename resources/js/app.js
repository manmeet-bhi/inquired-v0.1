import './bootstrap';
import './editor';

// Import Quill CSS
import 'quill/dist/quill.snow.css';

// Import Custom JS
import './scripts.js';

// AlpineJS
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
