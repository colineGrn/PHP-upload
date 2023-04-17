<?php

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $age = $_POST['age'];

    $uploadDir = 'public/uploads/';

    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    $authorizedExtensions = ['jpg','png','gif', 'webp'];

    $maxFileSize = 1000000;

    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Please select an image in jpg, png, gif or webp';
    }

    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
        $errors[] = "Your file must be less than 1Mo";
    }

    $uniqueId = uniqid('profile-');
    $uploadFile = $uploadDir . $uniqueId . '-' . basename($_FILES['avatar']['name']);

    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laisse pas traîner ton file</title>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname"><br><br>

    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname"><br><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age"><br><br>

    <label for="imageUpload">Upload your profile image</label>
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>
</form>

<?php
if(isset($uploadFile) && isset($lastname) && isset($firstname) && isset($age)): ?>
    <div>
        <img src="<?= $uploadFile ?>" alt="Profile image">
        <p>Last Name: <?= $lastname ?></p>
        <p>First Name: <?= $firstname ?></p>
        <p>Age: <?= $age ?></p>
    </div>
<?php endif; ?>

</body>
</html>