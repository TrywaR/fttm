<?
// $arrTemplateParams = [];
// $arrTemplateParams['title'] = '';
// $arrTemplateParams['name'] = '';
// $arrTemplateParams['value'] = '';
// $arrTemplateParams['required'] = '';
// $arrTemplateParams['class'] = '';
?>
<div class="input-group mb-2 <?=$arrTemplateParams['class']?> input_timer">
  <!-- <label
  for="form_input_<?=$arrTemplateParams['name']?>"
  class="form-label"><?=$arrTemplateParams['title']?></label> -->

  <span class="input-group-text _text" >
    <?php if ( isset($arrTemplateParams['icon']) ): ?>
      <span class="_icon">
        <?=$arrTemplateParams['icon']?>
      </span>
    <?php endif; ?>
    <?php if ( isset($arrTemplateParams['title']) ): ?>
      <span class="_text">
        <?=$arrTemplateParams['title']?>
      </span>
    <?php endif; ?>
  </span>

  <input
    type="time"
    class="input form-control _input"
    id="form_input_<?=$arrTemplateParams['name']?>"
    name="<?=$arrTemplateParams['name']?>"
    <?php if ( $arrTemplateParams['value'] ): ?>
      value="<?=$arrTemplateParams['value']?>"
    <?php else: ?>
      value="00:00"
    <?php endif; ?>
    <?if ( $arrTemplateParams['required'] ) echo 'required="required"'?>
    <?if ( $arrTemplateParams['disabled'] ) echo 'disabled="disabled"'?>
  >

  <input type="text" disabled name="seconds" value="" class="form-control _seconds">

  <button class="btn btn-dark _button" type="button" name="button" id="timer_<?=$arrTemplateParams['name']?>">
    <div class="_icon">
      <div class="_on">
        <i class="fas fa-play-circle"></i>
      </div>
      <div class="_off">
        <i class="fa-solid fa-circle-stop"></i>
      </div>
    </div>
  </button>
</div>

<script>
  $(function(){
    var oTimerInterval<?=$arrTemplateParams['name']?> = {}

    $(document).find('#timer_<?=$arrTemplateParams['name']?>_stop').on ('click', function(){
      clearInterval(oTimerInterval<?=$arrTemplateParams['name']?>)
    })

    $(document).find('#timer_<?=$arrTemplateParams['name']?>').on ('click', function(){
      clearInterval(oTimerInterval<?=$arrTemplateParams['name']?>)

      if ( $(this).hasClass('_stop_') ) {
        $(this).removeClass('_stop_').removeClass('__on')
        return false
      }
      else $(this).addClass('_stop_').addClass('__on')

      var
        oTimerInput = $(document).find('#form_input_<?=$arrTemplateParams['name']?>'),
        arrTime = oTimerInput.val().split(':'),
        dTimeHours = parseInt(arrTime[0]),
        dTimeMinutes = parseInt(arrTime[1]),
        dTimeSeconds = 0,
        sTimeHours = '',
        sTimeMinutes = '',
        sTimeSeconds = ''

      oTimerInterval<?=$arrTemplateParams['name']?> = setInterval(function () {
        dTimeSeconds++
        sTimeSeconds = String(dTimeSeconds)
        sTimeSeconds = sTimeSeconds.padStart(2,'0')

        if ( dTimeSeconds >= 59 ) {
          dTimeMinutes++
          dTimeSeconds = 0
        }
        sTimeMinutes = String(dTimeMinutes)
        sTimeMinutes = sTimeMinutes.padStart(2,'0')

        if ( dTimeMinutes >= 59 ) {
          dTimeHours++
          dTimeMinutes = 0
        }

        sTimeHours = String(dTimeHours)
        sTimeHours = sTimeHours.padStart(2,'0')

        if ( dTimeMinutes || dTimeHours ) oTimerInput.val( sTimeHours + ':' + sTimeMinutes )
        if ( oTimerInput.next('._seconds').length ) oTimerInput.next('._seconds').val( sTimeSeconds )

        if ( ! $(document).find('#form_input_<?=$arrTemplateParams['name']?>').length ) clearInterval(oTimerInterval<?=$arrTemplateParams['name']?>)
      }, 1000)
    })
  })
</script>
