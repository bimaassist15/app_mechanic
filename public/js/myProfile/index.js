var urlRoot = $(".url_root").data("value");
var body = $("body");
var loadData = () => {
    $.ajax({
        url: `${urlRoot}/myProfile`,
        type: "get",
        dataType: "text",
        beforeSend: function () {
            $(".loading-profile").removeClass("d-none");
        },
        success: function (data) {
            $("#output_profile").html(data);
        },
        complete: function () {
            $(".loading-profile").addClass("d-none");
        },
    });
};
$(document).ready(function () {
    loadData();

    body.on("click", ".btn-edit", function (e) {
        e.preventDefault();
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form User",
            type: "get",
        });
    });
});
