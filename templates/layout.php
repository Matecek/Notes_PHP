<html>
<head>
</head>

<body>
<header class="header">
    <h1>Moje notatki</h1>
</header>

<div class="container">
    <nav>
        <ul>
            <li>
                <a href="/">Lista notatek</a>
            </li>
            <li>
                <a href="/?action=create">Nowa notatka</a>
            </li>
        </ul>
    </nav>

    <div>
        <?php
            include_once "templates/pages/$page.php";
        ?>
    </div>
</div>

<footer class="footer">
stopka
</footer>
</body>
</html>