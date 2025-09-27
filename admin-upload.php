<?php
// --- Define categories ---
$categories = [
    'logos' => 'Logos',
    'social' => 'Social Media Posts',
    'travel' => 'Travel Flyers',
    'political' => 'Political Posters',
    'general' => 'General Flyers',
    'mockups' => 'Mockups'
];

$uploadDir = 'uploads/'; // base folder for uploads
$message = "";

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'] ?? '';
    if (!isset($categories[$category])) {
        $message = "Invalid category selected!";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $message = "Please select a valid image file!";
    } else {
        $targetDir = $uploadDir . $category . '/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // create folder if it doesn't exist
        }

        $filename = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $filename;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExtensions)) {
            $message = "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.";
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $message = "Image uploaded successfully to category '$category'.";
            } else {
                $message = "Failed to upload the image. Check folder permissions.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Upload | TMGRAFIXLAB</title>
<style>
    body { font-family: Arial, sans-serif; padding: 2rem; background: #f5f5f5; }
    h1 { text-align: center; color: #ff0000; }
    form { max-width: 500px; margin: 2rem auto; padding: 1.5rem; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    label { display: block; margin-top: 1rem; font-weight: bold; }
    select, input[type="file"], button { width: 100%; margin-top: 0.5rem; padding: 0.5rem; border-radius: 5px; border: 1px solid #ccc; }
    button { background: #ff0000; color: #fff; font-weight: bold; border: none; cursor: pointer; }
    button:hover { background: #cc0000; }
    .message { text-align: center; margin-top: 1rem; font-weight: bold; color: green; }
</style>
</head>
<body>

<h1>Admin Upload Page</h1>

<?php if($message): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="category">Select Category:</label>
    <select name="category" id="category" required>
        <option value="">-- Choose a category --</option>
        <?php foreach($categories as $key => $name): ?>
            <option value="<?= $key ?>"><?= $name ?></option>
        <?php endforeach; ?>
    </select>

    <label for="image">Select Image:</label>
    <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.gif,.webp" required>

    <button type="submit">Upload Image</button>
</form>

</body>
</html>
