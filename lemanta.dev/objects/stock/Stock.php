<?php
  // Impera CMS: модуль страницы склада на клиентской стороне.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);

  // какой файл является шаблоном страницы склада на клиентской стороне (указываем без расширения)
  define("CLIENT_STOCK_CLASS_TEMPLATE_FILE", "page.stock");

  // =========================================================================
  // Модуль страницы склада на клиентской стороне
  // =========================================================================

  class ClientStock extends Basic {

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_STOCKS_ON_PAGE_IN_CLIENT;

    public $stock = null;

    // создание контента модуля ==============================================

    public function fetch (&$parent = null) {

      // читаем из входных параметров url страницы склада, если нет, значит это список страниц складов
      $url = $this->request->getGetAsSentence('url');

      // читаем данные страницы склада из базы данных
      $params = new stdClass;
      $params->url = $url;
      $params->enabled = 1;
      $params->visible = 1;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $this->db->stocks->one($this->stock, $params);

      // если данные страницы склада прочитаны, передаем данные в мета информацию страницы
      if (!empty($this->stock)) {
        $this->title = &$this->stock->meta_title;
        $this->keywords = &$this->stock->meta_keywords;
        $this->description = &$this->stock->meta_description;
        $this->seo_description = &$this->stock->seo_description;

        // увеличиваем количество просмотров и передаем в базу данных
        $this->stock->browsed++;
        $item = new stdClass;
        $item->stock_id = $this->stock->stock_id;
        $item->browsed = $this->stock->browsed;
        $this->db->stocks->update($item);
      }

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_STOCK, $this->stock);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->message);
      $this->smarty->fetchByTemplate($this, CLIENT_STOCK_CLASS_TEMPLATE_FILE, 'stock');
      return TRUE;
    }
  }



  return;
?>