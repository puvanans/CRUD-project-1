<?php
        /*This page is to design the deleting mechanism.
        (i.e) this page will decide what happens when the user is redirected to this page after hitting the delete button in the view page.
        When the hyperlink for the delete button has also been programmed to contain the id for the particular record for which the delete button was presed.
        And hence the id position of the record in the database is sent to this page in the URL via GET method.
        This also implies that there should be a Super Global variable for id created, this would be the starting point.
        
        The id would first need to be checked/validated.
        Should the id be valid, SQL statements (with place holders) must be prepared to find the row in the table 'id' column where id = $id,
        then the parameters must be binded to the statement and then executed.
        And the statement closed.
        And the user is re-directed to the view page.

        There must be a clock in place to catch error and display that tot he user.*/

        include("connect-db.php");

        if (($_GET['id']) && is_numeric($_GET['id']))
            {
                $id = $_GET['id'];
                if ($stmt = $mysqli->prepare("DELETE FROM batsmen WHERE id=? "))
                    {
                        $stmt->bind_param('i',$id);
                        $stmt->execute();
                        $stmt->close;
                    }
                else
                {
                    echo "Statement could not be prepared";
                }
            $mysqli->close();

            header("Location:view.php");
            
            }
        else
        {
            echo "There seems to be some problem deleting stuff";
        }



?>