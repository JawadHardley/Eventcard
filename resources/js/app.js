// import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

import { Html5Qrcode } from "html5-qrcode";

window.Html5Qrcode = Html5Qrcode; // expose it globally

Alpine.start();
