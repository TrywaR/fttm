// Параметры
oParam = {}
oParam.ajax_salt = {
	'app': 'app'
}
oParam.site_url = '/'

// События
$(function(){
	// themes
	var prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)")
	if (prefersDarkScheme.matches) document.body.classList.add("dark-theme")
	else document.body.classList.remove("dark-theme")
	// themes x

	// bootstrap
	if ( $(document).find('#list-example').length )
		var scrollSpys = new bootstrap.ScrollSpy(document.body, {
		  target: '#list-example'
		})
	// bootstrap x
})

// Функции
// Чистка классов по маске, для анимаций
// $("div").removeClassWild("status_*");
$.fn.removeClassWild = function(mask) {
  return this.removeClass(function(index, cls) {
      var re = mask.replace(/\*/g, '\\S+')
      return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ')
  })
}

// fttm_alerts
function fttm_alerts( oData, oForm ){
	var oFttmAlertsBlock = $(document).find('.fttm_alerts')
	if ( oForm && oForm.length ) oFttmAlertsBlock = oForm.find('._fttm_alerts')

	if ( oData.success && oData.success.text )
		return oFttmAlertsBlock.html( fttm_alerts_html( oData.success.text, 'alert-success' ) )
	if ( oData.error && oData.error.text )
		return oFttmAlertsBlock.html( fttm_alerts_html( oData.error.text, 'alert-danger' ) )
	if ( oData.alert && oData.alert.text )
		return oFttmAlertsBlock.html( fttm_alerts_html( oData.alert.text, 'alert-alert' ) )

	if ( oData.success )
		return oFttmAlertsBlock.html( fttm_alerts_html( oData.success, 'alert-success' ) )
	if ( oData.error )
		return oFttmAlertsBlock.html( fttm_alerts_html( oData.error, 'alert-danger' ) )
	if ( oData.alert )
		return oFttmAlertsBlock.html( fttm_alerts_html( oData.alert, 'alert-alert' ) )

	console.log( oData )
}
function fttm_alerts_html( sText, sClass ){
	var
	fttm_alert_html = '',
	fttm_alert_class = sClass ? sClass : 'alert-primary'

	fttm_alert_html += '<div class="alert ' + fttm_alert_class + ' alert-dismissible fade show" role="alert">'
		fttm_alert_html += sText
		fttm_alert_html += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
	fttm_alert_html += '</div>'

	return fttm_alert_html
}
// fttm_alerts x

// fttm_progress_bar
function fttm_progress_bar ( intProgress ) {
	var oProgressBar = $(document).find('.fttm_progress')

	if ( intProgress < 1 ) oProgressBar.addClass('_active_')
	else oProgressBar.removeClass('_active_')

	oProgressBar.attr('aria-valuenow', intProgress * 100 )
	oProgressBar.css('width', intProgress * 100 + '%' )
}
// fttm_progress_bar x
