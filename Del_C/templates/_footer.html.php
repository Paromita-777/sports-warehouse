
<div class="top-footer background-light-blue">
      <div class="footer-items wrapper flex">
        <div class="footer-site-navigation p1 flex">
          <h6 class="text-font-22">site-navigation</h6>
          <nav class="main-navigation  flex">
              <?Php 
              require_once "navigation.php";
                $footerExtraLinks = [
                  "privacyPolicy.php" => "Privacy Policy",
                ];
                $navLinks = $baseNavLinks + $footerExtraLinks;
                $ulClassSiteNavigation= "navigation-list flex text-font-16";
                // $isFooterNav = true;
                include ('templates/_navigation.html.php'); 
              ?>
          </nav>
        </div>

        <div class="footer-product-categories p2 background-orange  flex">
          <h6 class="text-font-22">Product categories </h6>
          <nav class="navbar flex">
            <?php $ulClassForCategory="footer-product-navlist flex text-font-16"; ?>
            <?php include("displayCategories.php"); ?>
          </nav>
        </div>

        <?php include_once ('templates/_socialIcon.html.php');?>

      </div>
    </div>
    <?php include_once ('templates/_subFooter.html.php');?>