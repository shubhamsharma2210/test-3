console.log("hello");
console.log(typeof jQuery);

jQuery(document).ready(function($) {
    $("#eventForm").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);

        $.ajax({
            url: event_ajax.ajaxurl,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $("#response").html("<p style='color: green;'>" + response.data.message + "</p>");
                    $("#eventForm")[0].reset();
               
                } else {
                    $("#response").html("<p style='color: red;'>" + response.data.message + "</p>");
                  
                }
            },
            error: function() {
                $("#response").html("<p style='color: red;'>Something went wrong!</p>");
            }
        });
    });
});
