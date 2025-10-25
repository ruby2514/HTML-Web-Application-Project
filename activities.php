<?php include __DIR__ . "/includes/header.php"; ?>
<section class="panel">
  <h2 style="font-size:26px; margin:0 0 12px; color:#333;">Activities at Pacific Trails</h2>
  <div class="grid">
    <?php
      $acts = [
        ["pool.jpg","Pool"],["hiking.webp","Hiking"],["Parasailing.jpg","Parasailing"],["golf.jpeg","Golf"]
      ];
      foreach($acts as [$img,$alt]): ?>
        <figure class="card" style="padding:0;">
          <img src="assets/images/<?php echo $img; ?>" alt="<?php echo htmlspecialchars($alt); ?>" class="activity-img">
        </figure>
    <?php endforeach; ?>
  </div>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
