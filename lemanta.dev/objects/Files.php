<?php
  // Impera CMS: модуль страницы медиафайла на клиентской стороне.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT);

  // какой файл является шаблоном списка страниц медиафайлов на клиентской стороне (указываем без расширения),
  // какой файл является шаблоном страницы медиафайла на клиентской стороне (указываем без расширения)
  define("CLIENT_FILES_CLASS_TEMPLATE_FILE", "page.files");
  define("CLIENT_FILE_CLASS_TEMPLATE_FILE", "page.file");

  // =========================================================================
  // Класс ClientFiles (модуль страницы медиафайла на клиентской стороне)
  //
  // Использование этого класса происходит в результате переназначения класса
  // Files на данный класс во время загрузки модуля медиафайлов.
  // =========================================================================

  class ClientFiles extends Basic {

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_FILES_ON_PAGE_IN_CLIENT;

    public $file = null;

    // создание контента модуля ==============================================

    public function fetch (&$parent = null) {

      // читаем из входных параметров url страницы медиафайла, если нет, значит это список страниц медиафайлов
      $url = $this->request->getGetAsSentence('url');
      if (!empty($url)) {
        $this->fetch_item($url);
      } else {
        $this->fetch_list();
      }

      // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
      return TRUE;
    }

    // создание контента списка страниц медиафайлов ==========================

    private function fetch_list () {

      // читаем список страниц медиафайлов текущего раздела магазина на текущей странице
      $params = new stdClass;
      $params->sort = $this->settings->files_sort_method;
      $params->enabled = 1;
      $params->section = $this->now_in_section;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_files($items, $params);
      $this->db->fix_files_records($items);

      // создаем контент листания страниц
      $pages_num = $count / $this->items_per_page;
      $navigator = new ClientPagesNavigation($this);
      $navigator->make($pages_num);

      // устанавливаем заголовок страницы и мета информацию
      $title = trim($this->settings->files_main_title);
      $keywords = trim($this->settings->files_main_keywords);
      $description = trim($this->settings->files_main_description);
      $this->title = !empty($title) ? $title : 'Медиа файлы';
      $this->keywords = !empty($keywords) ? $keywords : 'файл, список, скачать';
      $this->description = !empty($description) ? $description : 'Список медиа файлов интернет-магазина.';

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef('files', $items);
      $this->smarty->assignByRef('items_count', $count);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->message);
      $this->smarty->fetchByTemplate($this, CLIENT_FILES_CLASS_TEMPLATE_FILE, 'files');
    }

    // создание контента страницы медиафайла =================================

    private function fetch_item ($url) {

      // читаем данные страницы медиафайла текущего раздела магазина из базы данных
      $params = new stdClass;
      $params->url = $url;
      $params->enabled = 1;
      $params->section = $this->now_in_section;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $this->db->get_file($this->file, $params);

      // если данные страницы медиафайла прочитаны, передаем данные в мета информацию страницы
      if (!empty($this->file)) {
        $this->title = &$this->file->meta_title;
        $this->keywords = &$this->file->meta_keywords;
        $this->description = &$this->file->meta_description;
        $this->seo_description = &$this->file->seo_description;

        // увеличиваем количество просмотров и передаем в базу данных
        $this->file->browsed++;
        $item = new stdClass;
        $item->file_id = $this->file->file_id;
        $item->browsed = $this->file->browsed;
        $this->db->update_file($item);
      }

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef('file', $this->file);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->message);
      $this->smarty->fetchByTemplate($this, CLIENT_FILE_CLASS_TEMPLATE_FILE, 'file');
    }
  }



  return;
?>