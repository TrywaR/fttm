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
  // bootstrap
	if ( $(document).find('#list-example').length )
		var scrollSpys = new bootstrap.ScrollSpy(document.body, {
		  target: '#list-example'
		})

	// shower
	$(document).on('click', '[data-shower]', function(){
		if ( $(this).data().shower_class ) $(document).find($(this).data().shower).toggleClass( $(this).data().shower_class )
		$(document).find($(this).data().shower).toggleClass('_show_')
		return false
	})


})

// animation_number_to
// animation_number_to("example",900,1500,3000)
// animation_number_to("test",10,-5,15000)
function animation_number_to( oElem, iFrom, iTo, iDuration, sTheme, sFormat ) {
	if ( ! oElem.length ) return false
	if ( ! iDuration ) var iDuration = 2000
	if ( ! sTheme ) var sTheme = 'minimal'
	if ( ! sFormat ) var sFormat = '( ddd),dd'
	if ( ! iFrom ) var iFrom = 0
	if ( ! iTo ) var iTo = 0

	if ( parseFloat(iFrom.toString().indexOf(':')) > 0 || parseFloat(iTo.toString().indexOf(':')) > 0 ) {
		sFormat = '(dd):dd'
		iTo = parseFloat(iTo.toString().replace(':', '.'))
	}

	iFrom = parseFloat(iFrom.toString().replace(/\s/g, ''))
	iTo = parseFloat(iTo.toString().replace(/\s/g, ''))

	var oOdometer = new Odometer({
	  el: oElem[0],
	  value: iFrom,
	  theme: sTheme,
	  format: sFormat,
	  duration: iDuration
	})

	// oOdometer.render()

	oOdometer.update( iTo )
}
// animation_number_to x

$(function(){
	// theme_switch
	if ( localStorage.getItem('theme') ) {
		content_download( {
			'action': 'sessions',
			'form': 'theme',
			'theme': localStorage.getItem('theme'),
		}, 'json', false )
	}

	$(document).find('#theme_switch ._val').on ('click', function(){
		var oButton = $(this)
		localStorage.setItem('theme', oButton.data().val)

		$.when(
			content_download( {
				'action': 'sessions',
				'form': 'theme',
				'theme': oButton.data().val,
			}, 'json', false )
		).then( function( oData ){
			if ( oData.success ) location.reload()
		})
	})
	// theme_switch x

	// lang_switch
	$(document).find('#lang_switch ._vals').on ('change', function(){
		var oButton = $(this)
		localStorage.setItem('lang', oButton.val())

		$.when(
			content_download( {
				'action': 'sessions',
				'form': 'lang',
				'lang': oButton.val(),
			}, 'json', false )
		).then( function( oData ){
			if ( oData.success ) location.reload()
		})
	})
	// lang_switch x
})
