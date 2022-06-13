<?
/**
 * Times_category
 */
class times_category extends model
{
  public static $table = ''; # Таблица в bd
  public static $id = '';
  public static $title = '';
  public static $sort = '';
  public static $active = '';
  public static $color = '';
  public static $user_id = '';

  function get_category(){
    $arrResult = [];
    $arrCategory = $this->get();
    if ( (int)$arrCategory['user_id'] ) $arrCategory['edit_show'] = 'true';
    // translate
    $oLang = new lang();
    if ( $arrCategory['title'] ) $arrCategory['title'] = $oLang->get($arrCategory['title']);
    $arrResult = $arrCategory;
    return $arrResult;
  }

  function get_categories(){
    $arrResults = [];
    $arrTimesCategories = $this->get();
    foreach ($arrTimesCategories as $arrTimeCategory) {
      $oCategory = new times_category( $arrTimeCategory['id'] );
      $arrResults[] = $oCategory->get_category();
    }
    return $arrResults;
  }

  public function fields() # Поля для редактирования
  {
    $oLang = new lang();

    $arrFields = [];
    $arrFields['id'] = ['title'=>'ID','type'=>'number','disabled'=>'disabled','value'=>$this->id]; # Для отображения пользователю
    $arrFields['id'] = ['title'=>'ID','type'=>'hidden','disabled'=>'disabled','value'=>$this->id]; # Для передачи в параметры
    $arrFields['user_id'] = ['title'=>$oLang->get('User'),'type'=>'hidden','value'=>$_SESSION['user']['id']];

    // $arrTypeFilter = [
    //   array('id'=>0,'name'=>$oLang->get('Spend')),
    //   array('id'=>1,'name'=>$oLang->get('Replenish')),
    // ];
    // $arrFields['type'] = ['class'=>'switch','title'=>$oLang->get('Type'),'type'=>'select','options'=>$arrTypeFilter,'value'=>$this->type];

    $arrFields['title'] = ['title'=>$oLang->get('Title'),'type'=>'text','required'=>'required','value'=>$this->title];
    $arrFields['sort'] = ['title'=>$oLang->get('Sort'),'type'=>'number','value'=>$this->sort];

    $sColor = $this->color ? $this->color : sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) );
    $arrFields['color'] = ['title'=>$oLang->get('Color'),'type'=>'color','value'=>$sColor];

    // $arrFields['active'] = ['title'=>$oLang->get('Active'),'type'=>'hidden','value'=>$this->active];

    return $arrFields;
  }

  function __construct( $times_category_id = 0 )
  {
    $this->table = 'times_categories';

    if ( $times_category_id ) {
      $mySql = "SELECT * FROM `" . $this->table . "`";
      $mySql .= " WHERE `id` = '" . $times_category_id . "'";
      $arrCard = db::query($mySql);

      $this->id = $arrCard['id'];
      $this->title = $arrCard['title'];
      $this->sort = $arrCard['sort'];
      $this->active = $arrCard['active'];
      $this->color = $arrCard['color'];
      $this->user_id = $arrCard['user_id'];
    }
  }
}
