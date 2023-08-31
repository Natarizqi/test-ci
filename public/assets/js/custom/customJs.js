const delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

String.prototype.replaceArray = function (find, replace) {
    var replaceString = this;
    for (var i = 0; i < find.length; i++) {
        replaceString = replaceString.replace(find[i], replace[i]);
    }
    return replaceString;
};

$("select").each(function () {
    $(this).select2({
        dropdownParent: $(this).parent(),
        allowClear: true,
    });
});

const resetValidasiForm = () => {
    $("input.form-control").removeClass("is-invalid");
    $("textArea.form-control").removeClass("is-invalid");
    $("input.form-check-input").removeClass("is-invalid");
    $("select.form-select").removeClass("is-invalid");
    $(".invalid-feedback").empty();
};

const resetButton = (btnId, btnText) => {
    $(btnId).removeAttr("data-kt-indicator");
    $(btnId + "-text").text(btnText);
};

const loadingModal = () => {
    $(".modal-body-layer").addClass("overlay overlay-block");
    $(".modal-overlay-layer").show();
    $(".modal-content-layer").hide();
};

const resetLoadingModal = () => {
    $(".modal-body-layer").removeClass("overlay overlay-block");
    $(".modal-overlay-layer").hide();
    $(".modal-content-layer").show();
};

const makeid = (length) => {
    var result = "";
    var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var charactersLength = characters.length;

    for (var i = 0; i < length; i++) {
        result += characters.charAt(
            Math.floor(Math.random() * charactersLength)
        );
    }

    return result;
};
