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
    // Pagination
    var page;
    function load_data(page){
        $.ajax(
            {
                url: "../cat_wise.php",
                method: "POST",
                data: { page: page },
                dataType: "text",
                success: function (data) {
                    $("#show").html(data);
                }
            }
        )
    }
    $(document).on("click",".p_link",function(){
        var page = $(this).attr('id');
        console.log(page);
        load_data(page);
    });
});