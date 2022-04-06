<?php
    /*
     This page will define a function (renderFunction) which will contain the functionalities for both adding a new record and editing an existing record.
     Conditionals will direct the control flow of the application.
     */
    include ("connect-db.php");

     
    function renderForm($firstname='',$lastname='',$country='',$id='',$error='')

    { ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>
                    <?php
                        if($id!=""){ echo "Edit Record";}
                        else {echo "New Record";}
                    ?>
                </title>
                <meta name="description" content="">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="">
            </head>
            <body>
                
                <h1>
                    <?php
                        if($id!='') 
                            { echo "Edit Record";}
                        else 
                            {echo "New Record";}
                    ?>
                </h1>
                
                <?php
                    if ($error!='')
                    {
                        echo "<div style='padding:4px; border:1px solid black; color:red;'>".$error."</div>";
                    }
                ?>

                <form action='' method ='POST'>
                    <div>
                        <?php
                        if($id!="")
                        { ?>
                        <input type='hidden' name='id' value= '<?php echo $id; ?>'>
                        <?php
                        } ?>
                        
                        <strong>*First Name</strong>
                        <input type='text' name='firstname' value= '<?php echo $firstname;?>'>
                        <br><br>
                        <strong>*Last Name</strong>
                        <input type='text' name='lastname' value= '<?php echo $lastname;?>'>
                        <br><br>
                        <strong>*Country</strong>
                        <input type='text' name='country' value= '<?php echo $country;?>'>
                        <br><br>
                        <input type='submit' name='submit' value='submit'>
                        <p>
                            *Means required
                        </p>    
                    </div>
                </form>
            </body>
        </html>

    <?php 
    }

            /*
            The application will have code blocks to process the form based on whether the task is to edit or add a new entry.
            */


            //The first block will process the form in the case of editing a new record.
    
    if(isset($_GET['id']))
    
            //id in the $_GET super global exists only when the records page is reached through the edit link, and hence this block deals exclusive with editing the page.
    {

        if (isset($_POST['submit']))
            {
                if (isset($_POST['id']) && is_numeric($_POST['id']))

                {
                    $id = $_POST['id'];
                    $firstname = htmlentities($_POST['firstname'],ENT_QUOTES);
                    $lastname = htmlentities($_POST['lastname'],ENT_QUOTES);
                    $country = htmlentities($_POST['country'],ENT_QUOTES);

                    if($firstname==''||$lastname==''||$country=='')

                        {
                            $error='Please enter all the relevant information';
                            renderForm($firstname,$lastname,$country,$id,$error);
                        }

                    else

                        {
                            if($stmt = $mysqli->prepare('UPDATE batsmen SET firstname=?,lastname=?,country=? WHERE id =?'))

                                {
                                    $stmt->bind_param('sssi',$firstname,$lastname,$country,$id);
                                    $stmt->execute();
                                    $stmt->close();
                                }

                            else
                                {
                                    $error = "SQL statement could not be prepared";
                                    renderForm($firstname,$lastname,$country,$id,$error);
                                }

                            header ('Location:view.php');
                        }
                } 
            }
        else
            {
                if($stmt = $mysqli->prepare('SELECT firstname,lastname,country FROM batsmen WHERE id=?'))
                    {
                        $id = $_GET['id'];                       
                        $stmt->bind_param('i',$id);
                        $stmt->execute();
                        $stmt->bind_result($firstname,$lastname,$country);
                        $stmt->fetch();
                        $stmt->close();
                        renderForm($firstname,$lastname,$country,$id,null);
                    }
            }
    }

    if(!isset($_GET['id']))

        {
            if(isset($_POST['submit']))
            {
                $firstname = htmlentities($_POST['firstname'],ENT_QUOTES);
                $lastname = htmlentities($_POST['lastname'],ENT_QUOTES);
                $country = htmlentities($_POST['country'],ENT_QUOTES);

                if($firstname==''||$lastname==''||$country=='')
                    {
                        $error = 'Fill all fields before submitting';
                        renderForm(null,null,null,null,$error);
                    }

                else
                    {
                        if($stmt = $mysqli->prepare('INSERT batsmen (firstname,lastname,country) VALUES (?,?,?)'))
                        {
                            $stmt->bind_param('sss',$firstname,$lastname,$country);
                            $stmt->execute();
                            $stmt->close();
                        }
                        else
                        {
                            $error = 'SQL statement could not be prepared!';
                            renderForm(null,null,null,null,$error);
                        }

                        header ('Location:view.php');
                    }
            }

            else
            {
                renderForm();
            }
        }



?>