<?php
include('config/constants.php');

//Wykonaj jeśli formularz został wysłany
if (isset($_POST['submit'])) {
    //Pobranie wartości z formularza
    $list_name = $_POST['list_name'];
    $list_description = $_POST['list_description'];

    //Połączenie z bazą danych
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

    //Wybranie bazy danych
    $db_select = mysqli_select_db($conn, DB_NAME);

    //Zapytanie pozwalające zapisać dane w bazie
    $sql = "INSERT INTO tbl_lists SET 
            list_name = '$list_name',
            list_description = '$list_description'
        ";

    //Wykonanie zapytania
    $res = mysqli_query($conn, $sql);

    //Sprawdzenie czy otrzymano odpowiedź
    if ($res == true) {
        //Wyświetlenie wiadomości sesji o pomyślnym dodaniu listy do bazy
        $_SESSION['add'] = "Lista dodana pomyślnie";

        //Przekieruj do zarządzania listami
        header('location:' . SITEURL . 'manage-list.php');
    } else {
        //Gdy dodanie listy się nie powiedzie

        //Wyświetlenie wiadmości o niepowodzeniu
        $_SESSION['add_fail'] = "Coś poszło nie tak";

        //Przekierowanie do tej samej strony (odświeżenie)
        header('location:' . SITEURL . 'add-list.php');
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
    <div class = "toasts-container"></div>
    <div class="wrapper">
        <h1>Menadżer zadań</h1>

        <div class="nav-wrapper">
            <button class="btn btn-secondary" id = "btn-main-page">Strona główna</button>
            <button class="btn btn-secondary" id = "btn-list-management">Zarządzaj listami</button>
        </div>
        <h3>Tworzenie nowej listy</h3>

        <p>
            <?php

            //Sprawdzenie czy sesja jest aktywna
            if (isset($_SESSION['add_fail'])) {
                //Wyświetlenie wiadomości
                $msg = $_SESSION['add_fail'];
                echo "<script>displayToast('$msg', 'error')</script>";
                //Usuń wiadomość, żeby ponownie jej nie wyświetlić
                unset($_SESSION['add_fail']);
            }

            ?>
        </p>

        <form method="POST" action="">
            <table>
                <tr>
                    <td><label for="list_name">Nazwa:</label></td>
                    <td><input class="txt-input" type="text" name="list_name" placeholder="Wprowadź nazwę listy" required="required" /></td>
                </tr>
                <tr>
                    <td class="margin-top-15"><label for="list_description">Opis:</label></td>
                    <td><textarea class = "txt-input textarea-disable-resize margin-top-15" name="list_description" placeholder="Wprowadź opis listy"></textarea></td>
                </tr>

                <tr >
                    <td></td>
                    <td class = "td-flexible margin-top-15">
                        <button class="btn btn-expand btn-danger" type="reset" name="reset">Wyczyść</button>
                        <button class="btn btn-expand btn-primary" type="submit" name="submit">Zapisz</button>
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

    const btnListManagement = document.getElementById("btn-list-management")
    btnListManagement.addEventListener("click", function() {
        window.location.href = "<?php echo SITEURL; ?>manage-list.php"
    })

</script>
</html>
