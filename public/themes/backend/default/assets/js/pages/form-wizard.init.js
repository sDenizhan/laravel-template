$(document).ready(function () {
    "use strict";
    $("#basicwizard").bootstrapWizard({
        nextSelector: ".btn-next",
        previousSelector: ".btn-previous",
        firstSelector: ".button-first",
        lastSelector: ".button-last"
    })
});
