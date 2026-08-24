<?php
$files = array_diff(scandir('uploads'), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Manager</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>File Upload Manager</h1>

    <form
            action="upload.php"
            method="POST"
            enctype="multipart/form-data"
            class="upload-form"
    >

        <label class="upload-area">

            <p>Select a file to upload</p>

            <input
                    type="file"
                    name="file"
                    required
            >

        </label>

        <button type="submit">
            Upload File
        </button>

    </form>

    <div class="file-list">

        <h2>Uploaded Files</h2>

        <?php if (count($files)): ?>
            <ul>
                <?php foreach ($files as $file): ?>
                    <li class="my-2">
                        <a href="uploads/<?= $file ?>" download="<?= $file ?>">
                            <span>
                                <?= $file ?>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No uploaded files yet.</p>
        <?php endif ?>
    </div>

</div>

</body>
</html>