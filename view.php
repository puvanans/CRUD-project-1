<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>View</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
       
       <?php
             
             include("connect-db.php");
             
             echo "<h1>View</h1>";

            if ($result = $mysqli->query("SELECT * FROM batsmen ORDER BY id"))
                {
                    

                    if($result->num_rows > 0)
                       {
                        echo "The table 'batsmen' has ".$result->num_rows." rows in it";

                        echo "<br></br>"; 

                        echo "<Table border = 1px cellpadding = 10 px>";
                        
                        echo "<th> ID </th> <th> First Name </th> <th> Last Name </th><th> Country </th>
                             <th> </th> <th> </th>";
                        
                        while ($row = $result->fetch_object())
                        
                            {
                                echo "<tr>";
                                echo "<th>".$row->id."</th>";
                                echo "<td>".$row->firstname."</td>";
                                echo "<td>".$row->lastname."</td>";
                                echo "<td>".$row->country."</td>";
                                echo "<td> <a href='records.php?id=".$row->id."'> Edit </a> </td>";
                                echo "<td> <a href='delete.php?id=".$row->id."'>Delete </a></td>";
                                echo "</tr>";
                            }

                        echo "</Table>";
                      }

                    else
                    {
                        echo "No result to display";
                    }

                }

            else {
                echo "Error".$mysqli->error;
                 }

            $mysqli->close();
        ?>
         <a href = 'records.php'> Add New records</a>

    </body>
</html>