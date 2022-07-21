function validateForm() {
    // Declare variables
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
        if (input[i].id != 'txtDetails') {
            if (input[i].value.trim() == "" || input[i].value.trim() == 0) {
                error[i].innerHTML = "Invalid Input";
                error[i].style.display = 'block';
                input[i].style.borderBottom = '2px solid red';
                input[i].focus();
                blnResult = false;
                return blnResult;
            }
        }
    }

    return blnResult;
}

function ajax() {
    if (validateForm() == true) {
        var data = new FormData();
        var Success = document.getElementById('message');
        data.append("cboCourses", document.getElementById('cboCourses').value.trim());
        data.append("dtmDate", document.getElementById('dtmDate').value.trim());
        data.append("txtTitle", document.getElementById('txtTitle').value.trim());
        data.append("txtDetails", document.getElementById('txtDetails').value.trim());

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../content/restricted/Process_AddTask.php");
        xhr.onload = function() {
            var result = xhr.responseText;
            if (result == "Success") {
                // Show success
                Success.innerHTML = "ASSIGNMENT ADDED";
                Success.style.display = 'block';
                Success.style.color = 'green';
                Success.style.borderBottom = '2px solid green';

                // Hide success message after 5 seconds and go back to tasks
                setTimeout(() => {                
                    Success.style.display = 'none';
                    window.location.href = "../content/Tasks.php";
                }, 5000);
            } else {
                Success.innerHTML = "Failed To Add Assignment";
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
