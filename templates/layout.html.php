<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="./assets/images/internet-jokes.jpg">

    <link rel="stylesheet" href="./assets/css/style.css">
    <title><?php echo $title ?></title>
</head>
<body>
<header class="site-header" id="site-header">
    <h1>Internet Joke Database</h1>
    <nav>
        <div class="container">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?action=list">Jokes</a></li>
                <li><a href="index.php?action=edit">Add Joke</a></li>
            </ul>
        </div>
    </nav>
</header>

<main class="container"><?php echo $output ?></main>

<footer>
    <div class="container">
        <p>&copy; IJDB 2021</p>
    </div>
</footer>
</body>
</html>
