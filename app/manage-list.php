<?php
//Pobranie stałych z pliku constants.php
include('config/constants.php');
?>

<html>
<head>
    <title>Twój osobisty menadżer zadań</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" type="image/svg+xml" href="media/favicon.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/toast.css" />
    <script src="https://unpkg.co/gsap@3/dist/gsap.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/toast.js"></script>
</head>
<body>
    <div class = "toasts-container"></div>
    <div class="wrapper">
        <h1>Menadżer zadań</h1>
        <button class="btn btn-secondary" id="btn-main-page">Strona główna</button>
        <h3>Zarządzanie listami</h3>
        <p>
            <?php

            //Sprawdzenie czy odbyła się akcja dodania listy
            if (isset($_SESSION['add'])) {
                //Wyświetlenie wiadmości
                $msg = $_SESSION['add'];
                echo "<script>displayToast('$msg')</script>";
                //Usunięcie wiadmości po jej wyświetleniu
                unset($_SESSION['add']);
            }

            //Sprawdzenie czy odbyła się akcja usuwania listy
            if (isset($_SESSION['delete'])) {
                //Wyświetlenie wiadmości
                $msg = $_SESSION['delete'];
                echo "<script>displayToast('$msg')</script>";
                //Usunięcie wiadmości po jej wyświetleniu
                unset($_SESSION['delete']);
            }

            //Sprawdzenie czy odbyła się akcja aktualizacji listy
            if (isset($_SESSION['update'])) {
                //Wyświetlenie wiadmości
                $msg = $_SESSION['update'];
                echo "<script>displayToast('$msg')</script>";
                //Usunięcie wiadmości po jej wyświetleniu
                unset($_SESSION['update']);
            }

            //Sprawdzenie czy usuwanie się niepowiodło
            if (isset($_SESSION['delete_fail'])) {
                //Wyświetlenie wiadmości
                $msg = $_SESSION['delete_fail'];
                echo "<script>displayToast('$msg', 'error')</script>";
                //Usunięcie wiadmości po jej wyświetleniu
                unset($_SESSION['delete_fail']);
            }

            ?>
        </p>
        <div class="all-lists">
            <button class="btn btn-primary" id="btn-add-list">Dodaj listę</button>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Numer</th>
                        <th>Nazwa listy</th>
                        <th>Opis</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                //Połączenie z bazą
                $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

                //Wybranie bazy
                $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

                //Zapytanie wyświetlające wszystkie listy
                $sql = "SELECT * FROM tbl_lists";

                //Wykonanie zapytania
                $res = mysqli_query($conn, $sql);

                //Sprawdzenie czy otrzymano odpowiedź
                if ($res == true) {
                    //Zapisanie liczby wierszy do zmiennej
                    $count_rows = mysqli_num_rows($res);

                    //Utworzenie zmiennej pomocniczej
                    $sn = 1;

                    //Sprawdzenie czy liczba wierszy jest większa od zera
                    if ($count_rows > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $list_id = $row['list_id'];
                            $list_description = $row['list_description'];
                            $list_name = $row['list_name'];
                ?>
                            <tr>
                                <td><?php echo $sn++; ?>. </td>
                                <td><?php echo $list_name; ?></td>
                                <td><?php echo $list_description; ?></td>
                                <td>
                                    <a class="btn btn-primary" href="update-list.php?list_id=<?php echo $list_id; ?>">Zaktualizuj</a>
                                    <a class="btn btn-danger" href="delete-list.php?list_id=<?php echo $list_id; ?>">Usuń</a>
                                </td>
                            </tr>

                        <?php

                        }
                    } else {
                        ?>

                        <tr>
                            <td colspan="3">Brak list</td>
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
    const btnMainPage = document.getElementById("btn-main-page")
    btnMainPage.addEventListener("click", function() {
        window.location.href = "<?php echo SITEURL; ?>"
    })

    const btnAddList = document.getElementById("btn-add-list")
    btnAddList.addEventListener("click", function(){
        window.location.href = "<?php echo SITEURL; ?>add-list.php"
    })
</script>

</html>