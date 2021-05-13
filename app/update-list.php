<?php
//Pobranie stałych z pliku constants.php
include('config/constants.php');

//Pobranie ID listy z linku
if (isset($_GET['list_id'])) {
    //Przypisanie ID listy do zmiennej
    $list_id = $_GET['list_id'];

    //Połączenie z bazą
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

    //Wybranie bazy danych
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

    //Zapytanie pozwalające wybrać wiersze z tabeli na podstawie podanego ID
    $sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";

    //Wykonanie zapytania
    $res = mysqli_query($conn, $sql);

    //Sprawdzenie czy otrzymano odpowiedź
    if ($res == true) {
        //Pobranie wiersza z bazy
        $row = mysqli_fetch_assoc($res); //Tablica

        $list_name = $row['list_name'];
        $list_description = $row['list_description'];
    } else {
        //Przekierowanie do strony zarządzania listami
        header('location:' . SITEURL . 'manage-list.php');
    }
}

//Sprawdzenie czy przycisk submit został wciśnięty
if (isset($_POST['submit'])) {

    //Pobranie wartości z formularza
    $list_name = $_POST['list_name'];
    $list_description = $_POST['list_description'];

    //Połączenie z bazą
    $conn2 = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn2));

    //Wybranie bazy
    $db_select2 = mysqli_select_db($conn2, DB_NAME);

    //Zapytanie pozwalające zaktualizować listę o podanym ID
    $sql2 = "UPDATE tbl_lists SET 
            list_name = '$list_name',
            list_description = '$list_description' 
            WHERE list_id=$list_id
        ";

    //Wykoanie zapytania
    $res2 = mysqli_query($conn2, $sql2);

    //Sprawdzenie czy otrzymano odpowiedź
    if ($res2 == true) {
        //Ustawienie wiadomości o pomyślnym wykonaniu zapytania
        $_SESSION['update'] = "Lista zaktualizowana pomyślnie";

        //Przekierowanie do zarządzania listami
        header('location:' . SITEURL . 'manage-list.php');
    } else {
        //Nie uzyskano odpowiedzi - ustawienie wiadomości
        $_SESSION['update_fail'] = "Coś poszło nie tak";
        //Przekierowanie do strony z aktualizacją listy (odświeżenie)
        header('location:' . SITEURL . 'update-list.php?list_id=' . $list_id);
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
            <button class="btn btn-secondary" id="btn-manage-list">Zarządzanie listami</button>
        <h3>Zaktualizuj listę</h3>
        <p>
            <?php
            //Check whether the session is set or not
            if (isset($_SESSION['update_fail'])) {
                $msg = $_SESSION['update_fail'];
                echo "<script>displayToast('$msg', 'error')</script>";
                unset($_SESSION['update_fail']);
            }
            ?>
        </p>
        <form method="POST" action="">
            <table >
                <tr>
                    <td><label for="list_name">Nazwa: </label></td>
                    <td><input class="txt-input" type="text" id="list_name" name="list_name" value="<?php echo $list_name; ?>" required="required" /></td>
                </tr>
                <tr>
                    <td><label for="list_description">Opis: </label></td>
                    <td>
                        <textarea class="txt-input textarea-disable-resize margin-top-15" name="list_description" id="list_description"><?php echo $list_description; ?></textarea>
                    </td>
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
        window.location.href=""
    })

    const btnManageList = document.getElementById("btn-manage-list")
    btnManageList.addEventListener("click", function() {
        window.location.href="manage-list.php"
    })
</script>
</html>
