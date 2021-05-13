<?php 
    //Pobranie stałych z pliku constants.php
    include('config/constants.php');
    
    //Sprawdznie czy ustawiona jest właściwość (w adresie url) list_id na podstawie której usuniety zostanie odpowiedni wiersz w tabeli
    if(isset($_GET['list_id']))
    {
        //Delete the List from database
        
        //Przypisanie ID listy do zmiennej
        $list_id = $_GET['list_id'];
        
        //Połączenie do bazy
        $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
        
        //Wybranie bazy
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
        
        //Zapytanie usuwające liste z bazy
        $sql = "DELETE FROM tbl_lists WHERE list_id=$list_id";
        
        //Wykonanie zapytania
        $res = mysqli_query($conn, $sql);
        
        //Sprawdzenie czy otrzymano odpowiedź
        if($res==true)
        {
            //Wiadomość przy pomyślnym usunięciu
            $_SESSION['delete'] = "Usunięto listę";
            
            //Przekierowanie do zarządzania listami
            header('location:'.SITEURL.'manage-list.php');
        }
        else
        {
            //Wiadomość jeśli usuwanie nie powiodło się
            $_SESSION['delete_fail'] = "Coś poszło nie tak";

            //Przekierowanie do zarządzania listami
            header('location:'.SITEURL.'manage-list.php');
        }
    }
    else
    {
        //Przekierowanie na stronę główną
        header('location:'.SITEURL.'manage-list.php');
    }
