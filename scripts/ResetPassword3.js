// Get form data
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#txtPassword");
const toggleConfirm = document.querySelector("#toggleConfirm");
const Confirm = document.querySelector("#txtConfirm");

// Toggle password eye
togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    
    // toggle the icon
    this.classList.toggle("bi-eye");
});
// Toggle password eye for confirm password input
toggleConfirm.addEventListener("click", function () {
    // toggle the type attribute
    const type = Confirm.getAttribute("type") === "password" ? "text" : "password";
    Confirm.setAttribute("type", type);
    
    // toggle the icon
    this.classList.toggle("bi-eye");
});

// Validate form
function validateForm() {
    var blnResult = true;

    // Get form data
    var input = document.getElementsByClassName('form_data');
    var error = document.getElementsByClassName('text-danger');
    var Password = document.getElementById('txtPassword').value.trim();
    var Confirm = document.getElementById('txtConfirm').value.trim();

    // Reset any error messages
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
            error[i].innerHTML = "Invalid Input";
            error[i].style.display = 'block';
            input[i].style.borderBottom = '2px solid red';
            input[i].focus();
            blnResult = false;
            return blnResult;
        }
    }

    // Validate matching passwords
    if (Confirm != Password) {
        document.getElementById('ConfirmError').innerHTML = "Passwords must match";
        document.getElementById('ConfirmError').style.display = 'block';
        document.getElementById('txtConfirm').style.borderBottom = '2px solid red';
        document.getElementById('txtConfirm').focus();
        blnResult = false;
        return blnResult;
    }

    // Return success
    return blnResult;
}

function ajax() {
    if (validateForm() == true) {
        var data = new FormData();
        data.append("txtPassword", document.getElementById('txtPassword').value.trim());

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../content/Process_ResetPassword3.php");
        xhr.onload = function(e) {
            // Receive either 'Success' or 'Failed' from PHP file
            var response = xhr.responseText;

            if (response == "Success") {
                // Display success
                document.getElementById('message').innerHTML = "Successfully Reset Password";          
                document.getElementById('message').style.display = "block";
                document.getElementById('message').style.color = "green";
                document.getElementById('message').style.borderBottom = "2px solid green";

                // Hide error message after 3 seconds
                setTimeout(() => {    
                    // Hide message  
                    document.getElementById('message').style.display = "none";

                    // Go to login page
                    window.location.href = "../content/Login.php";
                }, 3000);                
            } else {
                // Display error
                document.getElementById('message').innerHTML = "Failed To Reset Password";
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