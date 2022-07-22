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

    // Validate
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
    
    return blnResult;
}

function ajax() {
    if (validateForm() == true) {
        var data = new FormData();
        var Success = document.getElementById('message');
        data.append("cboSemesters", document.getElementById('cboSemesters').value.trim());

        // Check if current semester button was clicked
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../restricted/Process_EditSemester.php");
        xhr.onload = function() {
            var result = xhr.responseText;
            if (result == "Success") {
                // Show success
                Success.innerHTML = "SEMESTER UPDATED";
                Success.style.display = 'block';
                Success.style.color = 'green';
                Success.style.borderBottom = '2px solid green';

                // Hide success message after 5 seconds
                setTimeout(() => {                
                    Success.style.display = 'none';
                }, 5000);
            } else {
                // Show error
                Success.innerHTML = "SEMESTER UPDATED";
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

function deleteSemester() {
    if (validateForm() == true) {
        // Get form data
        var data = new FormData();
        var Success = document.getElementById('message');
        data.append("cboSemesters", document.getElementById('cboSemesters').value.trim());

        // Ask to delete
        if (confirm("Are you sure you want to delete this semester?")) {
            // AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../restricted/Process_DeleteSemester.php");
            xhr.onload = function() {
                var result = xhr.responseText;
                if (result == "Success") {
                    // Show success
                    Success.innerHTML = "SEMESTER DELETED";
                    Success.style.display = 'block';
                    Success.style.color = 'green';
                    Success.style.borderBottom = '2px solid green';

                    // Hide success message after 5 seconds
                    setTimeout(() => {                
                        Success.style.display = 'none';
                    }, 5000);
                } else {
                    Success.innerHTML = "Deletion Failed";
                    Success.style.display = 'block';
                    Success.style.color = 'red';
                    Success.style.borderBottom = '2px solid red';
                }
                
            };
            xhr.send(data); // Send form data for PHP processing

            // Adjust select box to remove deleted semesters
            var Semesters = document.getElementById("cboSemesters");
            Semesters.remove(Semesters.selectedIndex);
        }

        // Prevent html form submit
        return true;
    } else {
        return false;
    }
}