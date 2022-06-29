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
        if (input[i].value.trim() == "" || input[i].value.trim() == 0) {
            error[i].innerHTML = "Invalid Input";
            error[i].style.display = 'block';
            input[i].style.borderBottom = '2px solid red';
            blnResult = false;
            return blnResult;
        }
        if (input[i].id == 'txtYear') {
            if (!isNumeric(input[i].value.trim())) {
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

// Validate a number
function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function ajax() {
    if (validateForm() == true) {
        var data = new FormData();
        var Success = document.getElementById('message');
        data.append("cboSemesters", document.getElementById('cboSemesters').value.trim());
        data.append("txtYear", document.getElementById('txtYear').value.trim());
        data.append("dtmStart", document.getElementById('dtmStart').value.trim());
        data.append("dtmEnd", document.getElementById('dtmEnd').value.trim());

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../content/Process_AddSemester.php");
        xhr.onload = function() {
            var result = xhr.responseText;
            if (result == "Success") {
                // Show success
                Success.innerHTML = "SEMESTER ADDED";
                Success.style.display = 'block';
                Success.style.color = 'green';
                Success.style.borderBottom = '2px solid green';

                // Hide success message after 5 seconds
                setTimeout(() => {                
                    Success.style.display = 'none';
                }, 5000);
            } else {
                // Show error
                Success.innerHTML = "Failed To Add Semester";
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