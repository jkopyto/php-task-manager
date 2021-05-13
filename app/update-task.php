<?php
include('config/constants.php');

//Sprawdzenie czy ID zadania znajduje się w linku

if (isset($_GET['task_id'])) {
    //Przypisanie ID zadania do zmiennej
    $task_id = $_GET['task_id'];

    //Połączenie z bazą
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

    //Wybranie bazy
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

    //Zapytanie pozwalające wyświetlić task o podanym ID
    $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";

    //Wykonanie zapytania
    $res = mysqli_query($conn, $sql);

    //Sprawdzenie czy jest odpowiedź
    if ($res == true) {
        //Pobranie wartości
        $row = mysqli_fetch_assoc($res);

        //Przypisanie właściwości do zmiennych
        $task_name = $row['task_name'];
        $task_description = $row['task_description'];
        $list_id = $row['list_id'];
        $priority = $row['priority'];
        $deadline = $row['deadline'];
    }
} else {
    //Przekierowanie do strony głównej
    header('location:' . SITEURL);
}

//Sprawdzenie czy kliknięto submit
if (isset($_POST['submit'])) {

    //Przypisanie wartości z formularza do zmiennych
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    //Połączenie z bazą
    $conn3 = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn3));

    //Wybranie bazy
    $db_select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error($conn3));

    //Zapytanie pozwalające zaktualizować zadanie
    $sql3 = "UPDATE tbl_tasks SET 
        task_name = '$task_name',
        task_description = '$task_description',
        list_id = '$list_id',
        priority = '$priority',
        deadline = '$deadline'
        WHERE 
        task_id = $task_id
        ";

    //Wykonanie zapytania
    $res3 = mysqli_query($conn3, $sql3);

    //Sprawdzenie czy się udało
    if ($res3 == true) {
        //Wyświetlenie wiadomości o pomyślnej aktualizacji zadania
        $_SESSION['update'] = "Zaktualizowano zadanie";

        //Przekierowanie do strony głównej
        header('location:' . SITEURL);
    } else {
        //Nie udało się zaktualizować zadania
        $_SESSION['update_fail'] = "Coś poszło nie tak";

        //Przekierowanie na tę samą stronę (odświeżenie)
        header('location:' . SITEURL . 'update-task.php?task_id=' . $task_id);
    }
}

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
        <p>
            <button class="btn btn-secondary" id="btn-main-page">Strona główna</button>
        </p>
        <h3>Zaktualizuj zadanie</h3>
        <p>
            <?php
            //Sprawdzenie czy odbyło sie niepowodzenie aktualizacji
            if (isset($_SESSION['update_fail'])) {
                //Wyświetlenie informacji o niepowodzeniu
                $msg = $_SESSION['update_fail'];
                echo "<script>displayToast('$msg', 'error')</script>";
                //Usunięcie wiadomości
                unset($_SESSION['update_fail']);
            }
            ?>
        </p>
        <form method="POST" action="">
            <table >
                <tr>
                    <td><label for="task_name">Nazwa: </label></td>
                    <td><input class="txt-input" type="text" id="task_name" name="task_name" value="<?php echo $task_name; ?>" required /></td>
                </tr>
                <tr>
                    <td><label for="task_description">Opis: </label></td>
                    <td>
                        <textarea class="txt-input textarea-disable-resize margin-top-15" id="task_description" name="task_description" placeholder=""><?php echo $task_description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td><label for="list_id">Wybierz listę: </label></td>
                    <td>
                        <select class="custom-select margin-top-15" name="list_id" required>

                            <?php
                            //Połączenie z bazą
                            $conn2 = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));

                            //Wybranie bazy
                            $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error($conn2));

                            //Zapytanie pozwalające pobrać wiersze z tabeli tbl_lists
                            $sql2 = "SELECT * FROM tbl_lists";

                            //Wykonanie zapytania
                            $res2 = mysqli_query($conn2, $sql2);

                            //Sprawdzenie czy otrzymano odpowiedź
                            if ($res2 == true) {
                                //Przypisanie liczby wierszy do zmiennej
                                $count_rows2 = mysqli_num_rows($res2);

                                //Sprawdzenie czy liczba wierszy jest większa od zera
                                if ($count_rows2 > 0) {
                                    while ($row2 = mysqli_fetch_assoc($res2)) {
                                        //Przypisanie właściwości do zmiennych
                                        $list_id_db = $row2['list_id'];
                                        $list_name = $row2['list_name'];
                            ?>

                                        <option <?php if ($list_id_db == $list_id) {
                                                    echo "selected='selected'";
                                                } ?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>

                                    <?php
                                    }
                                } else {
                                    //Brak
                                    ?>
                                    <option <?php if ($list_id = 0) {
                                                echo "selected='selected'";
                                            } ?> value="0" disabled>Brak</option>p
                            <?php
                                }
                            }
                            ?>


                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="priority">Priorytet:</label></td>
                    <td class="radio-group">
                        <div>
                            <input type="radio" id="priority" name="priority" value="Wysoki">Wysoki</input>
                        </div>
                        <div>
                            <input type="radio" id="priority" name="priority" value="Średni">Średni</input>
                        </div>
                        <div>
                            <input type="radio" id="priority" name="priority" value="Niski" checked>Niski</input>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><label for="deadline">Do kiedy:</label></td>
                    <td><input class="txt-input" type="date" id="deadline" name="deadline" value="<?php echo $deadline; ?>" /></td>
                </tr>

                <tr>
                    <td></td>
                    <td class = "td-flexible margin-top-15">
                        <button class="btn btn-expand btn-primary" type="submit" name="submit">Zapisz</button>
                        <button class="btn btn-expand btn-danger" type="reset" name="reset">Wyczyść</button>
                    </td>
                </tr>

            </table>

        </form>
    </div>
</body>
<script>
    const btnMainPage = document.getElementById("btn-main-page")
    btnMainPage.addEventListener("click", function() {
        window.location.href = "<?php echo SITEURL; ?>"
    })

</script>
</html>
