<?php
session_start();
?>

<html>
    <head>
        <meta charset = "utf-8">
        <title> Database Handler </title>
    </head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, tr{
            border: 1px solid blue;
        }
        td{
            margin: 1px;
        }
        h1 {
            text-align: center;
        }
        .white {
            color: white;
        }
    </style>
    <body>
        <table>
            <?php
                $con= mysqli_connect('sql9.freemysqlhosting.net','sql9199270','i15uCP9scf','sql9199270','3306');
                //I already had the table set up in the database beforehand
                $tablename = 'registered_users';

                //but this would create one if it doesn't exist already
                $con->query('CREATE TABLE registered_users(
                                fname varchar(50) NOT NULL,
                                lname varchar(50) NOT NULL,
                                address1 varchar(95) NOT NULL,
                                address2 varchar(95),
                                city varchar(30) NOT NULL,
                                state varchar(30) NOT NULL,
                                zip int(9) NOT NULL,
                                country varchar(30) NOT NULL,
                                date varchar(20) NOT NULL
                                );
                            ');
                if(isset($_POST["adduser"])){
                    // Check connection
                    if (mysqli_connect_errno())
                      {
                      echo 'Failed to connect to MySQL:' . mysqli_connect_error();
                      }

                    //gets information from the form post
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $adr1 = $_POST['address1'];
                    $adr2 = $_POST['address2'];
                    $city = $_POST['city'];
                    $state= $_POST['state'];
                    $zip = $_POST['zip'];
                    $country = $_POST['country'];
                    date_default_timezone_set('America/New_York');
                    $date = date('m/d/Y h:i:s a', time());

                    //adds it to the database
                    mysqli_query($con,"INSERT INTO registered_users(fname, lname, address1, address2, city, state, zip, country, date) VALUES ('$fname','$lname','$adr1','$adr2','$city','$state','$zip','$country','$date');");

                    echo '<h1> Thank you for your submition </h1>';

                    //Changing background color to match registration form
                    echo '<script> document.body.style.background = "rgb(0,183,234)";';
                    echo 'document.body.style.background = "-moz-linear-gradient(top, rgba(0,183,234,1) 0%, rgba(0,158,195,1) 100%)";';
                    echo 'document.body.style.background = "-webkit-linear-gradient(top, rgba(0,183,234,1) 0%,rgba(0,158,195,1) 100%)";';
                    echo 'document.body.style.filter = "progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#00b7ea\', endColorstr=\'#009ec3\',GradientType=0 )";';
                    echo '</script>';
                }
                else if(isset($_POST["List_Users"])){

                    // I am creating and populating the table here
                    // Keeping the background white so it is easier to read

                    $results = $con->query("SELECT * FROM registered_users ORDER BY date DESC");
                    $attributes = array('First Name', 'Last Name', 'Address1', 'Address2', 'City', 'State', 'Zip', 'Country', 'Date');
                    echo '<tr bgcolor ="#5481B8">';
                    for($j = 0; $j < 9; $j++){
                        echo '<td class = white>';
                        echo $attributes[$j];
                        echo '</td>';
                    }
                    echo '</tr>';
                    $lightblue = true; //Making rows different colors to read easier
                    while($row = $results->fetch_array(MYSQLI_NUM)){
                        if($lightblue){
                            echo '<tr bgcolor = "#D3DFED">';
                            $lightblue = false;
                        }
                        else{
                            $lightblue = true;
                        }
                        echo '<td>';
                        echo '<span style=\'font-weight:bold;\'>';
                        echo $row[0];
                        echo '</span></td>';
                        for($i = 1; $i < 9; $i++){
                            echo '<td>';
                            echo $row[$i];
                            echo '</td>';
                        }
                        echo '</tr>';

                    }
                }
                else{
                    // Did not access this page through github urls
                    echo "Sorry you are not allowed to access this page";
                }

                mysqli_close($con);
            ?>
        </table>
    </body>
</html>
