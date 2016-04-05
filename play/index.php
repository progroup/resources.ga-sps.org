<?php

    // http://www.sitepoint.com/re-introducing-pdo-the-right-way-to-access-databases-in-php

    include_once('config.php');

    $connection =  new PDO("mysql:host={$hostname};dbname={$dbname};charset=utf8", $username, $password);



    $sql = 'SELECT distinct(name), id FROM agency order by name asc';
    $statement = $connection->query($sql);

    // $result_mail = mysql_query($sql) or die(mysql_error());
    // $num_rows = mysql_num_rows($result_mail);

    // foreach( $connection->query('SELECT * FROM help') as $row) {
    //     echo "{$row['id']} {$row['fname']}<br>";
    // }

    // foreach( $statement as $row) {
    //     echo "{$row['name']}<br>";
    // }

    // while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    //     echo "{$row['name']}<br>";
    // }
