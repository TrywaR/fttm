// Работа сессий
function session_init() {
  // Проверка сессии
  var sSession = localStorage.getItem('session')
  // Сессия есть, продолжаем
  if ( sSession ) {
    $.when(
      content_download( {
        'app':'app',
        'action':'sessions',
        'form':'continue',
        'session': sSession,
      }, 'json', false )
    ).done( function( oData ){
      // Сессия ок
      if ( oData.success ) {
        if ( oData.success.user ) localStorage.setItem('user', JSON.stringify(oData.success.user))
        if ( oData.success.session ) localStorage.setItem('session', oData.success.session)
      }
      if ( oData.error ) {
        status( oData.error );
        localStorage.clear()
      }
    })
  }
  // Сессии нет, создаём
  else {
    $.when(
      content_download( {
        'app':'app',
        'action':'sessions',
        'form':'new',
      }, 'json', false )
    ).done( function( oData ){
      if ( oData.success && oData.success.session ) localStorage.setItem('session', oData.success.session)
      if ( oData.error ) localStorage.clear()
    })
  }
}
