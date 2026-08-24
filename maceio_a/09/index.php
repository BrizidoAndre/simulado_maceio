<?php

/* Write your code here */
$isPost = $_SERVER["REQUEST_METHOD"] == "POST";
if ($isPost) {
    $errors = [];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $age = trim($_POST["age"]);
    if (empty($name) || empty($email) || empty($age)) {
        $errors[] = 'All fields are required.';
    }
    if (!preg_match("/^\w+@\w+\.\w{2,3}$/", $email)) {
        $errors[] = 'Invalid email address.';
    }
    if ($age < 18) {
        $errors[] = 'You must be at least 18 years old.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validator</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f4f6;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            padding: 12px;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .message {
            margin-top: 20px;
            padding: 14px;
            border-radius: 8px;
            font-weight: bold;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

    </style>
</head>
<body>

<div class="container">

    <h1>Form Validator</h1>

    <form method="POST">

        <input
                type="text"
                name="name"
                placeholder="Enter your name"
                required
        >

        <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
        >

        <input
                type="number"
                name="age"
                placeholder="Enter your age"
                required
        >

        <button type="submit">
            Submit
        </button>

    </form>

    <?php if ($isPost): ?>
        <?php if (count($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="message error">
                    <?= $error ?>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="message success">
                Registration completed successfully.
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>

</body>
</html>