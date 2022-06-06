$(function(){
  function block_nav() {
    // Style showers
    if ( oParam.block_nav_fuller ) {
      $(document).find('#block_nav_fuller').addClass('_full_')
      $(document).find('#block_nav').addClass('_full_')
    }
    else {
      $(document).find('#block_nav_fuller').removeClass('_full_')
      $(document).find('#block_nav').removeClass('_full_')
    }
    // load menu
    $.when(
      content_download( {
        'app':'app',
        'action':'navs',
        'form':'show',
      }, 'json', false )
    ).then( function( oData ){
      $.get('/core/templates/htms/nav.htm')
      .fail(function(data){
        app_status({'error': 'Шаблон не найден: ' + sTemplatePath})
      })
      .done(function(data){
        var
          oTemplate = $('<div/>').html(data),
          arrThisPath = location.pathname.split('/')

        $(document).find('#block_nav ._subs').removeClass('_active_')

        $.each(oData, function( iPath, oElem ){
          // Подсвет
          if ( oElem.url == '/' + arrThisPath[1] + '/'  ) oElem.active = '_active_'
          if ( oElem.url == location.pathname  ) oElem.active = '_active_'
          // Шаблон
          var oElemHtml = content_loader_elem_html( oElem, oTemplate )
          // Добавление
          $(document).find('#block_nav ._main').append( oElemHtml )
          // Вложенность
          if ( oElem.subs && oElem.active ) {
            $(document).find('#block_nav ._subs').addClass('_active_')

            $.each(oElem.subs, function( iPathSub, oElemSub ){
              // Подсвет
              if ( oElemSub.url == '/' + arrThisPath[2] + '/'  ) oElemSub.active = '_active_'
              if ( oElemSub.url == location.pathname  ) oElemSub.active = '_active_'
              // Шаблон
              var oElemSubHtml = content_loader_elem_html( oElemSub, oTemplate )
              // Добавление
              $(document).find('#block_nav ._subs').append( oElemSubHtml )
            })
          }
        })
      })
    })
  }
  block_nav()

  // $(document).find('#block_nav ._main li a').each(function(){
  //   // first level
  //   var arrThisPath = location.pathname.split('/')
  //   if ( $(this).attr('href') == '/' + arrThisPath[1] + '/'  ) $(this).addClass('_active_')
  // })

  $(document).find('#block_nav_fuller ._btn').on('click', function(){
    if ( $(document).find('#block_nav').hasClass('_full_') ) {
      $(document).find('#block_nav_fuller').removeClass('_full_')
      $(document).find('#block_nav').removeClass('_full_')
      oParam.block_nav_fuller = false
    }
    else {
      $(document).find('#block_nav_fuller').addClass('_full_')
      $(document).find('#block_nav').addClass('_full_')
      oParam.block_nav_fuller = true
    }
    oParam.save()
  })
})
