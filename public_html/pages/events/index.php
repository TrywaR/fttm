<main class="container pt-4 pb-4">
  <div class="row">
    <div class="col-12">
      <h1>Events</h1>
    </div>
  <div>
  <div class="row">
    <?
    $sQuery  = "SELECT * FROM `events`";
    $sQuery .= " WHERE `active` > 0";
    $sQuery .= " ORDER BY `sort` ASC";
    $sQuery .= " LIMIT 20";

    $arrEvents = $db->query_all($sQuery);

    // Прикручиваем рейтинги
    foreach ($arrEvents as &$arrEvent) {
      ?>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><?=$arrEvent['title']?></h5>
            <p class="card-text"><?=$arrEvent['description']?></p>
            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
          </div>
        </div>
      </div>
      <?
    }
    ?>

    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Новая задача</h5>
          <a href="#" class="btn btn-primary">Добавить</a>
        </div>
      </div>
    </div>
  </div>
</main>
