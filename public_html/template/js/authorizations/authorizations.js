// form_authorization
$(function(){
  // From authorizations
  $(document).find('#form_authorization_login').on ('submit', function(){
    $.when(
			content_download( $(this).serializeArray(), 'json', true )
		).done( function( oData ){
      if ( oData.success ) localStorage.setItem('user', JSON.stringify(oData.success.data))
      if ( oData.success ) localStorage.setItem('session', oData.success.session)
    })
    return false
  })

  // From logout
  $(document).find('#form_authorization_logout').on ('submit', function(){
    $.when(
			content_download( $(this).serializeArray(), 'json', true )
		).done( function( oData ){
      // Если ошибка, невыходим
      if ( oData.error ) return false
      // Выходим
      if ( oData.success ) {
        localStorage.clear()
        // Сохраняем код доступа, чтобы не вводить в приложении
        localStorage.setItem('code', JSON.stringify(code) )
        window.location.replace("/")
      }
    })
    return false
  })
})
