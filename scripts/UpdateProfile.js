// Get form data
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#txtPassword");
const toggleConfirm = document.querySelector("#toggleConfirm");
const confirm = document.querySelector("#txtConfirm");

// Toggle password eye
togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    
    // toggle the icon
    this.classList.toggle("bi-eye");
});
toggleConfirm.addEventListener("click", function () {
    // toggle the type attribute
    const type = confirm.getAttribute("type") === "password" ? "text" : "password";
    confirm.setAttribute("type", type);
    
    // toggle the icon
    this.classList.toggle("bi-eye");
});

function validateForm() {
    var blnResult = true;

    // Get form data
    var Password = document.getElementById('txtPassword').value.trim();
    var Confirm = document.getElementById('txtConfirm').value.trim();

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
        if (input[i].value.trim() == "" || input[i].value.trim() == 0) {
            error[i].innerHTML = "Invalid Input";
            error[i].style.display = 'block';
            input[i].style.borderBottom = '2px solid red';
            input[i].focus();
            blnResult = false;
            return blnResult;
        }
    }

    // Validate matching passwords
    if (Password != Confirm) {
        document.getElementById('ConfirmError').innerHTML = "Passwords must match";
        document.getElementById('ConfirmError').style.display = 'block';
        document.getElementById('txtConfirm').style.borderBottom = '2px solid red';
        document.getElementById('txtConfirm').focus;
        blnResult = false;
        return blnResult;
    }

    return blnResult;
}

function ajax() {
    if (validateForm() == true) {
        var data = new FormData();
        var Success = document.getElementById('message');
        data.append("txtName", document.getElementById('txtName').value.trim());
        data.append("txtEmail", document.getElementById('txtEmail').value.trim());
        data.append("txtPassword", document.getElementById('txtPassword').value.trim());
        data.append("txtSecurity", document.getElementById('txtSecurity').value.trim());

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../content/Process_Profile.php");
        xhr.onload = function() {
            var result = xhr.responseText;
            if (result == "Success") {
                // Show success
                Success.innerHTML = "PROFILE UPDATED";
                Success.style.display = 'block';
                Success.style.color = 'green';
                Success.style.borderBottom = '2px solid green';

                // Hide success message after 5 seconds
                setTimeout(() => {                
                    Success.style.display = 'none';
                }, 5000);
            } else {
                Success.innerHTML = "Failed To Update Profile";
                Success.style.display = 'block';
                Success.style.color = 'red';
                Success.style.borderBottom = '2px solid red';
            }
            
        };
        xhr.send(data); // Send form data for PHP processing

        // Prevent html form submit
        return false; // should be false
    } else {
        return false;
    }
}