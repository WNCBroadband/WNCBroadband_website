<nav class="navbar navbar-expand-lg navbar-dark bg-dblue fixed-top stroke">
	<div class="container">
    	<a class="navbar-brand" href="https://wncbroadband.org/blog/">
        	<img src="https://wncbroadband.org/img/wncbroadbandlogo.png" width="100px" alt="WNC Broadband Project Logo Image and Link">
    	</a>
    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
      	</button>
      	<div class="collapse navbar-collapse" id="navbarResponsive">
          	<ul class="navbar-nav ml-auto">
            	<li class="nav-item">
                	<a id="navid-home" class="nav-link" href="https://wncbroadband.org/blog/">Home</a>
              	</li>
              	<li class="nav-item">
              		<a id="navid-about" class="nav-link" href="https://wncbroadband.org/aboutproject.php">About</a>
              	</li>
              	<li class="nav-item">
                	<a id="navid-broadband101"  class="nav-link" href="https://wncbroadband.org/broadband101.php">Broadband 101</a>
              	</li>
               	<li class="nav-item">
                	<a id="navid-communityinitiatives" class="nav-link" href="https://wncbroadband.org/blog/community-initiatives/">Community Initiatives</a>
              	</li>
               	<li class="nav-item">
                	<a id="navid-actionswecantake" class="nav-link" href="https://wncbroadband.org/advocacy.php">Actions We Can Take</a>
              	</li>
              	<li class="nav-item">
                	<a id="navid-news" class="nav-link" href="https://wncbroadband.org/blog/blog/">News</a>
              	</li>
            </ul>
    	</div>
	</div>
</nav>



<script>
// This gives current page "active" class in the header (text is white).
$(function(){
	if(window.navid){
		var activeLink;
		activeLink = ("navid-"+navid);
		document.getElementById(activeLink).classList.add("active");
	}		
});
</script>

<!-- add "active" class any to nav-link item for it to be white. For instance: -->
<!-- <a class="nav-link active" href="broadband101.html">Broadband 101</a> -->
