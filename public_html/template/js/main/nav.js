$(function(){
  function block_nav() {
    // Style showers
    if ( typeof oParam.block_nav_fuller != 'undefined' ) {
      if ( oParam.block_nav_fuller ) {
        $(document).find('#block_nav_fuller').addClass('_full_')
        $(document).find('#block_nav').addClass('_full_')
      }
      else {
        $(document).find('#block_nav_fuller').removeClass('_full_')
        $(document).find('#block_nav').removeClass('_full_')
      }
    }
    else {
      $(document).find('#block_nav_fuller').addClass('_full_')
      $(document).find('#block_nav').addClass('_full_')
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

          // Подстановка в меню на мобиле
          if ( oElem.active ) block_nav_mobile_main( oElem )

          // Шаблон
          var oElemHtml = content_loader_elem_html( oElem, oTemplate )
          // Добавление
          $(document).find('#block_nav ._main').append( oElemHtml )
          // Вложенность
          if ( oElem.subs && oElem.active ) {
            $(document).find('#block_nav_mobile_subs').addClass('_showed_')
            $(document).find('#block_nav ._subs').addClass('_active_')

            $.each(oElem.subs, function( iPathSub, oElemSub ){
              // Подсвет
              if ( oElemSub.url == '/' + arrThisPath[2] + '/'  ) oElemSub.active = '_active_'
              if ( oElemSub.url == location.pathname  ) oElemSub.active = '_active_'

              // Подстановка в меню на мобиле
              if ( oElemSub.active ) block_nav_mobile_subs( oElemSub )

              // Шаблон
              var oElemSubHtml = content_loader_elem_html( oElemSub, oTemplate )
              // Добавление
              $(document).find('#block_nav ._subs').append( oElemSubHtml )
            })
          }
        })

        if ( $(document).find('#block_nav ._main a').length ) $(document).find('#block_nav_mobile_main').addClass('_showed_')
        else $(document).find('#block_nav_mobile_main').removeClass('_showed_')
      })
    })
  }
  block_nav()

  // $(document).find('#block_nav ._main li a').each(function(){
  //   // first level
  //   var arrThisPath = location.pathname.split('/')
  //   if ( $(this).attr('href') == '/' + arrThisPath[1] + '/'  ) $(this).addClass('_active_')
  // })

  // Раскрытие меню
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

  // Мобильная версия
  $(document).find('#block_nav_mobile_main').on('click', function(){
    $(this).toggleClass('_active_')
    $(document).find('#block_nav ._main').toggleClass('_mobile_active_')

    $(document).find('#block_nav ._subs').removeClass('_mobile_active_')
    $(document).find('#block_nav_mobile_subs').removeClass('_active_')

    if ( $(this).hasClass('_active_') ) $('body').addClass('_mobile_nav_active_')
    else $('body').removeClass('_mobile_nav_active_')
  })
  $(document).find('#block_nav_mobile_subs').on('click', function(){
    if ( ! $(this).hasClass('_showed_') ) return false

    $(this).toggleClass('_active_')
    $(document).find('#block_nav ._subs').toggleClass('_mobile_active_')

    $(document).find('#block_nav ._main').removeClass('_mobile_active_')
    $(document).find('#block_nav_mobile_main').removeClass('_active_')

    if ( $(this).hasClass('_active_') ) $('body').addClass('_mobile_nav_active_')
    else $('body').removeClass('_mobile_nav_active_')
  })
  $(document).find('#block_nav ._main a, #block_nav ._subs a, #block_nav_mobile_body_blocker'). on('click', function(){
    $(document).find('#block_nav ._main').removeClass('_mobile_active_')
    $(document).find('#block_nav_mobile_main').removeClass('_active_')
    $(document).find('#block_nav ._subs').removeClass('_mobile_active_')
    $(document).find('#block_nav_mobile_subs').removeClass('_active_')
    $('body').removeClass('_mobile_nav_active_')
  })

  function block_nav_mobile_main( oElem ){
    if ( typeof oElem != 'undefined' && oElem.active ) {
      $(document).find('#block_nav_mobile_main ._icon').addClass('__new')
      $(document).find('#block_nav_mobile_main ._icon ._new').html( oElem.icon )
      $(document).find('#block_nav_mobile_main ._name').addClass('__new')
      $(document).find('#block_nav_mobile_main ._name ._new').html( oElem.name )
    }
    else {
      $.each('#block_nav ._main a', function( iIndex, oElem ){
        if ( oElem.attr('href') == location.pathname ) {
          $(document).find('#block_nav_mobile_main ._icon').addClass('__new')
          $(document).find('#block_nav_mobile_main ._icon ._new').html( oElem.find('._icon').html() )
          $(document).find('#block_nav_mobile_main ._name').addClass('__new')
          $(document).find('#block_nav_mobile_main ._name ._new').html( oElem.find('._name').html() )
        }
      })
    }
  }
  function block_nav_mobile_subs( oElem ){
    if ( typeof oElem != 'undefined' && oElem.active ) {
      $(document).find('#block_nav_mobile_subs ._icon').addClass('__new')
      $(document).find('#block_nav_mobile_subs ._icon ._new').html( oElem.icon )
      $(document).find('#block_nav_mobile_subs ._name').addClass('__new')
      $(document).find('#block_nav_mobile_subs ._name ._new').html( oElem.name )
    }
    else {
      $.each('#block_nav ._subs a', function( iIndex, oElem ){
        if ( oElem.attr('href') == location.pathname ) {
          $(document).find('#block_nav_mobile_subs ._icon').addClass('__new')
          $(document).find('#block_nav_mobile_subs ._icon ._new').html( oElem.find('._icon').html() )
          $(document).find('#block_nav_mobile_subs ._name').addClass('__new')
          $(document).find('#block_nav_mobile_subs ._name ._new').html( oElem.find('._name').html() )
        }
      })
    }

    // if ( $(document).find('#block_nav ._subs a').length ) $(document).find('#block_nav_mobile_subs').addClass('_showed_')
    // else $(document).find('#block_nav_mobile_subs').removeClass('_showed_')
  }

  function block_nav_update(){
    block_nav_mobile_main()
    block_nav_mobile_subs()
  }
})
