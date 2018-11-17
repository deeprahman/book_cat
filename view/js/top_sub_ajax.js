$(document).ready(function(){
    $("#sub").change(function(){
        var sub = $(this).val();
        console.log(sub);
        $.ajax(
            {
                url: "../cat_wise.php",
                method: "POST",
                data: { cat_id: sub },
                dataType: "text",
                success: function (data) {
                    $("#show").html(data);
                    console.log(data);
                }
            }
        )
    })
    
});