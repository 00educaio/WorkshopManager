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
});
