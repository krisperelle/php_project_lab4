<html>
    <head>
        <title>Counting with the SESSION array</title>
    </head>
    <body>
        <FORM action="session.php" method="GET">
            <INPUT type="submit" name="Count" value="Count">
            <?php
            session_start();
            if (!isset($_SESSION['counter']))
                $count = 0;
            else
                $count = $_SESSION['counter'];
            $count = $count + 1;
            $_SESSION['counter'] = $count;
            echo "count is $count";
            ?>
        </FORM>

    </body>
</html>

//isset determines if a variable is set and is not NULL
//data about the user thats stored on the server, aka something that keeps you logged into a website even if you close the browser and open it once again
