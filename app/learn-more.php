<?php
include('config/constants.php');
?>

<html>
<head>
    <title>Twój osobisty menadżer zadań</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css" />
    <link rel="icon" type="image/svg+xml" href="<?php echo SITEURL; ?>media/favicon.svg">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <script src="<?php echo SITEURL; ?>js/createList.js"></script>
</head>
<body>
    <div class="img-wrapper">
        <img src="<?php echo SITEURL?>media/img.jpg" alt="Zdjęcie z notatkami" />
    </div>
    <div class = "toasts-container"></div>
    <div class="wrapper">
        <h1>Menadżer zadań</h1>

        <div class="nav-wrapper">
            <button class="btn btn-secondary" id = "btn-main-page">Strona główna</button>
        </div>
        <h3>Co daje Ci zapisywanie zadań: </h3>
        <div class = "list-container"></div>
        <h3>Zasady tworzenia zadań: </h3>
        <div class = "ordered-list">
            <ol>
                <li>Odpowiedz sobie na pytanie czy to co chcesz zapisać to zadanie czy projekt</li>
                <li>Jeśli zadanie da się zrobić w ciągu dwóch minut - zrób je od razu</li>
                <li>Każde zadanie musi być przypisane do projektu</li>
            </ol>
        </div>
    </div>
</body>
<script>
    const btnMainPage = document.getElementById("btn-main-page")
    btnMainPage.addEventListener("click", function() {
        window.location.href = "<?php echo SITEURL; ?>"
    })
</script>
</html>