import axios from 'axios';
import jQuery from 'jquery';

window.axios = axios;
window.jQuery = window.$ = jQuery;

// Setup CSRF token to jQuery and axios
const CSFR = window.app.csfr;

jQuery.ajaxSetup({headers: {'X-CSRF-TOKEN': CSFR}});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = CSFR;
