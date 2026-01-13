<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? "NO TITLE" ?> - Sports Warehouse</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/utilities.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="header grid-row">
    <?php include "_header.html.php"; ?>
    </header>
    <main class="main-content wrapper">

      <?= $content ?? 'NO CONTENT - $content not defined' ?>

    </main>
    <footer class="footer grid-row">
    <?php include "_footer.html.php"; ?>
    </footer>

     <!-- 1. Include the jQuery library -->
  <script 
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

  <!-- 2. Include jQuery plugin resources -->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  

  <!-- 3. Include your own custom JS code (that uses the jQuery plugin) -->
  <?= $footerScripts ?? '' ?> 

  <script src="JS/script.js"></script>
  <script src="JS/password-toggle.js"></script>
      

</body>
</html>