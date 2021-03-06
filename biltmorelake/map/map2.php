<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Service Map</title>
   
  <!--  Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"/>
  
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script src="../js/jquery.min.js"></script>   
  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!--Site Stylesheet-->
  <link href="../../css/style.css" rel="stylesheet" type="text/css">

</head> 

<body>
    
  <!-- Navigation -->
<nav class="navbar navbar-expand-lg bg-dblue navbar-dark mainnav">
      <a class="navbar-brand" href="https://wncbroadband.org/blog">
        <img src="../img/wncbroadbandlogo.png" alt="WNC Broadband Project Logo Image and Link" class="img-fluid logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse navbars pull-right" id="navbar1">
        <ul class="navbar-nav ml-auto small">
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../aboutproject.html">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../broadband101.html">Broadband 101</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/community-initiatives/">Community Initiatives</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../advocacy.html">Actions We Can Take</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wncbroadband.org/blog/blog/">News</a>
          </li>
        </ul>
  </div>
</nav>

<nav class="navbar navbar-expand-md bg-lblue navbar-dark communitynav">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar2" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
 <div class="collapse navbar-collapse navbars" id="navbar2">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="../index.html">Biltmore Lake</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../aboutBiltmoreLake.html">About Community</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../survey/biltmorelake-survey/survey.html">Survey</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../providers.html">Service Providers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../communitycontacts.html">Community Contacts</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Biltmore Lake Maps</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="map.html">Speed Test Results</a></li>
            <li><a class="dropdown-item" href="map2.php">Services Offered</a></li>
           </ul>
          </li>
        </ul>
      </div>
  </nav>
<!--  END NAVBAR  -->

  
<!--  MAP   -->
    <div class="service_myMap" id="myMap">
      <iframe src="https://www.google.com/maps/d/embed?mid=1ZhPnpvEGNYriKJvObsaS63bKM8b54c4O" width="100%" height="100%"></iframe>   
    </div>
        <!--  MAP END   -->

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  
  <!-- Footer -->
<footer class="footer bg-dblue text-white pt-5">
    <div class="container">
      <div class="row">
      <div class="col-6 col-sm-3">
        <ul>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/">Home</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../aboutproject.html">About</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../faq.html">FAQ</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../contact.html">Contact</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../broadband101.html">Broadband 101</a>
          </li><br>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/community-initiatives/">Community Initiatives</a>
          </li><br>
        </ul>
      </div>
      <div class="col-6 col-sm-3">
        <ul>
          <li class="list-inline-item">
          <a href="../../survey/speedtest.php">Speed Test</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../advocacy.html">Actions We Can Take</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../getinvolved.html">Get Involved</a>
          </li><br>
          <li class="list-inline-item">
          <a href="../../101links.html">Resources</a>
          </li><br>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/blog/">News</a>
          </li><br>
          <li class="list-inline-item">
          <a href="https://wncbroadband.org/blog/archives/">Archives</a>
          </li><br>
        </ul>
      </div>
      <div class="col-3">
      </div>
      <div class="col-3">
      </div>

        <div class="col-12 text-center">
        <p>&copy; 2020 WNC Broadband Project | <a href="../privacypolicy.html"> Privacy Policy</a></p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer End -->


  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.slim.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    


</body>
</html>