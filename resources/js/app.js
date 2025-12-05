import "./bootstrap";

import Alpine from "alpinejs";

import IMask from "imask";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    var $cpf = document.getElementById("cpf");
    if ($cpf) {
        var $cpf = IMask($cpf, {
            mask: "000.000.000-00",
        });
    }

    var $phone = document.getElementById("phone");
    if ($phone) {
        var $phone = IMask($phone, {
            mask: "(00) 00000-0000",
        });
    }
});
