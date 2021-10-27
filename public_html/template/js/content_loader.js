// content_loader
function content_loader_init(){
	// content_loader()

  // Догрузка элементов
  $(document).on('click', '.content_loader', function(){
    content_loader( $(this) )
  })
}
function content_loader( oBlockElems, oOptions, oData ) {
	if ( typeof oOptions === "undefined" ) oOptions = {}
	if ( typeof oData === "undefined" ) oData = {}
	// oButton - На что нажали
	oButton = oBlockElems
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
		iFrom = parseInt(oOptions.from),
		iLimit = parseInt(oOptions.limit),
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
content_loader_init()
// content_loader x
