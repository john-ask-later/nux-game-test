import axios from 'axios';
import jQuery from 'jquery';

window.axios = axios;
window.jQuery = window.$ = jQuery;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.$('meta[name=csrf]').attr('content');
