
<?php
include('include/session_check.php');
checkRole('scale_company');
?>

<?php
   include('side-bar.php');
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Form</title>
    <!-- Include SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
     body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            margin-top: 120px;
            margin-left:700px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        .button1 {

            width: 100%;
            display: flex;
    justify-content: center;
    align-items: center;
 
            padding: 10px;
            font-size: 16px;
            color:rgb(255, 255, 255);
            background-color:rgb(68, 65, 65);
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button1:hover {
            background-color: #0056b3;
        }
        a {
    text-decoration: none; /* Removes underline */
    color: #fff; /* Inherits text color from parent */
}
        /* Mobile responsive styles */
        @media (max-width: 768px) {

            body {
        flex-direction: column;
        align-items: center;
        padding: 0px;
    }
    .form-container {
                width: 90%;
        max-width: 100%;
        margin-left: 0;
        padding: 0px;
        box-shadow: none;
            }
            /* .form-container {
                margin-top: 40px;
                padding: 20px;
            } */

            button {
                font-size: 14px;
            }

            .form-group input,
            .form-group textarea {
                font-size: 14px;
                padding: 8px;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .button1 {
                font-size: 14px;
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                margin-left: 0;
                flex-direction: column;
                width: 100%;
                padding:5px;
            }
            /* .form-container {
                margin-top: 20px;
                padding: 15px;
            } */

            button {
                font-size: 12px;
            }

            .form-group input,
            .form-group textarea {
                font-size: 12px;
                padding: 6px;
            }

            h2 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .button1 {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>

<?php 

include('include/header.php');
include('../include/config.php');
// Retrieve Request ID from URL
$request_id = isset($_GET['request_id']) ? $_GET['request_id'] : '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data safely
    $request_id = intval($_POST['request_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $attachment_path = '';

    // Handle file upload
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $file_name = $_FILES['attachment']['name'];
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_size = $_FILES['attachment']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_ext = ['pdf'];

        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = __DIR__ . '/../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create folder if it doesn't exist
            }

            $new_file_name = uniqid('quotation_') . '.' . $file_ext;
            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                $attachment_path = '../uploads/' . $new_file_name;
            } else {
                echo "<script>
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Error uploading the file.' });
                  </script>";
                exit;
            }
        } else {
            echo "<script>
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Only PDF files are allowed.' });
              </script>";
            exit;
        }
    } else {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please upload a PDF file.' });
          </script>";
        exit;
    }

    // Insert into database
    $query = "INSERT INTO weight_scales_quotations (repair_request_id, quotation_date, amount, quotation_attachment, remarks) 
              VALUES ('$request_id', NOW(), '$amount', '$attachment_path', '$remarks')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
            Swal.fire({ icon: 'success', title: 'Success!', text: 'Quotation submitted successfully.' });
          </script>";
    } else {
        echo "<script>
            Swal.fire({ icon: 'error', title: 'Error!', text: 'Database error: " . mysqli_error($conn) . "' });
          </script>";
    }
}
?>

<div class="form-container">
    <h2>Quotations</h2>
    <form action="scale-quotations.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="request-id">Request ID:</label>
            <input type="text" id="request-id" name="request_id" value="<?php echo htmlspecialchars($request_id); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="attachment">Attachment (PDF file):</label>
            <input type="file" id="attachment" name="attachment" accept=".pdf" required>
        </div>
        <div class="form-group">
            <label for="remarks">Remarks:</label>
            <textarea id="remarks" name="remarks" rows="4"></textarea>
        </div>
        <button type="submit">Submit Quotation</button></br>
        <button class="button1"><a href="pending.php"> Back </a></button>
    </form>
</div>

</body>
</html>
