$(document).ready(function() {
    $("#loginForm").submit(function(event) {
        // Display loading spinner on form submission
        $("#loadingSpinner").show();

        // Simulate asynchronous login process (you can replace this with your actual login logic)
        setTimeout(function() {
            // Hide loading spinner after a delay (you can adjust the delay as needed)
            $("#loadingSpinner").hide();
        }, 2000);
    });
});
