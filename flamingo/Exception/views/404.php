<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 | Not Found</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">

    <style>
        html, body {
            background-color: #29263D;
            color: #e5e5e5;
            font-family: 'Montserrat', sans-serif;
            font-weight: normal;
            height: 100vh;
            margin: 0;
        }

        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .code {
            font-size: 2rem;
            font-weight: bold;
            color: #ef522b;
        }

        b {
            color: #ef522b;
        }

        .message {
            padding-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="code">
            <?= $this->getCode(); ?>
        </div>
        <div class="message">
            <?= $this->getMessage(); ?>
        </div>
    </div>
</body>
</html>