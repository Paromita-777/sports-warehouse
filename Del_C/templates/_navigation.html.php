<?php
    // Get the currently-loaded PHP page/script, e.g. index.php
    $currentPage = basename($_SERVER["SCRIPT_NAME"]);
?>
  <ul class="<?= $ulClassSiteNavigation ?>">
  <?php foreach ($navLinks as $linkHref => $linkText): ?>
    <?php
      $isActive = $linkHref === $currentPage ? 'active' : '';
    ?>
    <li>
      <a class="navigation-link <?= $isActive ?>" href="<?= esc($linkHref) ?>">
        <?= esc($linkText) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
