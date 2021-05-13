<?php
//Pobranie stałych z pliku constants.php
include('config/constants.php');

//Pobranie ID listy z linku
$list_id_url = $_GET['list_id'];
?>
<html>

<head>
    <title>Twój osobisty menadżer zadań</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" type="image/svg+xml" href="media/favicon.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <h1>Menadżer zadań</h1>
        <div class="subheader-tabs">
            <a class="subheader-item" href=<?php echo SITEURL; ?>>Wszystkie zadania</a>

            <?php
            //Połączenie z bazą danych
            $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

            //Wybranie bazy danych
            $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

            //Zapytanie pobierające wszystkie wiersze z tabeli tbl_lists
            $sql = "SELECT * FROM tbl_lists";

            //Wykonanie zapytania
            $res = mysqli_query($conn, $sql);

            //Sprawdzenie czy otrzymano odpowiedź
            if ($res == true) {
                //Wyświetlenie list w menu
                while ($row = mysqli_fetch_assoc($res)) {
                    $list_id = $row['list_id'];
                    $list_name = $row['list_name'];
            ?>

                    <a class="subheader-item <?php echo isset($_GET['list_id']) && $_GET['list_id'] == $list_id ? "subheader-item--active" : "" ?>" href="list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

            <?php

                }
            }

            ?>
            <button class="btn btn-secondary" id="btn-list-management">Zarządzaj listami</button>
        </div>

        <div class="all-tasks">
            <button class="btn btn-primary" id="btn-add-task">Dodaj zadanie</button>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Numer</th>
                        <th>Nazwa</th>
                        <th>Priorytet</th>
                        <th>Do kiedy</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    //Połączenie do mysql
                    $conn2 = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));

                    //Wybranie bazy danych
                    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die($conn2);

                    //Zapytanie wybierające jeden rekord z tabeli o podanym ID
                    $sql2 = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";

                    //Wykonanie zapytania
                    $res2 = mysqli_query($conn2, $sql2);

                    //Sprawdzenie czy otrzymano odpowiedź
                    if ($res2 == true) {
                        //Sprawdzenie liczby wierszy
                        $count_rows = mysqli_num_rows($res2);

                        //Inicjalizacja numeru zadania
                        $sn = 1;

                        //Sprawdzenie czy w bazie znajdują się zadania
                        if ($count_rows > 0) {
                            //Wyświetlanie danych z bazy
                            while ($row2 = mysqli_fetch_assoc($res2)) {
                                $task_id = $row2['task_id'];
                                $task_name = $row2['task_name'];
                                $task_description = $row2['task_description'];
                                $priority = $row2['priority'];
                                $deadline = $row2['deadline'];
                    ?>

                                <tr>
                                    <td><?php echo $sn++; ?>. </td>
                                    <td><?php echo $task_name; ?></td>
                                    <td><?php echo $task_description; ?></td>
                                    <td><?php echo $priority; ?></td>
                                    <td><?php echo $deadline; ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="update-task.php?task_id=<?php echo $task_id; ?>">Zaktualizuj</a>
                                        <a class="btn btn-danger" href="delete-task.php?task_id=<?php echo $task_id; ?>&list_id=<?php echo $list_id_url;?>">Usuń</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            //Brak danych w bazie
                            ?>

                            <tr>
                                <td colspan="5">Brak dodanych zadań.</td>
                            </tr>

                    <?php
                        }
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    const btnListManagement = document.getElementById("btn-list-management")
    btnListManagement.addEventListener("click", function() {
        window.location.href="manage-list.php"
    })

    const btnAddTask = document.getElementById("btn-add-task")
    btnAddTask.addEventListener("click", function(){
        document.location.href="add-task.php"
    })
</script>
</html>