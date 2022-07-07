<?
 // Stat info
 $sQuery  = "SELECT * FROM `projects`";
 $arrProjects = $db->query_all($sQuery);
 $sQuery  = "SELECT * FROM `users`";
 $arrUsers = $db->query_all($sQuery);
 ?>

<div class="main_jumbotron">
  <div class="_block_title">
    <h1 class="sub_title _value">
      <?=$oLang->get('Analytics')?>
    </h1>
  </div>
</div>

<div class="main_content">
  <div class="card mb-2">
    <div class="card-body">
      <h5 class="card-title"> <i class="fas fa-users"></i> <?=$oLang->get('Users')?> <strong><?=count($arrUsers)?></strong></h5>
      <?php if (empty($_SESSION['user'])): ?>
        <a href="/registration/" class="btn btn-primary"> <?=$oLang->get('Add')?> </a>
      <?php endif; ?>
      <!-- <button class="btn btn-primary" type="button" name="button">
        ADD</button> -->
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title"> <i class="fas fa-sitemap"></i> <?=$oLang->get('Projects')?> <strong><?=count($arrProjects)?></strong></h5>
    </div>
  </div>
</div>
