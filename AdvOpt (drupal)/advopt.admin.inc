<?php
/**
 * Пространство admin для модуля AdvOpt
 */

/**
 * Администрирование AdvOpt; Список страниц с переопределённой метаинформацией
 */
function advopt_uri_overview() {
    $header = array('URI', 'Title', 'Действия');
    $urititles = db_select('advopt_uri', 'n')
        ->fields('n', array('uri', 'title'))
        ->execute();
    $adrows = array();
    foreach ($urititles as $urititle) {
        $adrows[] = array($urititle->uri, $urititle->title, '<a href="/admin/config/search/advopt/'.md5($urititle->uri).'/change-uri">Редактировать</a> <a href="/admin/config/search/advopt/'.md5($urititle->uri).'/delete-uri">Удалить</a>');
         
    };
    return theme('table', array('header' => $header, 'rows' => $adrows, 'empty' => 'Не создано ни одной записи для страниц'));
};

/**
 * Форма создания метазаписей страниц
 */
function advopt_uri_add($form, &$form_state) {
    $form['uri'] = array(
        '#type' => 'textfield',
        '#title' => 'Относительная ссылка на страницу',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 300,
        '#description' =>  'Ссылка на страницу, например node/123 или catalog/pants/black',
    );
    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => 'Заголовок страницы',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 260,
        '#description' =>  'Заголовок страницы не может содержать более 260 символов по требованиям поисковой системы Google',
    );
    $form['description'] = array(
        '#type' => 'textarea',
        '#title' => 'Блок Description',
    );
    $form['keywords'] = array(
        '#type' => 'textarea',
        '#title' => 'Блок Keywords',
    );

    $form['header'] = array(
        '#type' => 'textfield',
        '#title' => 'H1',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 260,
        '#description' =>  'Заголовок контента не может содержать более 260 символов.
            Если заголовок не изменяется, очистите кеш сайта.',
    );
    $form['copyright'] = array(
        '#type' => 'textfield',
        '#title' => 'Copyright',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 260,
        '#description' => 'Если необходимо скрыть, введите в это поле тег &lt;disable&gt;'
    );
    $form['author'] = array(
        '#type' => 'textfield',
        '#title' => 'Author',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 260,
        '#description' => 'Если необходимо скрыть, введите в это поле тег &lt;disable&gt;'
    );
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => 'Добавить запись',
    );
    $form['landing'] = array(
        '#type' => 'textarea',
        '#title' => 'Информация для перелинковки',
        '#description' => 'Добавляйте новую позицию перелинковки с новой строки.<br/>
            Начните строку с символов || если строка является описанием страницы.<br/>
            Для указания текста ссылки используйте конструкцию #Текст ссылки#.<br/>
            Вы можете добавлять к ссылкам приставки, например #Модуль адвантики {%1%}# выведет "Модуль адвантики в Хабаровске", если первая приставка равна "В Хабаровске".',
        '#title_display' => 'before',
    );
    $form['variable_1'] = array(
        '#type' => 'textfield',
        '#title' => 'Приставка для перелинковки 1',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 70,
        '#description' =>  'Приставка для перелинковки 1',
    );
    $form['variable_2'] = array(
        '#type' => 'textfield',
        '#title' => 'Приставка для перелинковки 2',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 70,
        '#description' =>  'Приставка для перелинковки 2',
    );
    $form['variable_3'] = array(
        '#type' => 'textfield',
        '#title' => 'Приставка для перелинковки 3',
        '#default_value' => '',
        '#size' => 40,
        '#maxlength' => 70,
        '#description' =>  'Приставка для перелинковки 3',
    );
    return $form;
};

/**
 * Реализация form_validate() для advopt_titles_uri_add
 */
function advopt_uri_add_validate($form, &$form_state){
    $newuri = $form_state['values']['uri'];
    $obj = get_uri_by_hash(md5($newuri));
    if ($obj != false) {
        form_set_error('', 'В базе данных уже содержится метаинформация для данного URI.');
    }
    if (strlen($form_state['values']['title']) < 5){
        form_set_error('', 'Одумайтесь. Вы ввели менее пяти символов в заголовке. Поисковой системе это очень не понравится!');
    }
    if($form_state['values']['uri'] == '<front>') {
        $form_state['values']['uri'] = '';
    }
}

/**
 * Добавление/сохранение метаданных
 */
function advopt_uri_add_submit($form, &$form_state){
    $advopt_uri = array(
        'uri' => $form_state['values']['uri'],
        'title' => $form_state['values']['title'],
        'description' => $form_state['values']['description'],
        'keywords' => $form_state['values']['keywords'],
        'header' => $form_state['values']['header'],
        'copyright' => $form_state['values']['copyright'],
        'author' => $form_state['values']['author'],
        'landing' => $form_state['values']['landing'],
        'variable_1' => $form_state['values']['variable_1'],
        'variable_2' => $form_state['values']['variable_2'],
        'variable_3' => $form_state['values']['variable_3'],
    );
    // добавление
    drupal_write_record('advopt_uri', $advopt_uri);
    drupal_set_message('Добавлена запись для URI '.$advopt_uri['uri']);
 
    drupal_goto('admin/config/search/advopt/list');
}

/**
 * Форма удаления метазаписей
 */
function advopt_uri_delete($form, &$form_state, $urihash) {
    $obj = get_uri_by_hash($urihash);
    if ($obj != false) {
        $form['instance'] = array('#type' => 'value', '#value' => $obj);
        $title = 'Вы уверены, что хотите удалить запись для URI <b>'.$obj->uri.'</b>?';
        return confirm_form(
        $form,
        $title,
        'admin/config/search/advopt/list',
        'Вы хотите удалить метаданные для страницы, расположенной по адресу <b>'.$obj->uri.'</b>.<br/>
        Это означает, что на данной странице после удаления будет использоваться стандартный вывод метаданных.<br/>
        Вы уверены, что хотите удалить данную запись?'
    );
    }
    else {
        $all = db_select('advopt_uri', 'n')
            ->fields('n')
            ->execute()
            ->fetchAll();
        $result = false;
        foreach ($all as $item){
            $result .= ' '.md5($item->uri);
        }
        drupal_set_message('Невозможно найти запись.', 'error');
    }
}

/**
 * Удаление записей
 */
function advopt_uri_delete_submit($form, &$form_state) {
  $obj = $form_state['values']['instance'];
  if ($obj != false) {
      delete_uri($obj);
      drupal_set_message('Запись для uri <b>'.$obj->uri.'</b> успешно удалена.');
  }
  else {
      drupal_set_message('Невозможно удалить запись для uri <b>'.$obj->uri.'</b>. Возможно, что она уже была удалена', 'error');
  }
  $form_state['redirect'] = 'admin/config/search/advopt/list';
}

/*
 * Форма редактирования записей
 */
function advopt_uri_change($form, &$form_state, $urihash) {
    $obj = get_uri_by_hash($urihash);
    if ($obj != false) {
        $form['uri'] = array(
            '#type' => 'hidden',
            '#default_value' => $urihash
        );
        $form['title'] = array(
            '#type' => 'textfield',
            '#title' => 'Заголовок страницы',
            '#default_value' => $obj->title,
            '#size' => 40,
            '#maxlength' => 260,
            '#description' =>  'Заголовок страницы не может содержать более 70 символов по требованиям поисковой системы Google',
        );
        $form['description'] = array(
            '#type' => 'textarea',
            '#title' => 'Блок Description',
            '#default_value' => $obj->description,
        );
        $form['keywords'] = array(
            '#type' => 'textarea',
            '#title' => 'Блок Keywords',
            '#default_value' => $obj->keywords,
        );
        $form['header'] = array(
            '#type' => 'textfield',
            '#title' => 'H1',
            '#default_value' => $obj->header,
            '#size' => 40,
            '#maxlength' => 260,
            '#description' =>  'Заголовок контента не может содержать более 70 символов.
                Если заголовок не изменяется, очистите кеш сайта.',
        );
        $form['copyright'] = array(
            '#type' => 'textfield',
            '#title' => 'Copyright',
            '#default_value' => $obj->copyright,
            '#size' => 40,
            '#maxlength' => 260,
            '#description' => 'Если необходимо скрыть, введите в это поле тег &lt;disable&gt;'
        );
        $form['author'] = array(
            '#type' => 'textfield',
            '#title' => 'Author',
            '#default_value' => $obj->author,
            '#size' => 40,
            '#maxlength' => 260,
            '#description' => 'Если необходимо скрыть, введите в это поле тег &lt;disable&gt;'
        );
        $form['landing'] = array(
            '#type' => 'textarea',
            '#title' => 'Информация для перелинковки',
            '#description' => 'Добавляйте новую позицию перелинковки с новой строки.<br/>
                Начните строку с символов || если строка является описанием страницы.<br/>
                Для указания текста ссылки используйте конструкцию #Текст ссылки#.<br/>
                Вы можете добавлять к ссылкам приставки, например #Модуль адвантики {%1%}# выведет "Модуль адвантики в Хабаровске", если первая приставка равна "В Хабаровске".',
            '#title_display' => 'before',
            '#default_value' => $obj->landing,
        );
        $form['variable_1'] = array(
            '#type' => 'textfield',
            '#title' => 'Приставка для перелинковки 1',
            '#default_value' => $obj->variable_1,
            '#size' => 40,
            '#maxlength' => 70,
            '#description' =>  'Приставка для перелинковки 1',
        );
        $form['variable_2'] = array(
            '#type' => 'textfield',
            '#title' => 'Приставка для перелинковки 2',
            '#default_value' => $obj->variable_2,
            '#size' => 40,
            '#maxlength' => 70,
            '#description' =>  'Приставка для перелинковки 2',
        );
        $form['variable_3'] = array(
            '#type' => 'textfield',
            '#title' => 'Приставка для перелинковки 3',
            '#default_value' => $obj->variable_3,
            '#size' => 40,
            '#maxlength' => 70,
            '#description' =>  'Приставка для перелинковки 3',
        );
        $form['actions'] = array('#type' => 'actions');
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => 'Сохранить',
        );
        return $form;
    }
}

/**
 * Cохранение метаданных
 */
function advopt_uri_change_submit($form, &$form_state){
    $advopt_uri = array(
        'title' => $form_state['values']['title'],
        'description' => $form_state['values']['description'],
        'keywords' => $form_state['values']['keywords'],
        'header' => $form_state['values']['header'],
        'copyright' => $form_state['values']['copyright'],
        'author' => $form_state['values']['author'],
        'landing' => $form_state['values']['landing'],
        'variable_1' => $form_state['values']['variable_1'],
        'variable_2' => $form_state['values']['variable_2'],
        'variable_3' => $form_state['values']['variable_3'],
    );
    $obj = get_uri_by_hash($form_state['values']['uri']);
    if ($obj != false) {
        db_update('advopt_uri')
            ->fields($advopt_uri)
            ->condition('aid', $obj->aid)
            ->execute();
        drupal_set_message('Сохранена запись для URI '.$obj->uri);
    }
    drupal_goto('admin/config/search/advopt/list');
}


/**
 * Изменение общих для сайта copyright и author
 */
function advopt_default_copyright_author ($form, &$form_state){

    $default_copyright = (variable_get('default_meta_copyright')) ? variable_get('default_meta_copyright') : '';
    $default_author = (variable_get('default_meta_author')) ? variable_get('default_meta_author') : '';

    $form['copyright'] = array(
        '#type' => 'textfield',
        '#title' => 'Copyright',
        '#default_value' => $default_copyright,
        '#size' => 40,
        '#maxlength' => 260,
        '#description' => 'Если необходимо скрыть, оставьте поле пустым, для любого URL можно переопределить это значение.'
    );
    $form['author'] = array(
        '#type' => 'textfield',
        '#title' => 'Author',
        '#default_value' => $default_author,
        '#size' => 40,
        '#maxlength' => 260,
        '#description' => 'Если необходимо скрыть, оставьте поле пустым, для любого URL можно переопределить это значение.'
    );
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => 'Сохранить',
    );
    return $form;

}

function advopt_default_copyright_author_submit($form, &$form_state){
    variable_set('default_meta_copyright', $form_state['values']['copyright']);
    variable_set('default_meta_author', $form_state['values']['author']);
    drupal_goto('admin/config/search/advopt/list');
}

/*
 * Полный экспорт данных
 */
function advopt_full_export(){
    $all = db_select('advopt_uri', 'n')
        ->fields('n')
        ->execute()
        ->fetchAll();
    $result = array();
    foreach($all as $object) {
        $result[] = array(
            'uri' => $object->uri,
            'title' => $object->title,
            'description' => $object->description,
            'keywords' => $object->keywords,
            'copyright' => $object->copyright,
            'author' => $object->author,
            'header' => $object->header,
            'landing' => $object->landing,
            'variable_1' => $object->variable_1,
            'variable_2' => $object->variable_2,
            'variable_3' => $object->variable_3,
        );
    }
    header ("Content-Type: application/json");
    header ("Accept-Ranges: bytes");
    header ("Content-Disposition: attachment; filename=advopt_export.json");
    print json_encode($result);
}

