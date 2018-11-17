// get value from select
$(document).ready(function () {
    $("#category").change(function () {
        var top_cat = $(this).val();
        $.ajax(
            {
                url: "../sub_cat.php",
                method: "POST",
                data: { cat_id: top_cat },
                dataType: "text",
                success: function (data) {
                    $("#sub").html(data);
                }
            }
        )
    });

});
