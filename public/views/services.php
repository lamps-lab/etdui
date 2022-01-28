<?php
include '../../src/auth/redirect.php';
include '../../src/auth/is_verified.php';
include 'header.php';
include '../../constants.php';
?>


<body>

<?php
include 'menu.php';
?>

<button style = "margin: 50px;" class="download" data-toggle="modal" data-target="#upload-pdf-modal" >Figure Extraction</button>

<?php include 'upload_pdf_view.php' ?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>