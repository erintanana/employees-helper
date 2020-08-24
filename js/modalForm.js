const modal = document.getElementById("modalForm");
const addButton = document.getElementById("addButton");
const closeModalForm = document.getElementsByClassName("modal-close")[0];

addButton.onclick = function () {
    modal.style.display = "block";
}

closeModalForm.onclick = function () {
    modal.style.display = "none";
}

function onSubmitAddPersonForm() {
    const form = document.getElementById("addPersonForm");
    var form_data = new FormData(form);
    $.ajax({
        url: "add.php",
        type: "POST",
        dataType: "text",
        contentType: false,
        processData: false,
        data: form_data,
        success: function (response) {

        },
        error: function (response) {

        }
    });
}

function kek() {}
