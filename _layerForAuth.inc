<?php ?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/main.css"/>
  <title><?php echo $titleForThisPage; ?></title>
  
  <script language="JavaScript" type="text/javascript" src="js/signalr.js"></script>
  <script src="validator.min.js"></script>
  <script src="socket.js"></script>
  <script>
    var serverAddress = <?php echo "'$mainServer'"; ?>;
    var serverAddressForSendClaim = <?php echo "'$serverAddressForSendClaim'"; ?>;
    var serverAddressForAnswerAfterSendClaim = <?php echo "'$serverAddressForAnswerAfterSendClaim'"; ?>;
  </script>
</head>
<body>

  <header class="navbar bg-light navbar-expand flex-column flex-md-row bd-navbar m-0 p-0">
    <div class="container">
      <span class="col-7 col-sm-8 header-container m-0">
        <a href="lochalhost/#/" class="navbar-brand float-left m-0 p-0" data-test-id="header-home">
          <label class="row logo-dsgn m-0 p-0">
        	  САД
        	  <div class="m-0 p-0">
              <label class="post-logo-dsgn p-1" >
        	      жкх
              </label>
            </div>
          </label>
        </a>
      </span>
      <ul class="navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Действия
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>

        <li class="nav-item"><a href="lochalhost/#/" class="nav-link">Выход</a></li>
      </ul>
    </div>
    </nav>
  </header>

<?php echo $bodyForThisPage; ?>

  <!-- FOOTER.begin -->

  <footer class="bd-footer footer-dsgn text-muted bg-light my-100">
    <div class="bg-light container-fluid p-3 p-md-3">
      <p>Разработано в рамках проведених хакатона "Цифровой прорыв" командой <strong>void*</strong>
      <p>Казань, 27-29 сентября 2019 года</p>
    </div>
  </footer>
  <!-- FOOTER.end -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script>
    <?php echo $scriptForThisPage; ?>
  </script>
</body>
<script language="JavaScript" type="text/javascript" src="js/cookie.js"></script>
<script language="JavaScript" type="text/javascript" src="js/cookied_color_themes.js"></script>
<script language="JavaScript" type="text/javascript" src="js/main.js"></script>
<script language="JavaScript" type="text/javascript" src="js/table.js"></script>

</html>