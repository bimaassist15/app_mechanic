const showModal = ({
    url = "",
    data = {},
    title = "",
    type = "",
    modalId = "",
}) => {
    $.ajax({
        url: url,
        data,
        type,
        dataType: "text",
        success: function (html) {
            $(`#${modalId} .modal-title`).text(title);
            $(`#${modalId} .modal-body-content`).html(html);
            var myModal = new bootstrap.Modal(
                document.getElementById(modalId),
                {
                    keyboard: false,
                }
            );
            myModal.show();
        },
        error: function (jqXHR, exception) {
            ajaxErrorMessage(jqXHR, exception);
        },
    });
};
