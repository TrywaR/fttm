oParam = {}
oParam.ajax_salt = {
	'app': 'app'
}
oParam.site_url = '/'

// Чистка классов по маске, для анимаций
// $("div").removeClassWild("status_*");
$.fn.removeClassWild = function(mask) {
  return this.removeClass(function(index, cls) {
      var re = mask.replace(/\*/g, '\\S+')
      return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ')
  })
}

// content_manager
// $.fn.content_manager_action = function() {
// }
// $.fn.content_manager_items = function() {
// }
// content_manager x

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

// content_loader
function content_loader( oButton, oData, oElem, iFrom, iLimit, oTemplate, iPosition ) {
	// oButton - На что нажали
	// oData - Что загружаем
	// oElem - Куда загружаем
	// iFrom - Отчёт с
	// iLimit - Отчёт до
	// oTemplate - Обьект шаблона
	// iPosition - Куда добавлять, в начало или конец, 0 начало

	// datas
	// content_loader_table
	// content_loader_to
	// content_loader_from
	// content_loader_limit
	// content_loader_template
	// content_loader_position

	// Собираем данные
	var
		sAction = oButton.attr('data-content_loader_action'), // Класс
		sFrom = oButton.attr('data-content_loader_form'), // Что с ним
		sTo = oElem ? oElem : oButton.attr('data-content_loader_to'),
		iFrom = iFrom ? parseInt(iFrom) : parseInt(oButton.attr('data-content_loader_from')),
		iLimit = iLimit ? parseInt(iLimit) : parseInt(oButton.attr('data-content_loader_limit')),
		oTemplate = oTemplate ? oTemplate : $(document).find(oButton.data().content_loader_template),
		iPosition = iPosition ? iPosition : parseInt(oButton.data().content_loader_position)

	if ( oData ) {
		if ( oTemplate ) {
			// Выводим
			setTimeout(function(){
				if ( iPosition ) $(document).find( sTo ).append( content_loader_template( oTemplate, oData ) )
				else $(document).find( sTo ).prepend( content_loader_template( oTemplate, oData ) )
			}, 100)
		}
		else {
			fttm_alerts({'alert':'Шаблон не найден'})
		}
	}
	else {
		var oData = {
			'action': sAction,
			'form': sFrom,
			'from': iFrom,
			'limit': iLimit
		}

		// Загружаем
		$.when(
		  content_download( oData, 'json', false )
		).then( function( oData ){
			// Если есть данные
			if ( oData.length ) {
				// Собираем шаблон
				if ( oTemplate ) {
					// Добавляем
					$.each(oData, function(iIndex, oElem){
						// Выводим
						var oData = $(this)[0]
						setTimeout(function(){
							if ( iPosition ) $(document).find( sTo ).append( content_loader_template( oTemplate, oData ) )
							else $(document).find( sTo ).prepend( content_loader_template( oTemplate, oData ) )
						}, ( iIndex * 100 ))
					})
				}
				else {
					fttm_alerts({'alert':'Шаблон не найден'})
				}

				// Если элементы закончились
				if ( iLimit > oData.length ) oButton.remove()
				// Если нет, заменяем данные в кнопке
				else oButton.attr('data-content_loader_from', iFrom + iLimit )
			}
			// нет, убираем кнопку
			else {
				oButton.remove()
			}
		})
	}
}
function content_loader_template( oTemplate, oData ){
	// oTemplate - объект шаблона
	// oData - данные для шаблона

	var
	oElemHtml = $(oTemplate),
	replaceKeyArray = [],
	replaceValueArray = [],
	sElemHtml = oElemHtml[0].innerHTML

	for (var key in oData ) {
		replaceKeyArray.push( key )
		replaceValueArray.push( oData[key] )
	}
	for(var i = 0; i < replaceKeyArray.length; i++) sElemHtml = sElemHtml.split('{{' + replaceKeyArray[i] + '}}').join(replaceValueArray[i])

	return sElemHtml
}
// content_loader x

$(function(){
	// themes
	var prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)")
	if (prefersDarkScheme.matches) document.body.classList.add("dark-theme")
	else document.body.classList.remove("dark-theme")
	// themes x

	// content
	$(document).on('click', '.content_download', function(){
		// Параметры
		var
			oElem = $(this),
			sAnimateClass = oElem.data().animate_class ? oElem.data().animate_class : 'animate__zoomOut',
			oData = {
				'action' : $(this).data().action,
				'form' : $(this).data().form,
				'id' : $(this).data().id
			}

		// Если это удаление элемента
		if ( oElem.data().form == 'del' )
			if ( confirm('Подтвердите удаление') ) {
				if ( oElem.data().elem ) {
					oElem.parents( oElem.data().elem ).removeClassWild("animate_*").addClass('animate__animated ' + sAnimateClass)
					// Играем анимацию
					setTimeout(function(){
						oElem.parents( oElem.data().elem ).remove()
					}, 500)
				}
				else return fttm_alerts({'error':'Нет класса для удаления :( аттрибут data-elem'})
			}
			else return false

		$.when(
		  content_download( oData, 'json' )
		).then( function( oData ){
			fttm_alerts( oData )
		})
	})
	// content x

	// content_loader
	$(document).on('click', '.content_loader', function(){
		content_loader( $(this) )
	})
	// content_loader x

	// content_manager
	$(document).on('click', '.content_manager_switch', function(){
		$(this).toggleClass('_active_')
		$(this).parents('.list-group-item').toggleClass('content_manager_select')
		return false
	})
	$(document).on('click', '.content_manager_buttons .del', function(){
		if ( confirm('Вы действительно хотите удалить всё выбранное к херам?') ) {
			var
				oContentManagerButtons = $(this).parents('.content_manager_buttons'),
				oContentManagerBlock = oContentManagerButtons.data().content_manager_block,
				oContentManagerAction = oContentManagerButtons.data().content_manager_action,
				oContentManagerItem = oContentManagerButtons.data().content_manager_item,
				sAnimateClass = oContentManagerButtons.data().animate_class ? oContentManagerButtons.data().animate_class : 'animate__zoomOut',
				oData = {
					'action' : oContentManagerAction,
					'form' : 'del'
				}

			$(document).find(oContentManagerBlock + ' ' + oContentManagerItem + '.content_manager_select').each(function(){
				var oElem = $(this)
				oData.id = oElem.data().content_manager_item_id

				$.when(
				  content_download( oData, 'json' )
				).then( function( oData ){
					oElem.removeClassWild("animate_*").addClass('animate__animated ' + sAnimateClass)
					// Играем анимацию
					setTimeout(function(){
						oElem.remove()
					}, 500)
				})
			})
		}
	})
	// content_manager x

	// $("[data-fancybox]").fancybox({
	// 	// Options will go here
	// })

	// bootstrap
	var scrollSpys = new bootstrap.ScrollSpy($('#block_version'), {
	  target: '#list-example'
	})
	// bootstrap x

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

			// Добавляем в данные
			if ( oForm.hasClass('content_loader_form') ) content_loader( oForm, oData )
		})

		return false
	})
	// post x
})
