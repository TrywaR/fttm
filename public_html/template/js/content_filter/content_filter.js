$.fn.content_filter = function() {
  arrPageParams.content_filter_action = this.data().content_filter_action
  arrPageParams.content_filter_block = this.data().content_filter_block
  arrPageParams.content_filter_item = this.data().content_filter_item
  arrPageParams.content_filter_button = this.data().content_filter_button
  oFilter = $(this)
  content_filter_init( oFilter )
}

function content_filter_init( oFilter ) {
  // Нажатие на фильр
  oFilter.on('submit', function(){
    $(document).find( arrPageParams.content_filter_block ).addClass('animate__animated animate__headShake')
    $(document).find( arrPageParams.content_filter_block ).data('content_loader_filter', $(this).serializeArray())

    // Сохранение в url
    var oUrl = new URL(window.location)
    $.each($(this).serializeArray(), function( iIndex, oElem ){
      if ( oElem.value ) {
        oUrl.searchParams.set(oElem.name, oElem.value)
        history.pushState(null, null, oUrl)
      }
    })

    setTimeout(function(){
      $(document).find( arrPageParams.content_filter_block ).html('')
      $(document).find( arrPageParams.content_filter_block ).content_loader()
    }, 300)
    return false
  })
}
