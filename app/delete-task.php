<?php 

    //Pobranie stałych z pliku constants.php
    include('config/constants.php');
    
    //Sprawdznie czy ustawiona jest właściwość (w adresie url) task_id na podstawie której usuniety zostanie odpowiedni wiersz w tabeli
    if(isset($_GET['task_id'])) {
        //Usunięcie zadania 
        //Przypisanie ID zadania do zmiennej
        $task_id = $_GET['task_id'];
        
        //Połączenie do bazy danych
        $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
        
        //Wybranie bazy danych
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
        
        //Zapytanie pozwalające na usunięcie zadania z bazy na podstawie jego ID
        $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id";
        
        //Wykonanie zapytania
        $res = mysqli_query($conn, $sql);
        
        //Sprawdzenie czy otrzymano odpowiedź
        if($res==true) {
            //Wiadomość, jeśli udało się usunąć zadanie
            $_SESSION['delete'] = "Usunięto zadanie";

            if(isset($_GET['list_id'])) {
                header('location:'.SITEURL.'list-task.php?list_id='.$_GET['list_id']);
            } else {
                //Przekierowanie na stronę główną
                header('location:'.SITEURL);
            }
        } else {
            //Wiadomość jeśli nie udało się usunąć zadania
            $_SESSION['delete_fail'] = "Coś poszło nie tak";
            
            //Przekierowanie na stronę główną
            header('location:'.SITEURL);
        }
    } else {
        //Przekierowanie na stronę główną
        header('location:'.SITEURL);
    }
