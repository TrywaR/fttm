// Functions
function forms_init( oForm ){
  // switch скрытые блоки
  $( oForm ).find('.switch select').each(function(){
    oForm.find('.switch_' + $(this).attr('name') + '-' + $(this).val()).addClass('_show_')
  })
}

$(function(){
	// Params
  var
    oForm = false,
    oElem = false

  // Froms
  $(document).find('form.__form_event_default').on ('submit', function(){
    content_download( $(this).serializeArray(), 'json', true )
    return false
  })

  // switch скрытые блоки
  $(document).on('change', '.switch select', function(){
    $(this).parents('form').find('[class*=switch_' + $(this).attr('name') + ']').removeClass('_show_')
    $(this).parents('form').find('.switch_' + $(this).attr('name') + '-' + $(this).val()).addClass('_show_')
  })
})
