function validateForm(namaForm) {
    var y,
        i,
        valid = true;
    y = document.getElementsByClassName("required-field" + "-" + namaForm);
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        var validshow = "valid-" + y[i].id;
        validshow = validshow.replace("[", "");
        validshow = validshow.replace("]", "");
        if (
            y[i].classList.contains("tinymce") &&
            tinymce.get(y[i].id).getContent() == ""
        ) {
            // $("#" + y[i].id).css({ "background-color": "red" });
            $("#" + validshow).show();
            valid = false;
        } else if (!y[i].classList.contains("tinymce") && y[i].value == "") {
            // $("#" + y[i].id).css({ "background-color": "red" });
            $("#" + validshow).show();
            valid = false;
        } else {
            $("#" + y[i].id).css({ "background-color": "" });
            $("#" + validshow).hide();
        }
    }

    $("#modalCreate").scrollTop(0);

    return valid; // return the valid status
}
