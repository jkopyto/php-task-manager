<?php
include('config/constants.php');

//Połączenie do mysql
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

//Wybranie bazy danych
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

//Zapytanie wybierające wszystkie rekordy z tabeli "tbl_tasks"
$sql = "SELECT * FROM tbl_tasks";

//Wykonanie zapytania
$res = mysqli_query($conn, $sql);

if ($res == true) {
    $tasks = array();
    if(mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $tasks[] = $row;
        }
    }
    //Ustawienie nagłówków
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Zadania.csv');
    $output = fopen('php://output', 'w');

    //Dodanie wiersza do pliku CSV
    fputcsv($output, array('task_id', 'task_name', 'task_description', 'list_id', 'priority', 'deadline'));

    if(count($tasks) > 0) {
        foreach ($tasks as $row) {
            fputcsv($output, array($row['task_id'], $row['task_name'], $row['task_description'], $row['list_id'], $row['priority'], $row['deadline']));
        }
    }
}
?>