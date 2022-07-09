// form_authorization
$(function(){
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
