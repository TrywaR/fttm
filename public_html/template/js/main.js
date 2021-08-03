oParam = {}
oParam.ajax_salt = {
	'app': 'app'
}
oParam.site_url = '/'

// $.when(
//   content_download( oData )
// ).then( function( resultData ){
//
// })

// content_download
function content_download( oData, oReturnType, sAppStatus ) {
  // oData - Какие данные запросить
  // sAppStatus - Показывать статусы, по умолчанию да

  site_url = oData.site_url ? oData.site_url : ''

  // Отображение статуса
  if ( typeof sAppStatus === 'undefined' ) sAppStatus = true
  // Тип возвращяемых данных
  if ( typeof oReturnType === 'undefined' ) oReturnType = 'html'

  // Получаем данные
  return $.ajax({
    url: site_url,
    dataType: oReturnType,
    data: $.extend( oData, oParam.ajax_salt ),
    method: 'POST'
  }).fail(function( oData ){
    if ( sAppStatus ) fttm_alerts( {'error': {'text': 'Ошибка соединения'}} )
  }).done(function( oData ){
    if ( sAppStatus ) fttm_alerts( oData )
  })
}
// content_download x

// fttm_alerts
function fttm_alerts( oData, oForm ){
	var oFttmAlertsBlock = $(document).find('.fttm_alerts')
	if ( oForm.length ) oFttmAlertsBlock = oForm.find('._fttm_alerts')

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


$(function(){
	$(document).on('click', '.content_download', function(){
		var oData = {
			'action' : $(this).data().action,
			'form' : $(this).data().form,
			'id' : $(this).data().id
		}

		if ( $(this).data().form == 'del' )
			if ( confirm('Подтвердите удаление') ) $(this).parents('.col').remove()
			else return false

		$.when(
		  content_download( oData, 'json' )
		).then( function( oData ){
			fttm_alerts( oData )
		})
	})

	// $("[data-fancybox]").fancybox({
	// 	// Options will go here
	// })

	// post
	$(document).find('form').on ('submit', function(){
		var
		oForm = $(this)
		oData = oForm.serializeArray()

		$.when(
			content_download( oData, 'json', false )
		).then( function( oData ){
			fttm_alerts( oData, oForm )

			// Если модель, то сохраняем в локали
			if ( oData.model ) {
				localStorage.setItem(oData.model, JSON.stringify(oData.data))
				// if ( localStorage.getItem('code') ) code = $.parseJSON( localStorage.getItem('code') )
			}
		})

		return false
	})
	// post x
})
