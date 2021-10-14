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
	var oFttmAlertsBlock = false
	if ( oForm && oForm.length ) oFttmAlertsBlock = oForm.find('._fttm_alerts')

	if ( ! oFttmAlertsBlock ) {
    // - Ошибка входа
    if ( oData.error && oData.error.text ) return $.jGrowl(oData.error.text, {position: 'top-right',theme: 'sc_error'})
    // - Уведомление
    if ( oData.alert && oData.alert.text ) return $.jGrowl(oData.alert.text, {position: 'top-right',theme: 'sc_alert'})
    // - Успех
    if ( oData.success && oData.success.text ) return $.jGrowl(oData.success.text, {position: 'top-right',theme: 'sc_success'})

    // - Ошибка входа
    if ( oData.error ) return $.jGrowl(oData.error, {position: 'top-right',theme: 'sc_error'})
    // - Уведомление
    if ( oData.alert ) return $.jGrowl(oData.alert, {position: 'top-right',theme: 'sc_alert'})
    // - Успех
    if ( oData.success ) return $.jGrowl(oData.success, {position: 'top-right',theme: 'sc_success'})
    // По умолчанию
    if ( oData != 'undefined' ) return $.jGrowl(oData, {position: 'top-right',theme: 'sc_default'})
  }
  else {
    // - Ошибка входа
    if ( oData.error && oData.error.text ) oFttmAlertsBlock.html( '<div class="error">' + oData.error.text + '</div>' )
    // - Уведомление
    if ( oData.alert && oData.alert.text ) oFttmAlertsBlock.html( '<div class="success">' + oData.alert.text + '</div>' )
    // - Успех
    if ( oData.success && oData.success.text ) oFttmAlertsBlock.html( '<div class="success">' + oData.success.text + '</div>' )

    // - Ошибка входа
    if ( oData.error ) oFttmAlertsBlock.html( '<div class="error">' + oData.error + '</div>' )
    // - Уведомление
    if ( oData.alert ) oFttmAlertsBlock.html( '<div class="success">' + oData.alert + '</div>' )
    // - Успех
    if ( oData.success ) oFttmAlertsBlock.html( '<div class="success">' + oData.success + '</div>' )
  }

	// if ( oData.success && oData.success.text )
	// 	return oFttmAlertsBlock.html( fttm_alerts_html( oData.success.text, 'alert-success' ) )
	// if ( oData.error && oData.error.text )
	// 	return oFttmAlertsBlock.html( fttm_alerts_html( oData.error.text, 'alert-danger' ) )
	// if ( oData.alert && oData.alert.text )
	// 	return oFttmAlertsBlock.html( fttm_alerts_html( oData.alert.text, 'alert-alert' ) )
	//
	// if ( oData.success )
	// 	return oFttmAlertsBlock.html( fttm_alerts_html( oData.success, 'alert-success' ) )
	// if ( oData.error )
	// 	return oFttmAlertsBlock.html( fttm_alerts_html( oData.error, 'alert-danger' ) )
	// if ( oData.alert )
	// 	return oFttmAlertsBlock.html( fttm_alerts_html( oData.alert, 'alert-alert' ) )


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
