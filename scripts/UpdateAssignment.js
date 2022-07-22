// Show slider value
var slider = document.getElementById("slider");
var output = document.getElementById("output");
output.innerHTML = slider.value;

slider.oninput = function() {
output.innerHTML = this.value;
}

// Validation
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
        // Validate everything but details text area
        if (!input[i].id == "txtDetails") {
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

    // Return success
    return blnResult;
}

function ajax() {
    if (validateForm() == true) {
        // Get intAssignmentID from querystring
        const urlParams = new URLSearchParams(location.search);
        for (const value of urlParams.values()) {
            // Get ID
            var intAssignmentID = value;
        }

        // Get form data
        var data = new FormData();
        data.append("rngSlider", document.getElementById('slider').value.trim());
        data.append("cboCourses", document.getElementById('cboCourses').value.trim());
        data.append("dtmDate", document.getElementById('dtmDate').value.trim());
        data.append("txtTitle", document.getElementById('txtTitle').value.trim());
        data.append("txtDetails", document.getElementById('txtDetails').value.trim());

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../restricted/Process_UpdateAssignment.php?ID=" + intAssignmentID);
        xhr.onload = function(e) {
            // Receive either 'Success' or 'Failed' from PHP file
            var response = xhr.responseText;

            if (response == "Success") {
                // Display success
                document.getElementById('message').innerHTML = "Successfully Updated Assignment";          
                document.getElementById('message').style.display = "block";
                document.getElementById('message').style.color = "green";
                document.getElementById('message').style.borderBottom = "2px solid green";

                // Hide error message after 3 seconds
                setTimeout(() => {    
                    // Hide message  
                    document.getElementById('message').style.display = "none";

                    // Go to tasks page
                    window.location.href = "Tasks.php";
                }, 3000);                
            } else {
                // Display error
                document.getElementById('message').innerHTML = "Failed To Update Assignment";
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

function deleteAssignment() {
    if (validateForm() == true) {
        if (confirm("Are you sure you want to delete this assignment?")) {
            // Get form data
            var data = new FormData();

            // Get intAssignmentID from querystring
            const urlParams = new URLSearchParams(location.search);
            for (const value of urlParams.values()) {
                // Get ID
                var intAssignmentID = value;
            }

            // AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../restricted/Process_DeleteAssignment.php?ID=" + intAssignmentID);
            xhr.onload = function() {
                // Receive either 'Success' or 'Failed' from PHP file
                var response = xhr.responseText;

                if (response == "Success") {
                    // Display success
                    document.getElementById('message').innerHTML = "ASSIGNMENT DELETED";          
                    document.getElementById('message').style.display = "block";
                    document.getElementById('message').style.color = "green";
                    document.getElementById('message').style.borderBottom = "2px solid green";

                    // Hide error message after 3 seconds
                    setTimeout(() => {    
                        // Hide message  
                        document.getElementById('message').style.display = "none";

                        // Go to tasks page
                        window.location.href = "Tasks.php";
                    }, 3000);                
                } else {
                    // Display error
                    document.getElementById('message').innerHTML = "Failed To Delete Assignment";
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
        }
        return true;
    } else {
        return false;
    }
}