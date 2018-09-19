<div class="container pt-3">
  <div class="row">
    <div class="col-md-8">
      <?php if (isset($_GET['userid'])): ?>
        <?php displayTweets($_GET['userid']); ?>
      <?php else: ?>
        <h2 class="text-center">Active Users</h2>
        <?php displayUsers(); ?>
      <?php endif; ?>
    </div>
    <div class="col-md-4 mt-5">
      <?php displaySearch(); ?>
      <?php displayTwingeBox(); ?> 
    </div>
  </div>
</div>
