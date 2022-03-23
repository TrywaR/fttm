// Работа приложения
// Параметры
oParam = {}
oParam.ajax_salt = {
	'app': 'app'
}
oParam.site_url = '/'
// Функции
// Чистка классов по маске, для анимаций
// $("div").removeClassWild("status_*");
$.fn.removeClassWild = function( mask ) {
  return this.removeClass( function( index, cls ) {
      var re = mask.replace(/\*/g, '\\S+')
      return ( cls.match( new RegExp('\\b' + re + '', 'g' ) ) || []).join(' ')
  })
}

$(function(){
  // Обработка сессий
  session_init();
  // themes
	var prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)")
	if ( prefersDarkScheme.matches ) document.body.classList.add("dark-theme")
	else document.body.classList.remove("dark-theme")
  // bootstrap
	if ( $(document).find('#list-example').length )
		var scrollSpys = new bootstrap.ScrollSpy(document.body, {
		  target: '#list-example'
		})
})
