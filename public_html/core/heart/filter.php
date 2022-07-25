<?
/**
 * Filter
 */
class filter
{
  public $query = '';
  public $from = '';
  public $limit = '';
  public $object = '';
  public $arrParams = '';

  public function get_val( $sParamName = '' ){

  }

  public function get(){
    // Пагинация
    // if ( $_REQUEST['from'] ) $this->from = $_REQUEST['from'];
    // if ( $_REQUEST['limit'] ) $this->limit = $_REQUEST['limit'];

    // Фильтрация
    if ( $_REQUEST['filter'] ) {
      $arrFilters = $_REQUEST['filter'];
      foreach ($arrFilters as $arrFilter) {
        if ( $arrFilter['value'] ) {
          $this->arrParams[$arrFilter['name']] = $arrFilter['value'];

          switch ($arrFilter['name']) {
            case 'date':
            $this->qeury .= ' AND `' . $arrFilter['name'] . '` = "' . $arrFilter['value'] . ' 00:00:00"';
            break;

            default:
            $this->qeury .= ' AND `' . $arrFilter['name'] . '` = ' . $arrFilter['value'];
            break;
          }
        }
      }
    }

    return $this->qeury;
  }

  function __construct( $oObject = '' )
  {
    $this->query = '';
    $this->from = '';
    $this->limit = '';
    $this->object = $oObject;
    $this->arrParams = [];
  }
}
