<?php
include('config/constants.php');
?>

<html>
<head>
    <!-- Tag definiujący rodzaj kodowania znaków -->
    <meta charset="utf-8" />
    <!-- Viewport pozwala ustawić widoczną przestrzeń. Parametr width ustawiany jest na podstawie szerokości okna urządzenia, zaś initial-scale - wstępne przybliżenie -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Opis strony -->
    <meta name="description" content="Prosty i przejrzysty menadżer zadań pozwoli Ci w łatwy sposób zorganizować Twoje najbliższe dni. Dzięki niemu o niczym nie zapomnisz" />
    <!-- Słowa kluczowe -->
    <meta name="keywords" content="manager, zadań, zadania, task, taski, organizacja, dzień" />
    <!-- Autor -->
    <meta name="author" content="Jakub Kopyto" />
    <!-- Prawa autorskie -->
    <meta name="copyright" content="Jakub Kopyto" />

    <!-- OpenGraph meta tagi pozwalają dopasować to jak strona jest widoczna, kiedy zostanie udostępniona jako odnośnik (np. na facebooku) -->
    <meta property="og:description" content="Prosty i przejrzysty menadżer zadań pozwoli Ci w łatwy sposób zorganizować Twoje najbliższe dni. Dzięki niemu o niczym nie zapomnisz" />
    <meta property="og:url" content="https://pai.jkopyto.pl/" />
    <meta property="og:title" content="Prosty i przejrzysty menadżer zadań pozwoli Ci w łatwy sposób zorganizować Twoje najbliższe dni. Dzięki niemu o niczym nie zapomnisz" />

    <!-- Tytuł widoczny na pasku przeglądarki -->
    <title>Twój osobisty menadżer zadań</title>

    <!-- Lokalny arkusz styli -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- Ikona widoczna na pasku przeglądarki -->
    <link rel="icon" type="image/svg+xml" href="media/favicon.svg">

    <!-- Pobranie i załadowanie fontu -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Arkusz styli odpowiadający za style toastu -->
    <link rel="stylesheet" href="css/toast.css" />
    <script src="https://unpkg.co/gsap@3/dist/gsap.min.js"></script>

    <!-- Skrypt pozwalający na wyświetlenie toastu -->
    <script src="<?php echo SITEURL; ?>js/toast.js"></script>
</head>
<body>
    <div class = "toasts-container"></div>
    <div class="wrapper">
        <h1>Menadżer zadań</h1>
        <div class="subheader-tabs">
            <a class="subheader-item <?php echo isset($_GET['list_id']) ? "" : "subheader-item--active" ?>" href="">Wszystkie zadania</a>

            <?php

            //Połączenie do bazy
            $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

            //Wybranie bazy
            $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

            //Zapytanie wybierające wszystkie rekordy zawarte w tabeli "tbl_lists"
            $sql = "SELECT * FROM tbl_lists";

            //Wykonanie zapytania
            $res = mysqli_query($conn, $sql);

            //Sprawdzenie czy otrzymano odpowiedź
            if ($res == true) {
                //Wyświetlenie grup zadań
                while ($row2 = mysqli_fetch_assoc($res)) {
                    $list_id = $row2['list_id'];
                    $list_name = $row2['list_name'];
            ?>

                    <a class="subheader-item <?php echo isset($_GET['list_id']) && $_GET['list_id'] == $list_id ? "subheader-item--active" : "" ?>" href="list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

            <?php

                }
            }

            ?>
            <button class="btn btn-secondary" id="btn-task-management">Zarządzaj listami</button>
        </div>

        <p>
            <?php
            if (isset($_SESSION['add'])) {
                $msg = $_SESSION['add'];
                echo "<script>displayToast('$msg')</script>";
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['delete'])) {
                $msg = $_SESSION['delete'];
                echo "<script>displayToast('$msg')</script>";
                unset($_SESSION['delete']);
            }

            if (isset($_SESSION['update'])) {
                $msg = $_SESSION['update'];
                echo "<script>displayToast('$msg')</script>";
                unset($_SESSION['update']);
            }


            if (isset($_SESSION['delete_fail'])) {
                $msg = $_SESSION['delete_fail'];
                echo "<script>displayToast('$msg', 'error')</script>";
                unset($_SESSION['delete_fail']);
            }

            ?>
        </p>
        <div class="all-tasks">
            <button id="btn-add-task" class="btn btn-primary">Dodaj zadanie</button>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Numer</th>
                        <th>Nazwa</th>
                        <th>Opis</th>
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
                    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error($conn2));

                    //Zapytanie wybierające wszystkie rekordy z tabeli "tbl_tasks"
                    $sql2 = "SELECT * FROM tbl_tasks";

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
                            while ($row = mysqli_fetch_assoc($res2)) {
                                $task_id = $row['task_id'];
                                $task_name = $row['task_name'];
                                $task_desc = $row['task_description'];
                                $priority = $row['priority'];
                                $deadline = $row['deadline'];
                    ?>

                                <tr>
                                    <td><?php echo $sn++; ?>. </td>
                                    <td><?php echo $task_name; ?></td>
                                    <td><?php echo $task_desc; ?></td>
                                    <td><?php echo $priority; ?></td>
                                    <td><?php echo $deadline; ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="update-task.php?task_id=<?php echo $task_id; ?>">Zaktualizuj </a>

                                        <a class="btn btn-danger" href="delete-task.php?task_id=<?php echo $task_id; ?>">Usuń</a>

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
            <div class="main-page-buttons-wrapper">
                <button class="btn btn-secondary" onclick="exportToCsv()">Eksportuj zadania do CSV</button>
                <button class="btn btn-secondary" onclick="toLearnMore()">Dowiedz się więcej</button>
            </div>
        </div>
    </div>
</body>
<script>
    const btnTaskManagement = document.getElementById("btn-task-management")
    btnTaskManagement.addEventListener("click", function() {
        window.location.href="manage-list.php"
    })

    const btnAddTask = document.getElementById("btn-add-task")
    btnAddTask.addEventListener("click", function(){
        document.location.href = "add-task.php"
    })

    function exportToCsv() {
        const conf = confirm("Wyeksportować pliki do CSV?")
        if(conf === true) {
            window.open("export-to-csv.php", '_blank')
        }
    }

    function toLearnMore() {
        window.location.href = "learn-more.php"
    }
</script>
</html>