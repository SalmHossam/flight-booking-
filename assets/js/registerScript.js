$(document).ready(function() {
    $("form").submit(function(event) {
        // Validate form fields here
        if (!$.trim($("#name").val()) || !$.trim($("#username").val()) || !$.trim($("#email").val()) || !$.trim($("#password").val()) || !$.trim($("#tel").val())) {
            alert("All fields are required.");
            event.preventDefault();
        }
    });
});


