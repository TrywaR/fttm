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
    method: 'POST',
		xhr: function() {
			 var xhr = new window.XMLHttpRequest();

			 // Upload progress
			 xhr.upload.addEventListener("progress", function(evt){
					 if (evt.lengthComputable) {
							 var percentComplete = evt.loaded / evt.total;
							 //Do something with upload progress
							 console.log('percentComplete 1: ' + percentComplete);
							 fttm_progress_bar( percentComplete )
					 }
			}, false);

			// // Download progress
			// xhr.addEventListener("progress", function(evt){
			// 		if (evt.lengthComputable) {
			// 				var percentComplete = evt.loaded / evt.total;
			// 				// Do something with download progress
			// 				console.log('percentComplete 2: ' + percentComplete);
			// 		}
			// }, false);

			return xhr;
	 },
  }).fail(function( oData ){
    if ( sAppStatus ) fttm_alerts( {'error': {'text': 'Ошибка соединения'}} )
  }).done(function( oData ){
    if ( sAppStatus ) fttm_alerts( oData )
  })

	// xhr.upload.onprogress = function(evt){
	//  percent = evt.loaded / evt.total;
	//  width = Math.ceil(percent * 100);
	//  bar.style.width = width + "%";
 // };
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

// fttm_progress_bar
function fttm_progress_bar ( intProgress ) {
	console.log('fttm_progress_bar: ' + intProgress)
	var oProgressBar = $(document).find('.fttm_progress')

	if ( intProgress < 1 ) oProgressBar.addClass('_active_')
	else oProgressBar.removeClass('_active_')

	oProgressBar.attr('aria-valuenow', intProgress * 100 )
	oProgressBar.css('width', intProgress * 100 + '%' )
}
// fttm_progress_bar x

// content_loader
function content_loader( oButton, oElem, iFrom, iLimit ) {
	// oButton - На что нажали
	// oElem - Куда загружаем
	// iFrom - Отчёт с
	// iLimit - Отчёт до

	// datas
	// content_loader_table
	// content_loader_to
	// content_loader_from
	// content_loader_limit

	var
		sAction = oButton.data().content_loader_action, // Класс
		sFrom = oButton.data().content_loader_form, // Что с ним
		sTo = oButton.data().content_loader_to,
		iFrom = oButton.data().content_loader_from,
		iLimit = oButton.data().content_loader_limit

	// Загружаем
	// content_download( asd 'ajax', false )

	// Добавляем

	// Заменяем данные в кнопке
}
// content_loader x

$(function(){
	// themes
	var prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)")
	if (prefersDarkScheme.matches) document.body.classList.add("dark-theme")
	else document.body.classList.remove("dark-theme")
	// themes x

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
