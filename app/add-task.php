<?php
include('config/constants.php');

//Sprawdzenie czy formularz został wysłany
if (isset($_POST['submit'])) {
    //Pobranie właściwości z formularza
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    //Połączenie do bazy danych
    $conn2 = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));

    //Wybranie bazy danych
    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error($conn2));

    //Zapytanie pozwalające na dodanie nowego wiersza w bazie z nowym zadaniem
    $sql2 = "INSERT INTO tbl_tasks SET 
            task_name = '$task_name',
            task_description = '$task_description',
            list_id = $list_id,
            priority = '$priority',
            deadline = '$deadline'
        ";

    //Wykonanie zapytania
    $res2 = mysqli_query($conn2, $sql2);

    //Sprawdzenie czy otrzymano odpowiedź
    if ($res2 == true) {
        //Dodanie wiadmości przy poprawnym dodaniu zadania do bazy
        $_SESSION['add'] = "Zadanie dodano pomyślnie";

        //Przekierowanie do strony głównej
        header('location:' . SITEURL);
    } else {
        //Wiadomość w przypadku niepowodzenia
        $_SESSION['add_fail'] = "Coś poszło nie tak";

        //Przekierowanie na tę samą stronę(odświeżenie)
        header('location:' . SITEURL . 'add-task.php');
    }
}
?>

<html>

<head>
    <title>Twój osobisty menadżer zadań</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css" />
    <link rel="icon" type="image/svg+xml" href="<?php echo SITEURL; ?>media/favicon.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/toast.css" />
    <script src="https://unpkg.co/gsap@3/dist/gsap.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/toast.js"></script>
</head>

<body>
    <div class="toasts-container"></div>
    <div class="wrapper">
        <h1>Menadżer zadań</h1>
        <button class="btn btn-secondary" id="btn-main-page">Strona główna</button>
        <h3>Tworzenie nowego zadania</h3>
        <p>
            <?php

            if (isset($_SESSION['add_fail'])) {
                $msg = $_SESSION['add_fail'];
                echo "<script>displayToast('$msg', 'error')</script>";
                unset($_SESSION['add_fail']);
            }

            ?>
        </p>
        <form method="POST" action="" autocomplete="off">
            <table>
                <tr>
                    <td>
                        <label for="task_name">Nazwa:</label>
                    </td>
                    <td>
                        <input type="text" id="task_name" name="task_name" class="txt-input margin-top-15" placeholder="Wprowadź nazwę zadania" required="required" /></td>
                </tr>
                <tr>
                    <td><label for="task_description">Opis:</label></td>
                    <td><textarea name="task_description" class="txt-input margin-top-15 textarea-disable-resize" id="task_description" placeholder="Wprowadź opis zadania"></textarea></td>
                </tr>
                <tr>
                    <td><label for="select_list">Wybierz liste: </label> </td>
                    <td>
                        <select id="select_list" name="list_id" class="custom-select margin-top-15" required>

                            <?php

                            //Połączenie z bazą
                            $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

                            //Wybranie bazy
                            $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

                            //Zapytanie pobierające zapytania z bazy
                            $sql = "SELECT * FROM tbl_lists";

                            //Wykonanie zapytania
                            $res = mysqli_query($conn, $sql);

                            //Sprawdzenie czy otrzymano odpowiedź
                            if ($res == true) {
                                //Zmienna zawierająca liczbę wierszy
                                $count_rows = mysqli_num_rows($res);

                                //Wyświetlenie wierszy z tabeli jako opcji w select. Jeśli brak - wyświetlone zostanie: Brak
                                if ($count_rows > 0) {
                                    echo '<option value="" disabled selected>Wybierz listę</option>';
                                    //Dodanie kolejnych opcji
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $list_id = $row['list_id'];
                                        $list_name = $row['list_name'];
                                        echo "<option value='$list_id'>$list_name</option>";
                                    }
                                } else {
                                    //Wyświetlanie Brak jako opcji
                                    echo '<option value="0" disabled>Brak</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="priority">Priorytet: </label></td>
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
                    <td><label for="deadline">Do kiedy: </label></td>
                    <td><input id="deadline" type="date" class="txt-input margin-top-15" name="deadline" required /></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="td-flexible margin-top-15">
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
