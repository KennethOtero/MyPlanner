// Get form data
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#txtPassword");

// Toggle password eye
togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    
    // toggle the icon
    this.classList.toggle("bi-eye");
});

function validateForm() {
    // Return boolean
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

    // Validate
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

    return blnResult;
}

function ajax() {
    // Proceed if form has valid input
    if (validateForm() == true) {
        var data = new FormData();
        data.append("txtEmail", document.getElementById('txtEmail').value.trim());
        data.append("txtPassword", document.getElementById('txtPassword').value.trim());

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../content/Process_Login.php");
        xhr.onload = function(e) {
            // Receive either 'Success' or 'Failed' from PHP file
            var response = xhr.responseText;

            if (response == "Success") {
                // Redirect to homepage
                window.location.href = "../index.php";
            } else {
                // Display error
                document.getElementById('message').innerHTML = "Login Failed";
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