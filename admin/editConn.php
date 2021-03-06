<?php
    /**
    The MIT License (MIT)
    Copyright (c) 2017 Stacey Demecilio, Shimbey Assie, Axumawit Gebregorgis
    
    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
    */
    
    require ('../../../databaseConnect.php');
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $errors = array();
        // assume every element in form is valid
        $valid = true;
        
        // validation of form
        if (empty($_POST['date_recieve']))
        {
            $errors['date_recieve'] = "Date of recieved cannot be empty";
            //$valid = false;
        }
        else
        {
            $date_recieve = $_POST['date_recieve'];
        }
        
        if (empty($_POST['receipt_number']))
        {
            $errors['receipt_number'] = "Receipt number cannot be empty";
            //$valid = false;
        }
        else
        {
            $receipt_number = $_POST['receipt_number'];
        }
        
        if (empty($POST_['receiving_tech']))
        {
            $errors['receiving_tech'] = "Receiving technician's name cannot be empty";
            //$valid = false;
        }
        else
        {
            $reciving_tech = $_POST['receiving_tech'];
            if(!preg_match("/^[a-zA-Z]*$/", $reciving_tech))
            {
                $errors['receiving_tech'] = "Only letters and white space allowed.";
                //$valid = false;
            }
        }
        
        if (empty($_POST['manufacturer']))
        {
            $errors['manugacturer'] = "Manufacturer cannot be empty";
            //$valid = false;
        }
        else
        {
            $manufacturer = $_POST['manufacturer'];
        }
        
        if (empty($_POST['op_system']))
        {
            $errors['op_system'] = "Operating System cannot be empty.";
            //$valid = false;
        }
        else
        {
            $op_system = $_POST['op_system'];
        }
        
        if (empty($_POST['pc_sn']))
        {
            $errors['pc_sn'] = "PC-SN cannot be empty.";
            //$valid = false;
        }
        else
        {
            $pc_sn = $_POST['pc_sn'];
        }
        
        if (empty($_POST['model']))
        {
            $errors['model'] = "Model cannot be empty.";
            //$valid = false;
        }
        else
        {
            $model = $_POST['model'];
        }
        
        if (empty($_POST['os_key']))
        {
            $errors['os_key'] = "OS Key cannot be empty.";
            //$valid = false;
        }
        else
        {
           $os_key = $_POST['os_key'];
        }
        
        if (empty($POST['ledger']))
        {
            $errors['ledger'] = "Ledger needs to be dropped off before submitting.";
            //$valid = false;
        }
        else
        {
            $ledger_dropoff = $_POST['ledger'];
            if (strcasecmp($ledger_dropoff, "yes") || strcasecmp($ledger_dropoff, "no"))
            {
                $errors['ledger'] = "Answer must be 'Yes' or 'No'.";
                $valid = false;
            }
        }
        
    
    
    if ($valid)
    {
        try
        {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // grab variables
            $date_recieve = $_POST['date_recieve'];
            $receipt_number = $_POST['receipt_number'];
            $reciving_tech = $_POST['receiving_tech'];
            $manufacturer = $_POST['manufacturer'];
            $op_system = $_POST['op_system'];
            $pc_sn = $_POST['pc_sn'];
            $model = $_POST['model'];
            $os_key = $_POST['os_key'];
            $ledger_dropoff = $_POST['ledger'];
            $ledger_pickup = $_POST['ledger_pickup'];
            $work_began = $_POST['work_began'];
            $work_finished = $_POST['work_finished'];
            
            $workOrderID = $_GET['workOrderID'];
            
            // sql statement
            $statement = $conn->prepare("INSERT INTO office_use (workOrderID, date_recieved, receipt_number, receiving_tech, manufacturer, operating_system, pc_sn, model, os_key, ledger_dropoff, ledger_pickup, work_began, work_finished) VALUES (:workOrderID, :date_recieved, :receipt_number, :receiving_tech, :manufacturer, :operating_system, :pc_sn, :model, :os_key, :ledger_dropoff, :ledger_pickup, :work_began, :work_finished)");
            
            // bind values
            $statement->bindParam(':workOrderID', $workOrderID);
            $statement->bindParam(':date_recieved', $date_recieve);
            $statement->bindParam(':receipt_number', $receipt_number);
            $statement->bindParam(':receiving_tech', $reciving_tech);
            $statement->bindParam(':manufacturer', $manufacturer);
            $statement->bindParam(':operating_system', $op_system);
            $statement->bindParam(':pc_sn', $pc_sn);
            $statement->bindParam(':model', $model);
            $statement->bindParam(':os_key', $os_key);
            $statement->bindParam(':ledger_dropoff', $ledger_dropoff);
            $statement->bindParam(':ledger_pickup', $ledger_pickup);
            $statement->bindParam(':work_began', $work_began);
            $statement->bindParam(':work_finished', $work_finished);
            
            // execute
            $statement->execute();
            
            echo "Input has been successful!";
        }
        
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }
    }

?>