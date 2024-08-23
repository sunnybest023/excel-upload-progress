<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Upload with Progress</title>
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Basic styles for the page */
        body {
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .progress-bar {
            transition: width 0.4s; /* Smooth transition for progress bar */
        }
        .alert {
            display: none; /* Hide alert by default */
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Upload Excel File</h2>
    <!-- Form to upload file and specify number of records -->
    <form id="uploadForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Select Excel File:</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="record_count">Enter Number of Records:</label>
            <input type="number" name="record_count" id="record_count" class="form-control" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Upload</button>
        </div>
    </form>
    <!-- Progress bar to show upload progress -->
    <div class="progress mb-3">
        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
    <!-- Message area to show upload status -->
    <div id="message" class="alert"></div>
    <!-- Button to view records, hidden by default -->
    <a href="view.php" id="viewButtonLink">
        <button id="viewButton" class="btn btn-success btn-block" style="display: none;">View Records</button>
    </a>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    // Handle form submission
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        let formData = new FormData(this); // Create FormData object

        $.ajax({
            url: 'upload.php', // URL to send the request to
            type: 'POST', // HTTP method
            data: formData, // Form data
            contentType: false, // Set content type to false for multipart/form-data
            processData: false, // Do not process the data
            xhr: function() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 3) { // Processing
                        let data = xhr.responseText;
                        console.log(xhr.responseText);

                        let progress_data = data.split('##'); // Split response by '##'
                        console.log(typeof progress_data);
                        let lastThreeValues = progress_data.slice(-3); // Get last 3 values

                        if (progress_data.length >= 3) {
                            // Update progress bar
                            $('.progress-bar').width(lastThreeValues[0] + '%').text(lastThreeValues[1] + ' out of ' + lastThreeValues[2]);
                            $('.progress-bar').attr('aria-valuenow', lastThreeValues[0]);
                        }
                    }
                };
                return xhr;
            },
            success: function(response) {
                if (typeof response == 'string') {
                    let data = response.split('##'); // Split response by '##'
                    let lastThreeValues = data.slice(-3); // Get last 3 values
                    console.log(lastThreeValues[1]);
                    console.log(lastThreeValues[2]);
                    console.log(lastThreeValues[3]);

                    let msg = lastThreeValues[0];
                    if (lastThreeValues[1] > 0) {
                        msg = lastThreeValues[0] + '<br>' + lastThreeValues[1] + ' records are not added because of duplication.';
                    }

                    // Show success message
                    $('#message').removeClass('alert-danger').addClass('alert alert-info').html(msg).show();

                    // Show view button if all records are processed
                    if (lastThreeValues[2] == 'true') {
                        $('#viewButton').show();
                    }
                    resetForm();


                } else {
                    let data = JSON.parse(response);
                    if (data.message) {
                        $('#message').removeClass('alert-danger').addClass('alert alert-info').html(data.message).show();
                    }
                   
                }
            },
            error: function() {
                // Show error message if request fails
                $('#message').removeClass('alert-info').addClass('alert alert-danger').html('An error occurred while uploading the file.').show();
            }
        });
    });
});
</script>
</body>
</html>
