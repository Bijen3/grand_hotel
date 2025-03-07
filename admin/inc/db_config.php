<?php

    $hname = 'localhost';
    $uname = 'root';
    $pass = '';
    $db = 'grandhotel';

    $con = mysqli_connect($hname, $uname, $pass, $db);

    if(!$con){
        die("Cannot connect to database".mysqli_connect_error());
    }

    function filteration($data){
        foreach($data as $key => $value){            
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $data[$key] = $value;
        }
        return $data;
    }

    function selectAll($table){
        $con = $GLOBALS['con'];
        $res = mysqli_query($con, "SELECT * FROM $table");
        return $res;
    }

    function select($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con']; //cant be direclty in function used without global
        if($stmt = mysqli_prepare($con, $sql)){ //passed 2 or prepare to store in stmt
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind in stmt to datatypes and values(... -> dynamically bind)
            if(mysqli_stmt_execute($stmt)){ //to execute stmt
                $res = mysqli_stmt_get_result($stmt); //get result in res of stmt
                mysqli_stmt_close($stmt); //close after getting stmt
                return $res; //return the calling function ie. res
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Select");
            }
            
        }
        else{
            die("Query cannot be prepared - Select");
        }
    }

    function update($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con']; //cant be direclty in function used without global
        if($stmt = mysqli_prepare($con, $sql)){ //passed 2 or prepare to store in stmt
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind in stmt to datatypes and values(... -> dynamically bind)
            if(mysqli_stmt_execute($stmt)){ //to execute stmt
                $res = mysqli_stmt_affected_rows($stmt); //get result in res of stmt
                mysqli_stmt_close($stmt); //close after getting stmt
                return $res; //return the calling function ie. res
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Update");
            }
            
        }
        else{
            die("Query cannot be prepared - Update");
        }
    }

    function insert($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con']; //cant be direclty in function used without global
        if($stmt = mysqli_prepare($con, $sql)){ //passed 2 or prepare to store in stmt
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind in stmt to datatypes and values(... -> dynamically bind)
            if(mysqli_stmt_execute($stmt)){ //to execute stmt
                $res = mysqli_stmt_affected_rows($stmt); //get result in res of stmt
                mysqli_stmt_close($stmt); //close after getting stmt
                return $res; //return the calling function ie. res
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Insert");
            }
            
        }
        else{
            die("Query cannot be prepared - Insert");
        }
    }

    function delete_item($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con']; //cant be direclty in function used without global
        if($stmt = mysqli_prepare($con, $sql)){ //passed 2 or prepare to store in stmt
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind in stmt to datatypes and values(... -> dynamically bind)
            if(mysqli_stmt_execute($stmt)){ //to execute stmt
                $res = mysqli_stmt_affected_rows($stmt); //get result in res of stmt
                mysqli_stmt_close($stmt); //close after getting stmt
                return $res; //return the calling function ie. res
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Delete");
            }            
        }
        else{
            die("Query cannot be prepared - Delete");
        }
    }
?>