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
    const addPersonForm = document.getElementById("addPersonForm");
    const addPersonFormData = new FormData(addPersonForm);
    $.ajax({
        url: "add.php",
        type: "POST",
        dataType: "text",
        contentType: false,
        processData: false,
        data: addPersonFormData,
        success: function (response) {

        },
        error: function (response) {

        }
    });
}