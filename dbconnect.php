<?php
$duplicate = false;
$success = false;
$fail = false;
if(isset($_POST["submit"]))
{
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "info";
    
    $conn = mysqli_connect($server, $username, $password, $db);
    // INSERT INTO `enrolments` (`sno`, `name`, `email`, `contact`, `gender`, `institute`, `marks`, `department`, `date & time`) VALUES ('1', 'test name', 'testemail@email.com', '1234567890', 'male', 'test institute', '85', 'BCA', current_timestamp())
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];
    $school = $_POST["school"];
    $marks12 = $_POST["marks12"];
    $dept = $_POST["dept"];

    $result = mysqli_query($conn, "SELECT * FROM enrolments WHERE email='$email'");
    $num_rows = mysqli_num_rows($result);

    if ($num_rows>0) 
    {
        $duplicate = true;
    }
    else
    {
        $sql = "INSERT INTO `enrolments` (`name`, `email`, `contact`, `gender`, `institute`, `marks`, `department`, `date & time`) VALUES ('$name', ' $email', '$phone', '$gender', ' $school', '$marks12', ' $dept', current_timestamp())";

        $result2 = mysqli_query($conn, $sql);
        if($result2)
        {
            $success = true;
        }
        else
        {
            $fail = true;
        }

    //uploading media

        $file = $_FILES['file'];
        
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        // $fileType = $_FILES['file']['type'];


        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));//to extract the file extensiom

        $allowed = array('pdf');

        if(in_array($fileActualExt, $allowed))
        {
            if($fileError === 0)
            {
                if($fileSize < 1000000)
                {
                    // $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileNameNew = $_POST['name']."_".$_POST['phone'].".".$fileActualExt;
                    $fileDestination  = 'uploads/'. $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("Location: about.php#en?Uploadsuccess");
                }
                else
                {
                    echo "Your file is too big";
                }

            }
            else
            {
                echo "There was an error uploading the file";
            }
        }
        else
        {
            echo "Your file is not a PDF";
        }
    }

}    
?>