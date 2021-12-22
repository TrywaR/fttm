# content_download | Загрузка содержимого по клику

## Настройки кнопки загрузки
- У элемента который вызывает загрузку должен быть класс `.content_download`
- Атрибуты `data-action`, `data-form`, `data-id` для определения загружаемого контента, если в `form` указано `del` элемент удаляется, если `edit` данные загружаются в форму для редактирования
- Проигрываемая анимация в `data-animate_class`
- Атрибут родительского блока элемента в `data-elem` который будет удален при удалении элемента, или получит класс `._edit_` при редактировании

Таким образом кнопка редактирования элемента может выглядить так
```
<a href="#" class="btn content_download" data-id="{{id}}" data-action="times" data-elem=".list-group-item" data-form="edit" data-animate_class="animate__flipInY">
  <i class="fas fa-pen-square"></i>
</a>
```
Форма редактирования должна иметь например такие атрибуты
```
<form
  class="content_loader_form"
  action=""
  method="post"
  data-content_download_edit_type="0"
  data-content_loader_to="#content_loader_to"
  data-content_loader_template=".template_projects"
>
```
и поле с id элемента соответственно

Для успешного редактирования сервер должен вернуть `success - elems` с отредактированным элементом

## Настройки формы редактирования
- Форма должна иметь атрибут `data-content_download_edit_type` где указан тип редактируемых данных (У элемента в базе значение `type` )
- `.form_reset` Кнопка очистки данных в форме, так же убирает классы у редактируемых элементов `._edit_`

## Блок с элементами
- `#content_loader_to`
- Чтобы элементы в списке, при редактировании отображали анимацию, блоку с атрибутом `data-elem` надо добавить класс `progress_block` а вконце встраимого блока, `.card` или `.list-group-item` добавить анимацию, например
```
<div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
</div>
```

___

# content_loader | Работа со списком элементов
- Догрузка по клику
- Так же заменяет данные у уже имеющихся элементов

## Кнопка догрузки
- Класс `.content_loader`
- Атрибуты
```
content_loader( oButton, oData, oElem, iFrom, iLimit, oTemplate, iPosition )
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
```

- Нужно или передавать кнопку с атрибутами `data` или отдельно все данные в функцию `content_loader`
### Пример рабочий кнопки
```
<button type="button" class="btn btn-primary btn-sm content_loader"
  data-content_loader_action="moneys"
  data-content_loader_form="show"
  data-content_loader_to="#content_loader_to"
  data-content_loader_from="10"
  data-content_loader_limit="10"
  data-content_loader_template=".template_money"
  data-content_loader_position="1">Load</button>
```

## Форма редактирующая элементы
- Класс `.content_loader_form`
- Атрибуты
```
data-content_download_edit_type="0"
```

___

# content_manager | Работа с несколькими элементами
## Блок с элементами управления
- `.content_manager_buttons`
- У блока прописаны атрибуты чтобы понять с какими элементами он работает
```
data-content_manager_action="moneys"
data-content_manager_block="#content_loader_to"
data-content_manager_item=".list-group-item"
```
- Получает `._hide_` если элементов нет
- Элемент пока топорный
```
$(this).parents('.list-group-item').toggleClass('content_manager_select')
```
- `.content_loader_to` со списком элементов тоже топорный

## Выбор элемента
- у кнопки для выбора элемента должен быть класс `.content_manager_switch`, при нажатии отрабатывает показ блока управления `.content_manager_buttons`
- `.content_manager_switch` Получает `._active_` если выбран
- Сам элемент (Его обёртка) получает класс `.content_manager_select` по нему и смотрится с какими элементами работаем

## Массовое удаление
- в `.content_manager_buttons` при нажатии `.del`
