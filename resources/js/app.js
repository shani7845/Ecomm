import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// ===============================
// GLOBAL GUEST TOKEN (WEB + MOBILE)
// ===============================

// generate once
if (!localStorage.getItem('guest_token')) {
    localStorage.setItem('guest_token', crypto.randomUUID());
}

// attach with every ajax request
$.ajaxSetup({
    headers: {
        'X-GUEST-TOKEN': localStorage.getItem('guest_token')
    }
});
