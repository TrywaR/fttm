<?
$oProject = new project( $_REQUEST['project_id'] );
?>
<div class="main_jumbotron">
  <div class="_block_title">
    <small class="_sub"><?=$oLang->get('Project')?></small>
    <h1 class="sub_title _value">
      <?=$oLang->get($oProject->title)?>
    </h1>
  </div>
</div>

<div class="main_content">
  <div class="block_project">
    <div class="_description">
      <?=$oProject->description?>
    </div>

    <div class="_client">
      <a class="btn" href="/clients/">
        <i class="fa-solid fa-folder"></i>
        <?
        $oClient = new client( $oProject->client_id );
        echo $oClient->title;
        ?>
      </a>
    </div>

    <div class="_analytics">
      <a class="btn" href="/projects/analytics/?project_id=<?=$oProject->id?>">
        <i class="fas fa-chart-area"></i>
      </a>
    </div>
  </div>
</div>
