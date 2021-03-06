// Validate the from
function validateForm() {
    // Result variable
    var blnResult = true;

    // Reset any error messages
    var input = document.getElementsByClassName('form_data');
    var error = document.getElementsByClassName('text-danger');
    for (var i = 0; i < input.length; i++) {
        // Remove red bar
        input[i].removeAttribute('style');
        // Remove date error message
        document.getElementById('dtmEnd').removeAttribute('style');
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

    // Make sure start time is after end time
    if (document.getElementById('dtmStart').value > document.getElementById('dtmEnd').value) {
        document.getElementById('EndError').innerHTML = "End Time Must Be After Start Time";
        document.getElementById('EndError').style.display = 'block';
        document.getElementById('dtmEnd').style.borderBottom = '2px solid red';
        document.getElementById('dtmEnd').focus();
        blnResult = false;
        return blnResult;
    }

    return blnResult;
}

// Insert data into DB without refreshing the page
function ajax() {
    // Proceed if form is validated
    if (validateForm() == true) {
        var data = new FormData();
        var Success = document.getElementById('message');

        // Set boolean status on whether or not a day is checked 
        if (document.getElementById('chkMonday').checked) {
            var Monday = 1;
        } else {
            var Monday = 0;
        }
        if (document.getElementById('chkTuesday').checked) {
            var Tuesday = 1;
        } else {
            var Tuesday = 0;
        }
        if (document.getElementById('chkWednesday').checked) {
            var Wednesday = 1;
        } else {
            var Wednesday = 0;
        }
        if (document.getElementById('chkThursday').checked) {
            var Thursday = 1;
        } else {
            var Thursday = 0;
        }
        if (document.getElementById('chkFriday').checked) {
            var Friday = 1;
        } else {
            var Friday = 0;
        }

        // Add form data to send to PHP
        data.append("txtNumber", document.getElementById('txtNumber').value.trim());
        data.append("txtCourse", document.getElementById('txtCourse').value.trim());
        data.append("txtInstructor", document.getElementById('txtInstructor').value.trim());
        data.append("Monday", Monday);
        data.append("Tuesday", Tuesday);
        data.append("Wednesday", Wednesday);
        data.append("Thursday", Thursday);
        data.append("Friday", Friday);
        data.append("dtmStart", document.getElementById('dtmStart').value.trim());
        data.append("dtmEnd", document.getElementById('dtmEnd').value.trim());

        // Get intCourseID from querystring
        const urlParams = new URLSearchParams(location.search);
        for (const value of urlParams.values()) {
            // Get ID
            var intCourseID = value;
        }

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../restricted/Process_UpdateCourse.php?ID=" + intCourseID);
        xhr.onload = function() {
            var response = xhr.responseText;
            if (response == "Success") {
                // Show success
                Success.innerHTML = "COURSE UPDATED";
                Success.style.display = 'block';
                Success.style.color = 'green';
                Success.style.borderBottom = '2px solid green';

                // Hide success message after 5 seconds and go to Tasks
                setTimeout(() => {                
                    Success.style.display = 'none';
                    window.location.href = "Tasks.php";
                }, 5000);
            } else {
                // Display error
                Success.innerHTML = "Failed To Update Course";
                Success.style.display = 'block';
                Success.style.color = 'red';
                Success.style.borderBottom = '2px solid red';

                // Hide message
                setTimeout(() => {                
                    Success.style.display = 'none';
                }, 5000);
            }
        };
        xhr.send(data); // Send form data for PHP processing

        // Prevent html form submit
        return false; // should be false
    } else {
        // Return false to prevent page refresh so that error message can show
        return false;
    }
}

function deleteCourse() {
    if (validateForm() == true) {
        // Get form data
        var data = new FormData();
        var Success = document.getElementById('message');

        // Ask to delete
        if (confirm("Are you sure you want to delete this course?")) {
            // Get intCourseID from querystring
            const urlParams = new URLSearchParams(location.search);
            for (const value of urlParams.values()) {
                // Get ID
                var intCourseID = value;
            }

            // AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../restricted/Process_DeleteCourse.php?ID=" + intCourseID);
            xhr.onload = function() {
                var result = xhr.responseText;
                if (result == "Success") {
                    // Show success
                    Success.innerHTML = "COURSE DELETED";
                    Success.style.display = 'block';
                    Success.style.color = 'green';
                    Success.style.borderBottom = '2px solid green';

                    // Hide success message after 5 seconds
                    setTimeout(() => {                
                        Success.style.display = 'none';
                        window.location.href = "Tasks.php";
                    }, 3000);
                } else {
                    Success.innerHTML = "Deletion Failed";
                    Success.style.display = 'block';
                    Success.style.color = 'red';
                    Success.style.borderBottom = '2px solid red';

                    // Hide failed message after 5 seconds
                    setTimeout(() => {                
                        Success.style.display = 'none';
                    }, 5000);
                }
                
            };
            xhr.send(data); // Send form data for PHP processing
        }

        // Prevent html form submit
        return true;
    } else {
        return false;
    }
}
