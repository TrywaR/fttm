$.fn.content_filter = function() {
  arrPageParams.content_filter_action = this.data().content_filter_action
  arrPageParams.content_filter_block = this.data().content_filter_block
  arrPageParams.content_filter_item = this.data().content_filter_item
  arrPageParams.content_filter_button = this.data().content_filter_button
  oFilter = $(this)
  content_filter_init( oFilter )
  content_filter_show( oFilter )
}

function content_filter_init( oFilter ) {
  // Нажатие на фильр
  oFilter.on('submit', function(){
    $(document).find( arrPageParams.content_filter_block ).addClass('animate__animated animate__headShake')
    $(document).find( arrPageParams.content_filter_block ).data('content_loader_filter', $(this).serializeArray())
    setTimeout(function(){
      $(document).find( arrPageParams.content_filter_block ).html('')
      $(document).find( arrPageParams.content_filter_block ).content_loader()
    }, 300)
    return false
  })
}

function content_filter_show( oFilter ) {
  // Получаем форму фильтрации
  $.when(
    content_download( {
      'action': arrPageParams.content_filter_action,
      'form': 'filter',
    }, 'text', false )
  ).then( function( resultData ){
    if ( ! resultData ) return false
    var oData = $.parseJSON( resultData )
    var sResultHtml = ''

    sResultHtml = oData
    $(document).find('#fttm_modal').modal('show')
    $(document).find('#fttm_modal').modal('show')
    // $('#myModal').modal('handleUpdate')
    // oBlockActions.html( sResultHtml ).addClass('_active_  animate__bounce')
  })
}
