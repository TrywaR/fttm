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
    if ( sAppStatus ) app_status( {'error': 'Ошибка соединения'} )
  }).done(function( oData ){
    if ( sAppStatus ) app_status( oData )
  })
}
// content_download x

function app_status( oData ){
	console.log( oData )
}


$(function(){
	$(document).on('click', '.content_download', function(){
		var oData = {
			'action' : $(this).data().action,
			'form' : $(this).data().form,
			'id' : $(this).data().id
		}

		if ( $(this).data().form == 'del' ) $(this).parents('.col').remove()

		$.when(
		  content_download( oData, 'json' )
		).then( function( oData ){
			app_status(oData)
		})
	})

	// $("[data-fancybox]").fancybox({
	// 	// Options will go here
	// })

	// post
	$(document).find('form').on ('submit', function(){
		var oData = $(this).serializeArray()

		$.when(
		  content_download( oData, 'json' )
		).then( function( oData ){
			app_status(oData)
		})

		return false
	})
	// post x
})
