
<?php include "navigation.php";?>
<div class="nav-container flex">
      <div class="top-nav-container wrapper flex">
        <!-- Hamburger Icon -->
          <div class="toggle-btn">
            <i class="fa-solid fa-bars"></i><span id="menu-label"> Menu</span>
          </div>
        <!-- hamburger icon section ends -->

        <!-- sub menu for hamburger -->
         <div class="drop-down-menu">
          <?php 
            // Add login link to the top of navLinks
            $navLinks = ['loginForm.php' => 'Login'] + $baseNavLinks;
            $ulClassSiteNavigation ="navigation-list flex";
            include('templates/_navigation.html.php');
          ?>
         </div>


          <nav class="site-navigation-container flex">
            <?php 
            $navLinks = $baseNavLinks;
            $ulClassSiteNavigation="navigation-list flex";
            include ('templates/_navigation.html.php'); 
            ?>
          </nav>

          <?php include "_userNavigation.html.php"; ?>
       
      </div>
    </div>
    
   <?php include_once("templates/_search.html.php");?>
   
   <div class="category-nav-container wrapper left-rounded-border-small background-dark-blue flex ">
      <nav class="navbar flex">
       <?php $ulClassForCategory = "category-nav-menu font-weight-400 flex"; ?>
       <?php include("displayCategories.php"); ?>
      </nav>
  </div>