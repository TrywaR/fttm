<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="block_input <?=$arrTemplateParams['class']?>">
  <label>
    <p class="label"><?=$arrTemplateParams['title']?></p>
    <input
      type="time"
      class="input form-control"
      name="<?=$arrTemplateParams['name']?>"
      value="<?=$arrTemplateParams['value']?>"
      <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
      <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
    >
    <input type="text" disabled name="seconds" value="" class="form-control _seconds">
    <button type="button" name="button" id="timer_<?=$arrTemplateParams['name']?>">
      <i class="fas fa-play-circle"></i>
    </button>
    <button type="button" name="button" id="timer_<?=$arrTemplateParams['name']?>_pause">
      <i class="fas fa-pause-circle"></i>
    </button>
  </label>
</div>
<script>
  $(function(){
    var
      oTimerInterval<?=$arrTemplateParams['name']?> = {},
      oTimerInput = $(document).find('input[name="<?=$arrTemplateParams['name']?>"]'),
      arrTime = '',
      dTimeHours = 0,
      dTimeMinutes = 0,
      dTimeSeconds = 0,
      sTimeHours = '',
      sTimeMinutes = '',
      sTimeSeconds = ''

    $(document).find('#timer_<?=$arrTemplateParams['name']?>_pause').on ('click', function(){
      clearInterval(oTimerInterval<?=$arrTemplateParams['name']?>)
    })

    $(document).find('#timer_<?=$arrTemplateParams['name']?>').on ('click', function(){
      arrTime = oTimerInput.val().split(':')
      dTimeHours = parseInt(arrTime[0])
      dTimeMinutes = parseInt(arrTime[1])

      oTimerInterval<?=$arrTemplateParams['name']?> = setInterval(function () {
        dTimeSeconds++
        sTimeSeconds = String(dTimeSeconds)
        sTimeSeconds = sTimeSeconds.padStart(2,'0')

        if ( dTimeSeconds >= 60 ) {
          dTimeMinutes++
          dTimeSeconds = 0
        }
        sTimeMinutes = String(dTimeMinutes)
        sTimeMinutes = sTimeMinutes.padStart(2,'0')

        if ( dTimeMinutes >= 60 ) {
          dTimeHours++
          dTimeMinutes = 0
        }
        sTimeHours = String(dTimeHours)
        sTimeHours = sTimeHours.padStart(2,'0')

        if ( sTimeMinutes || dTimeHours ) oTimerInput.val( sTimeHours + ':' + sTimeMinutes )
        if ( oTimerInput.next('._seconds').length ) oTimerInput.next('._seconds').val( sTimeSeconds )

        if ( ! $(document).find('input[name="<?=$arrTemplateParams['name']?>"]').length ) clearInterval(oTimerInterval<?=$arrTemplateParams['name']?>)
      }, 1000)
    })
  })
</script>
