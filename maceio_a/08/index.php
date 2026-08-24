<?php

/* Write your code here */

$isPost = $_SERVER["REQUEST_METHOD"] == "POST";
if ($isPost) {
    $celcius = $_POST["celcius"];
    $fahr = $celcius * 1.8 + 32;
    $fahr = number_format($fahr, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperature Converter</title>

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

        .result {
            margin-top: 24px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 8px;
        }

    </style>
</head>
<body>

<div class="container">

    <h1>Temperature Converter</h1>

    <form method="POST">

        <input
                type="number"
                step="0.01"
                name="celcius"
                placeholder="Enter temperature in Celsius"
                required
        >

        <button type="submit">
            Convert
        </button>

    </form>

    <?php if ($isPost): ?>
        <div class="result">
            <h3>Result</h3>
            <p>
                <strong>Fahrenheit:</strong>
                <?= $fahr ?> °F
            </p>
        </div>
    <?php endif ?>

</div>

</body>
</html>