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

  // From registration
  $(document).find('#form_registration,#form_password_recovery').on ('submit', function(){
    var
		oForm = $(this)
		oData = oForm.serializeArray()

		$.when(
			content_download( oData, 'json', true )
		).done( function( oData ){
			if ( ! oData.success ) return false

			// Если редирект
			var iLocationTime = 1000
			if ( oData.success && oData.success.location_time ) iLocationTime = oData.success.location_time
			if ( oData.success.location )
				setTimeout(function(){
				  window.location.replace( oData.success.location )
				}, iLocationTime)

			// Если нужно перезагрузить страницу
			if ( oData.success.location_reload )
				setTimeout(function(){
					location.reload()
				}, iLocationTime)

			// Перезагружаем страницу если надо
			if( oForm.hasClass('reload_page') ) location.reload()
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
        window.location.replace("/")
      }
    })
    return false
  })

  // button logout
  $(document).find('#user_logout').on ('click', function(){
    if ( confirm('Confirm logout') ) {
      $.when(
        content_download( {
          'app': 'app',
          'action': 'authorizations',
          'form': 'logout',
        }, 'json', true )
      ).done( function( oData ){
        // Если ошибка, невыходим
        if ( oData.error ) return false
        // Выходим
        if ( oData.success ) {
          localStorage.clear()
          window.location.replace("/")
        }
      })
    }
    return false
  })

  // button delete
  $(document).find('#user_delete').on ('click', function(){
    if ( confirm('Confirm delete profile') ) {
      $.when(
        content_download( {
          'app': 'app',
          'action': 'authorizations',
          'form': 'delete',
        }, 'json', true )
      ).done( function( oData ){
        // Если ошибка, невыходим
        if ( oData.error ) return false
        // Выходим
        if ( oData.success ) {
          localStorage.clear()
          window.location.replace("/")
        }
      })
    }
    return false
  })
})
