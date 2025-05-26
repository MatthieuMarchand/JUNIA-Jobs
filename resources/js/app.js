import * as bootstrap from 'bootstrap'; // la librairie css
import axios from 'axios';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.bootstrap5.min.css';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.addEventListener('DOMContentLoaded', () => {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        const bsToast = bootstrap.Toast.getOrCreateInstance(toast);
        bsToast.show();
    });

    const selects = document.querySelectorAll('select');

    selects.forEach((el) => {
        const settings = {
            create: el.dataset.create === 'true',
            plugins: {
                remove_button: {
                    title: 'Retirer',
                },
            },
        };

        new TomSelect(el, settings);
    });
});
