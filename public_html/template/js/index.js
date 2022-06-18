// Работа приложения
// Параметры
oParam = {}
oParam.ajax_salt = {
	'app': 'app'
}
oParam.site_url = '/'

if ( localStorage.getItem('oParam') ) oParam = $.parseJSON( localStorage.getItem('oParam') )
else localStorage.setItem('oParam', JSON.stringify(oParam))

// Сохраниение изменений
oParam.save = function(){
  localStorage.setItem('oParam', JSON.stringify(oParam))
}

arrPageParams = {}
arrPageContent = {}

// Функции
// Чистка классов по маске, для анимаций
// $("div").removeClassWild("status_*");
$.fn.removeClassWild = function( mask ) {
  return this.removeClass( function( index, cls ) {
      var re = mask.replace(/\*/g, '\\S+')
      return ( cls.match( new RegExp('\\b' + re + '', 'g' ) ) || []).join(' ')
  })
}

// scroll_to
function scroll_to(elem, fix_size, scroll_time, sScrollBlock){
  scroll_val = ( elem && elem.length && elem.offset().top ) ? elem.offset().top : 0
  scroll_val = fix_size ? fix_size : scroll_val
  scroll_time = scroll_time != null ? scroll_time : 500
  sScrollBlock = sScrollBlock ? sScrollBlock : ''
  sScrollBlockSelector = $(window).width() >= 919 ? '#main_block_content' : 'html, body'
  if ( sScrollBlock ) sScrollBlockSelector = sScrollBlock
  $(sScrollBlockSelector).animate({
    scrollTop: scroll_val
  }, scroll_time)

}
// scroll_to x

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

	// shower
	$(document).on('click', '[data-shower]', function(){
		if ( $(this).data().shower_class ) $(document).find($(this).data().shower).toggleClass( $(this).data().shower_class )
		$(document).find($(this).data().shower).toggleClass('_show_')
	})
})

// animation_number_to
// animation_number_to("example",900,1500,3000)
// animation_number_to("test",10,-5,15000)
function animation_number_to( oElem, from, to, duration, pause ) {
  if ( ! duration ) var duration = 2000
  if ( ! pause ) var pause = 10
  var start = new Date().getTime()
  setTimeout(function() {
      var now = (new Date().getTime()) - start
      var progress = now / duration
      var result = Math.floor((to - from) * progress + from)
      oElem.html( progress < 1 ? result : to )
      if (progress < 1) setTimeout(arguments.callee, 10)
  }, pause )
}
// animation_number_to x
