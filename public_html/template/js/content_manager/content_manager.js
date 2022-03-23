$(function(){
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
})
