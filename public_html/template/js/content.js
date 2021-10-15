// События
$(function(){
  // Отправка данных с формы
	$(document).find('form').on ('submit', function(){
		var
		oForm = $(this)
		oData = oForm.serializeArray()

		$.when(
			content_download( oData, 'json', true )
		).done( function( oData ){
			if ( ! oData.success ) return false

			// Если модель, то сохраняем в локали
			if ( oData.success.model ) {
				localStorage.setItem(oData.success.model, JSON.stringify(oData.success.data))
				// if ( localStorage.getItem('code') ) code = $.parseJSON( localStorage.getItem('code') )
			}

			// Если редирект
			if ( oData.success.location )
				setTimeout(function(){
				  window.location.replace( oData.success.location )
				}, 500)

			// Перезагружаем страницу если надо
			if( oForm.hasClass('reload_page') ) location.reload()

			// Добавляем в данные
			if ( oForm.hasClass('content_loader_form') ) content_loader( oForm, {}, oData.success.elems )
		})

		return false
	})
  // Сброс формы редактирования контента
  $(document).on('click', '.form_reset', function(){
		var oForm = $(this).parents('form')
    // Сбрасываем
		oForm[0].reset()
		oForm.find('[name=id]').val('')
		oForm.find('[type=submit]').html('<i class="fas fa-plus-square"></i> Добавить')

		// Снимаем выделение если выбран какой то элемент
		$(document).find('#content_loader_to .list-group-item').removeClass('_edit_')

		// Убираем старую анимацию
		oForm.removeClassWild("animate_*")

		// Играем анимацию отчистки
		setTimeout(function(){
			oForm.addClass('animate__animated animate__rubberBand')
		}, 100)
	})
  // Загрузка контента
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
		if ( oElem.data().form == 'del' ) {
      // Запрашиваем подтверждение
			if ( confirm('Подтвердите удаление') ) {
				if ( oElem.data().elem ) {
					// Анимация удаления
					oElem.parents( oElem.data().elem ).removeClassWild("animate_*").addClass('animate__animated ' + sAnimateClass)
					// Играем анимацию
					setTimeout(function(){
						oElem.parents( oElem.data().elem ).remove()
					}, 500)
				}
				else return fttm_alerts({'error':'Нет класса для удаления :( аттрибут data-elem'})
			}
			else return false
		}

		// Если это редактирование элемента
		if ( oElem.data().form == 'edit' ) {
			// Меняем запрос на вывод информации о элементе
			oData.form = 'show'
      // Помечаем элемент как редактируемый
			oElem.parents( oElem.data().elem ).addClass('_edit_').siblings().removeClass('_edit_')

			// Получаем объект элемента
			$.when(
			  content_download( oData, 'json' )
			).then( function( oData ){
				// Определяем форму редактирования
				oEditForm = $(document).find('[data-content_download_edit_type="' + oData.type + '"]')

				// Добавляем данные в форму редактирования
				for (var key in oData ) {
					var oInput = oEditForm.find('[name="' + key + '"]')
					if ( oInput.hasClass('select') ) oInput.find('[value="' + oData[key] + '"]').prop('selected', true)
					oInput.val( oData[key] )
				}
				// Обнавляем данные формы, инфа про сохранение
				oEditForm.find('[type=submit]').html('<i class="fas fa-pen-square"></i> Сохранить')

				// Анимация добавление данных в форму
				oEditForm.removeClassWild("animate_*")

				// Играем анимацию
				setTimeout(function(){
					oEditForm.addClass('animate__animated ' + sAnimateClass)
				}, 100)

				// Раскрываем форму редактирования, если закрыта
				oCollapse = oEditForm.parents('.accordion')
				if ( oCollapse.find('.accordion-button').hasClass('collapsed') ) oCollapse.find('.accordion-button').click()
			})

			return false
		}

		$.when(
		  content_download( oData, 'json' )
		).then( function( oData ){
			// fttm_alerts( oData )
		})
	})
  // Догрузка элементов
  $(document).on('click', '.content_loader', function(){
    content_loader( $(this) )
  })
  // content_manager | Работа с несколькими элементами
	$(document).on('click', '.content_manager_switch', function(){
		var oContentManagerButtons = $(document).find('.content_manager_buttons')

		$(this).toggleClass('_active_')
		$(this).parents('.list-group-item').toggleClass('content_manager_select')

		if ( $(document).find('#content_loader_to .content_manager_select').length ) {
			// Анимация показа активных кнопок
			if ( oContentManagerButtons.hasClass('_hide_') ) {
				// Анимация
				oContentManagerButtons.removeClassWild("animate_*").addClass('animate__animated animate__backInRight')
				// Играем анимацию
				setTimeout(function(){
					oContentManagerButtons.removeClass('_hide_')
					// oContentManagerButtons
				}, 500)
			}
		}
		// Анимация скрытия
		else {
			// Анимация
			oContentManagerButtons.removeClassWild("animate_*").addClass('animate__animated animate__backOutRight')
			// Играем анимацию
			setTimeout(function(){
				// oContentManagerButtons
				oContentManagerButtons.addClass('_hide_')
			}, 500)
		}
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

						// Анимация скрытия кнопок управления
						oContentManagerButtons.removeClassWild("animate_*").addClass('animate__animated animate__backOutRight')
						// Играем анимацию
						setTimeout(function(){
							// oContentManagerButtons
							oContentManagerButtons.addClass('_hide_')
						}, 500)
					}, 500)
				})
			})
		}
	})
})

// Функции
// content_download
function content_download( oData, oReturnType, sAppStatus ) {
  // oData - Какие данные запросить
  // oReturnType - Возвращяемый тип данных
  // sAppStatus - Показывать статусы, по умолчанию да

  // Отображение статуса
  if ( typeof sAppStatus === 'undefined' ) sAppStatus = true
  // Тип возвращяемых данных
  if ( typeof oReturnType === 'undefined' ) oReturnType = 'html'

  // Получаем данные
  return $.ajax({
    url: oData.site_url ? oData.site_url : '',
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

// content_loader
function content_loader_init(){
	// content_loader()
}
function content_loader( oBlockElems, oOptions, oData ) {
	if ( typeof oOptions === "undefined" ) oOptions = {}
	if ( typeof oData === "undefined" ) oData = {}
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

	// oBlockElems - Блок с элементами
	// oOptions - Общие параметры
	oOptions.action = oBlockElems.attr('data-content_loader_action') ? oBlockElems.attr('data-content_loader_action') : oOptions.action
	oOptions.form = oBlockElems.attr('data-content_loader_form') ? oBlockElems.attr('data-content_loader_form') : oOptions.table
	oOptions.to = oBlockElems.attr('data-content_loader_to') ? oBlockElems.attr('data-content_loader_to') : oOptions.to
	oOptions.from = oBlockElems.attr('data-content_loader_from') ? oBlockElems.attr('data-content_loader_from') : oOptions.from
	oOptions.limit = oBlockElems.attr('data-content_loader_limit') ? oBlockElems.attr('data-content_loader_limit') : oOptions.limit
	oOptions.template = oBlockElems.attr('data-content_loader_template') ? oBlockElems.attr('data-content_loader_template') : oOptions.template
	oOptions.position = oBlockElems.attr('data-content_loader_position') ? oBlockElems.attr('data-content_loader_position') : oOptions.position


	// Собираем данные
	var
		sAction = oOptions.action, // Класс
		sForm = oOptions.form, // Что с ним
		sTo = oOptions.to,
		iFrom = oOptions.from,
		iLimit = oOptions.limit,
		oTemplate = $(document).find(oOptions.template),
		iPosition = oOptions.position

	// Если уже есть данные, 1 элемент
	if ( oData.id ) {
		if ( oTemplate ) {
			var oActiveElem = $(document).find( sTo ).find('[data-content_loader_item_id="' + oData.id + '"]')
			// Элемент уже есть, заменяем
			if ( oActiveElem.length ) {
				oActiveElem.after( content_loader_template( oTemplate, oData ) )
				oActiveElem.remove()
				// Чистим форму, чтобы не затереть случайно данные

				oButton.find('[name=id]').val('')
				oButton.find('[type=submit]').html('<i class="fas fa-plus-square"></i> Добавить')

				// Анимация Отчистки
				oButton.removeClassWild("animate_*")

				// Играем анимацию
				setTimeout(function(){
					oButton.addClass('animate__animated animate__rubberBand')
				}, 100)
			}
			// Элемента нет, добавялем
			else {
				// Добавляем новый
				setTimeout(function(){
					if ( iPosition ) $(document).find( sTo ).append( content_loader_template( oTemplate, oData ) )
					else $(document).find( sTo ).prepend( content_loader_template( oTemplate, oData ) )
				}, 100)
			}
		}
		else {
			fttm_alerts({'alert':'Шаблон не найден'})
		}
	}
	else {
		var oData = {
			'action': sAction,
			'form': sForm,
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
