<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">

    <style>
        html, body {
            margin: 0;
            height: 100%;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Montserrat', sans-serif;
            background-color: #232134;
            color: #fff;
            text-align: center;
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

<div class="message">
    <?= $this->getMessage(); ?>
</div>

</body>
</html>