<?php
$IMGUR_CLIENT_ID = "d50e66f2514dc6e"; // client id for the website -> do not modify
$statusMsg = "";

if (isset($_POST['submit'])) {

    // check if the user choose a file
    if (!empty($_FILES["image"]["name"])) {

        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // check file extension
        if (in_array($fileType, array('jpg', 'png', 'jpeg'))) {

            $image_source = file_get_contents($_FILES['image']['tmp_name']);

            // API post parameters
            $postFields = array('image' => base64_encode($image_source));

            // Post image to Imgur via API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $IMGUR_CLIENT_ID));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            $response = curl_exec($ch);
            curl_close($ch);

            // Convert API response to array
            $imgurData = json_decode($response);

            // Check if image has been upload successfully
            if (!empty($imgurData->data->link)) {

                // put $imgurData->data->link in USER.PROFIL_PIC -------------------------------------------------------

                $statusMsg = 'The image has been uploaded to Imgur successfully.';
            } else {
                $statusMsg = 'Image upload failed, please try again.';
            }
        } else {
            $statusMsg = 'Only .png, .jpg and .jpeg file are allowed.';
        }
    } else {
        $statusMsg = 'No file were selected.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test du PHP</title>
</head>
<body>
<form method="post" action="" enctype="multipart/form-data">
    <label>Image : </label>
    <input type="file" name="image" accept=".png, .jpg, .jpeg">
    <br>
    <input type="submit" name="submit" value="Upload to Imgur"/>
    <p><?php echo $statusMsg ?></p>
</form>
</body>
</html>