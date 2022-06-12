// Functions
function forms_init( oForm ){
  // switch скрытые блоки
  $( oForm ).find('.switch select').each(function(){
    oForm.find('.switch_' + $(this).attr('name') + '-' + $(this).val()).addClass('_slow_')
  })
}

$(function(){
	// Params
  var
    oForm = false,
    oElem = false

  // switch скрытые блоки
  $(document).on('change', '.switch select', function(){
    $(this).parents('form').find('[class*=switch_' + $(this).attr('name') + ']').removeClass('_slow_')
    $(this).parents('form').find('.switch_' + $(this).attr('name') + '-' + $(this).val()).addClass('_slow_')
  })
})
