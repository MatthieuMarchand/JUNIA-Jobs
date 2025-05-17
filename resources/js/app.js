import * as bootstrap from 'bootstrap'; // la librairie css
import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.addEventListener('DOMContentLoaded', () => {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        const bsToast = bootstrap.Toast.getOrCreateInstance(toast);
        bsToast.show();
    });
});
