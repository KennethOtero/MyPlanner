// Form validation
function validateForm() {
    var blnResult = true;

    // Reset any error messages
    var input = document.getElementsByClassName('form_data');
    var error = document.getElementsByClassName('text-danger');
    for (var i = 0; i < input.length; i++) {
        // Remove red bar
        input[i].removeAttribute('style');
    }
    for (var i = 0; i < error.length; i++) {
        // Hide error message
        error[i].style.display = 'none';
    }

    // Validation
    for (var i = 0; i < input.length; i++) {
        if (input[i].value.trim() == "") {
            // Show error
            error[i].innerHTML = "Enter an email";
            error[i].style.display = 'block';
            input[i].style.borderBottom = '2px solid red';
            input[i].focus();
            blnResult = false;
            return blnResult;
        }
    }

    // Return success
    return blnResult;
}

function ajax() {
    if (validateForm() == true) {
        var data = new FormData();
        data.append("txtSecurity", document.getElementById('txtSecurity').value.trim());

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../content/restricted/Process_ResetPassword2.php");
        xhr.onload = function(e) {
            // Receive either 'Success' or 'Failed' from PHP file
            var response = xhr.responseText;

            if (response == "Success") {
                // Go to next reset password page
                window.location.href = "../content/ResetPassword3.php";
            } else {
                // Display error
                document.getElementById('message').innerHTML = "Incorrect Answer";
                document.getElementById('message').style.display = "block";
                document.getElementById('message').style.color = "red";
                document.getElementById('message').style.borderBottom = "2px solid red";

                // Hide error message after 5 seconds
                setTimeout(() => {                
                    document.getElementById('message').style.display = "none";
                }, 5000);
            }           
        };
        xhr.send(data); // Send form data for PHP processing

        // Prevent html form submit
        return false; // should be false
    } else {
        return false;
    }
}
