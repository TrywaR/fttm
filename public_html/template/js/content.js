// События
$(function(){
  // Отправка данных с формы
	$(document).find('form:not(.__no_ajax)').on ('submit', function(){
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
		$(document).find('#content_loader_to ._edit_').removeClass('_edit_')

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
			  content_download( oData, 'json', false )
			).then( function( oData ){
				// Определяем форму редактирования
				// if ( oData.type ) oEditForm = $(document).find('[data-content_download_edit_type="' + oData.type + '"]')
				// else oEditForm = $(document).find('[data-content_download_edit_type="0"]')
				$(document).find('form').each(function(){
					if ( ('.' + $(this).data().content_download_edit_type).indexOf( oData.type ) > 0 ) {
						return oEditForm = $(this)
					}
				})

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
