<?php
  // Impera CMS: админ модуль списка статей,
  //             админ модуль страницы статьи,
  //             админ модуль списка новостей,
  //             админ модуль страницы новости,
  //             админ модуль списка специальных страниц,
  //             админ модуль специальной страницы,
  //             админ модуль списка медиафайлов,
  //             админ модуль страницы медиафайла,
  //             админ модуль списка меню,
  //             админ модуль страницы меню,
  //             админ модуль списка зарегистрированных модулей,
  //             админ модуль страницы зарегистрированного модуля,
  //             админ модуль списка запретов доступа,
  //             админ модуль страницы запрета доступа.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT);

  // какой файл является шаблоном модуля списка статей,
  // какой файл является шаблоном модуля страницы статьи,
  // какой файл является шаблоном модуля списка новостей,
  // какой файл является шаблоном модуля страницы новости,
  // какой файл является шаблоном модуля списка специальных страниц,
  // какой файл является шаблоном модуля специальной страницы,
  // какой файл является шаблоном модуля списка медиафайлов,
  // какой файл является шаблоном модуля страницы медиафайла,
  // какой файл является шаблоном модуля списка меню,
  // какой файл является шаблоном модуля страницы меню,
  // какой файл является шаблоном модуля списка зарегистрированных модулей,
  // какой файл является шаблоном модуля страницы зарегистрированного модуля,
  // какой файл является шаблоном модуля списка запретов доступа,
  // какой файл является шаблоном модуля страницы запрета доступа
  define("ADMIN_ARTICLES_CLASS_TEMPLATE_FILE", "admin_articles.htm");
  define("ADMIN_ARTICLE_CLASS_TEMPLATE_FILE", "admin_article.htm");
  define("ADMIN_NEWS_CLASS_TEMPLATE_FILE", "admin_news.htm");
  define("ADMIN_NEWSITEM_CLASS_TEMPLATE_FILE", "admin_news_item.htm");
  define("ADMIN_SECTIONS_CLASS_TEMPLATE_FILE", "admin_sections.htm");
  define("ADMIN_SECTION_CLASS_TEMPLATE_FILE", "admin_section.htm");
  define("ADMIN_FILES_CLASS_TEMPLATE_FILE", "admin_files.htm");
  define("ADMIN_FILE_CLASS_TEMPLATE_FILE", "admin_file.htm");
  define("ADMIN_MENUS_CLASS_TEMPLATE_FILE", "admin_menus.htm");
  define("ADMIN_MENU_CLASS_TEMPLATE_FILE", "admin_menu.htm");
  define("ADMIN_MODULES_CLASS_TEMPLATE_FILE", "admin_modules.htm");
  define("ADMIN_MODULE_CLASS_TEMPLATE_FILE", "admin_module.htm");
  define("ADMIN_BANNEDS_CLASS_TEMPLATE_FILE", "admin_banneds.htm");
  define("ADMIN_BANNED_CLASS_TEMPLATE_FILE", "admin_banned.htm");

  // какая страница возврата рекомендуется для модуля страницы статьи,
  // какая страница возврата рекомендуется для модуля страницы новости,
  // какая страница возврата рекомендуется для модуля специальной страницы,
  // какая страница возврата рекомендуется для модуля страницы медиафайла,
  // какая страница возврата рекомендуется для модуля страницы меню,
  // какая страница возврата рекомендуется для модуля страницы зарегистрированного модуля,
  // какая страница возврата рекомендуется для модуля страницы запрета доступа
  define("ADMIN_ARTICLE_CLASS_RESULT_PAGE", "index.php?section=Articles");
  define("ADMIN_NEWSITEM_CLASS_RESULT_PAGE", "index.php?section=News");
  define("ADMIN_SECTION_CLASS_RESULT_PAGE", "index.php?section=Sections");
  define("ADMIN_FILE_CLASS_RESULT_PAGE", "index.php?section=Files");
  define("ADMIN_MENU_CLASS_RESULT_PAGE", "index.php?section=Menus");
  define("ADMIN_MODULE_CLASS_RESULT_PAGE", "index.php?section=Modules");
  define("ADMIN_BANNED_CLASS_RESULT_PAGE", "index.php?section=Banneds");

  // какая папка содержит изображения для статей (папку задаем относительно корневой папки сайта),
  // какая папка содержит изображения для новостей (папку задаем относительно корневой папки сайта),
  // какая папка содержит изображения для специальных страниц (папку задаем относительно корневой папки сайта),
  // какая папка содержит файлы для медиафайлов (папку задаем относительно корневой папки сайта),
  // какая папка содержит изображения для меню (папку задаем относительно корневой папки сайта),
  // какая папка содержит изображения для зарегистрированного модуля (папку задаем относительно корневой папки сайта),
  // какая папка содержит изображения для запрета доступа (папку задаем относительно корневой папки сайта)
  define("ADMIN_ARTICLES_CLASS_UPLOAD_FOLDER", "files/images/articles/");
  define("ADMIN_NEWS_CLASS_UPLOAD_FOLDER", "files/images/news/");
  define("ADMIN_SECTIONS_CLASS_UPLOAD_FOLDER", "files/images/sections/");
  define("ADMIN_FILES_CLASS_UPLOAD_FOLDER", "files/media/");
  define("ADMIN_MENUS_CLASS_UPLOAD_FOLDER", "files/images/menus/");
  define("ADMIN_MODULES_CLASS_UPLOAD_FOLDER", "files/images/modules/");
  define("ADMIN_BANNEDS_CLASS_UPLOAD_FOLDER", "files/images/banneds/");

  // имя файла водяного знака для статей,
  // имя файла водяного знака для новостей,
  // имя файла водяного знака для специальных страниц
  define("ARTICLES_CLASS_WATERMARK_FILENAME", "articles_watermark.png");
  define("NEWS_CLASS_WATERMARK_FILENAME", "news_watermark.png");
  define("SECTIONS_CLASS_WATERMARK_FILENAME", "static_watermark.png");

  // названия динамических параметров
  define("ARTICLES_SORT_SESSION_PARAM_NAME", "admin_articles_sort_method");
  define("NEWS_SORT_SESSION_PARAM_NAME", "admin_news_sort_method");
  define("SECTIONS_SORT_SESSION_PARAM_NAME", "admin_sections_sort_method");
  define("FILES_SORT_SESSION_PARAM_NAME", "admin_files_sort_method");
  define("MENUS_SORT_SESSION_PARAM_NAME", "admin_menus_sort_method");
  define("MODULES_SORT_SESSION_PARAM_NAME", "admin_modules_sort_method");
  define("BANNEDS_SORT_SESSION_PARAM_NAME", "admin_modules_sort_method");



  // =========================================================================
  // Класс Articles (админ модуль списка статей)
  // =========================================================================

  class Articles extends Basic {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'articles';
    public $dbtable_field = 'article_id';



    // рекомендуемая страница возврата после операции,
    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $result_page = '';
    public $upload_folder = ADMIN_ARTICLES_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_ARTICLES_ON_PAGE_IN_ADMIN;



    // оперируемая запись
    protected $item = null;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('categories',
                                  'all_brands',
                                  'all_users',
                                  'menus');



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений
        $this->upload_folder = $this->settings->articles_files_folder_prefix . $this->upload_folder;
    }



    // обработка соответствующих модулю настроек сайта =======================

    protected function process_setup () {

      // если получены данные об изменениях соответствующих настроек сайта
      if (isset($_POST[REQUEST_PARAM_NAME_SETUP])) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        // с какой базой данных работаем?
        switch ($this->dbtable) {

          // если статьи
          case "articles":
            $name = "articles_files_folder_prefix";
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace("/", " ", $value);
              $value = str_replace("\\", " ", $value);
              $value = str_replace(":", " ", $value);
              while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
              $value = str_replace(" ", "_", trim($value));
              $this->db->settings->save($name, $value, "Статьи - изображения - префикс папки с файлами изображений");
            $name = "articles_images_quality";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, "Статьи - изображения - качество");
            $name = "articles_images_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, "Статьи - изображения - предельная ширина");
            $name = "articles_images_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, "Статьи - изображения - предельная высота");
            $name = "articles_thumbnail_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, "Статьи - миниатюры - предельная ширина");
            $name = "articles_thumbnail_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, "Статьи - миниатюры - предельная высота");
            $name = "articles_watermark_transparency";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, "Статьи - водяной знак - процент видимости на картинке");
            $this->db->settings->saveFromPost("articles_images_exactly",        "Статьи - изображения - подгонять ли размеры картинок, меньших предельных размеров");
            $this->db->settings->saveFromPost("articles_watermark_enabled",     "Статьи - водяной знак - разрешено ли накладывать на картинку");
            $this->db->settings->saveFromPost("articles_watermark_location",    "Статьи - водяной знак - расположение");
            $this->db->settings->saveFromPost("articles_wysiwyg_disabled",      "Статьи - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("articles_wysiwyg_disabled_mode", "Статьи - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("articles_meta_autofill",         "Статьи - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("articles_sort_method",           "Статьи - отображение - способ сортировки на стороне клиента");
            $this->db->settings->saveFromPost("articles_main_title",            "Статьи - отображение - оглавление анонсового списка на стороне клиента");
            $this->db->settings->saveFromPost("articles_main_maxcount",         "Статьи - отображение - максимальное количество публикаций в анонсовом списке");
            $this->db->settings->saveFromPost("articles_products_title",        "Статьи - отображение - оглавление списка статей на стороне клиента, привязанных к товару");
            $this->db->settings->saveFromPost("articles_categories_title",      "Статьи - отображение - оглавление списка статей категории на стороне клиента");
            $name = "articles_comment_next_time";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_COMMENTS_NEXTTIME;
              if ($value < SETTINGS_MINIMAL_COMMENTS_NEXTTIME) $value = SETTINGS_MINIMAL_COMMENTS_NEXTTIME;
              if ($value > SETTINGS_MAXIMAL_COMMENTS_NEXTTIME) $value = SETTINGS_MAXIMAL_COMMENTS_NEXTTIME;
              $this->db->settings->save($name, $value, "Статьи - комментарии - антиспам пауза между комментариями");
            $name = "articles_comment_moderation";
              $value = (isset($_POST[$name]) && ($_POST[$name] == 1)) ? 1 : 0;
              $this->db->settings->save($name, $value, "Статьи - комментарии - включить ли модерацию комментариев");
            $upload_folder = $this->settings->articles_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = ARTICLES_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если запреты доступа
          case "banneds":
            break;

          // если медиафайлы
          case "files":
            $name = "files_files_folder_prefix";
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace("/", " ", $value);
              $value = str_replace("\\", " ", $value);
              $value = str_replace(":", " ", $value);
              while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
              $value = str_replace(" ", "_", trim($value));
              $this->db->settings->save($name, $value, "Медиа файлы - файлы - префикс папки с файлами");
            $this->db->settings->saveFromPost("files_wysiwyg_disabled",      "Медиа файлы - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("files_wysiwyg_disabled_mode", "Медиа файлы - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("files_meta_autofill",         "Медиа файлы - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("files_sort_method",           "Медиа файлы - отображение - способ сортировки на стороне клиента");
            $this->db->settings->saveFromPost("files_main_title",            "Медиа файлы - отображение - оглавление списка на стороне клиента");
            $this->db->settings->saveFromPost("files_main_path",             "Медиа файлы - отображение - путевое название списка в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("files_main_keywords",         "Медиа файлы - отображение - ключевые мета слова списка на стороне клиента");
            $this->db->settings->saveFromPost("files_main_description",      "Медиа файлы - отображение - мета описание списка на стороне клиента");

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если меню
          case DATABASE_MENUS_TABLENAME:
            break;

          // если зарегистрированные модули
          case "modules":
            break;

          // если новости
          case "news":
            $name = "news_files_folder_prefix";
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace("/", " ", $value);
              $value = str_replace("\\", " ", $value);
              $value = str_replace(":", " ", $value);
              while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
              $value = str_replace(" ", "_", trim($value));
              $this->db->settings->save($name, $value, "Новости - изображения - префикс папки с файлами изображений");
            $name = "news_images_quality";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, "Новости - изображения - качество");
            $name = "news_images_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, "Новости - изображения - предельная ширина");
            $name = "news_images_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, "Новости - изображения - предельная высота");
            $name = "news_thumbnail_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, "Новости - миниатюры - предельная ширина");
            $name = "news_thumbnail_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, "Новости - миниатюры - предельная высота");
            $name = "news_watermark_transparency";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, "Новости - водяной знак - процент видимости на картинке");
            $this->db->settings->saveFromPost("news_images_exactly",        "Новости - изображения - подгонять ли размеры картинок, меньших предельных размеров");
            $this->db->settings->saveFromPost("news_watermark_enabled",     "Новости - водяной знак - разрешено ли накладывать на картинку");
            $this->db->settings->saveFromPost("news_watermark_location",    "Новости - водяной знак - расположение");
            $this->db->settings->saveFromPost("news_wysiwyg_disabled",      "Новости - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("news_wysiwyg_disabled_mode", "Новости - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("news_meta_autofill",         "Новости - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("news_sort_method",           "Новости - отображение - способ сортировки на стороне клиента");
            $this->db->settings->saveFromPost("news_main_title",            "Новости - отображение - оглавление анонсового списка на стороне клиента");
            $this->db->settings->saveFromPost("news_main_maxcount",         "Новости - отображение - максимальное количество публикаций в анонсовом списке");
            $this->db->settings->saveFromPost("news_products_title",        "Новости - отображение - оглавление списка новостей на стороне клиента, привязанных к товару");
            $this->db->settings->saveFromPost("news_categories_title",      "Новости - отображение - оглавление списка новостей категории на стороне клиента");
            $name = "news_comment_next_time";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_COMMENTS_NEXTTIME;
              if ($value < SETTINGS_MINIMAL_COMMENTS_NEXTTIME) $value = SETTINGS_MINIMAL_COMMENTS_NEXTTIME;
              if ($value > SETTINGS_MAXIMAL_COMMENTS_NEXTTIME) $value = SETTINGS_MAXIMAL_COMMENTS_NEXTTIME;
              $this->db->settings->save($name, $value, "Новости - комментарии - антиспам пауза между комментариями");
            $name = "news_comment_moderation";
              $value = (isset($_POST[$name]) && ($_POST[$name] == 1)) ? 1 : 0;
              $this->db->settings->save($name, $value, "Новости - комментарии - включить ли модерацию комментариев");
            $upload_folder = $this->settings->news_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = NEWS_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если специальные страницы
          case "sections":
            $name = "sections_files_folder_prefix";
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace("/", " ", $value);
              $value = str_replace("\\", " ", $value);
              $value = str_replace(":", " ", $value);
              while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
              $value = str_replace(" ", "_", trim($value));
              $this->db->settings->save($name, $value, "Специальные страницы - изображения - префикс папки с файлами изображений");
            $name = "sections_images_quality";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, "Специальные страницы - изображения - качество");
            $name = "sections_images_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, "Специальные страницы - изображения - предельная ширина");
            $name = "sections_images_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, "Специальные страницы - изображения - предельная высота");
            $name = "sections_thumbnail_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, "Специальные страницы - миниатюры - предельная ширина");
            $name = "sections_thumbnail_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, "Специальные страницы - миниатюры - предельная высота");
            $name = "sections_watermark_transparency";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, "Специальные страницы - водяной знак - процент видимости на картинке");
            $this->db->settings->saveFromPost("sections_images_exactly",        "Специальные страницы - изображения - подгонять ли размеры картинок, меньших предельных размеров");
            $this->db->settings->saveFromPost("sections_watermark_enabled",     "Специальные страницы - водяной знак - разрешено ли накладывать на картинку");
            $this->db->settings->saveFromPost("sections_watermark_location",    "Специальные страницы - водяной знак - расположение");
            $this->db->settings->saveFromPost("sections_wysiwyg_disabled",      "Специальные страницы - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("sections_wysiwyg_disabled_mode", "Специальные страницы - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("sections_meta_autofill",         "Специальные страницы - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("sections_sort_method",           "Специальные страницы - отображение - способ сортировки на стороне клиента");
            $upload_folder = $this->settings->sections_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = SECTIONS_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;
        }

        // может пытались загрузить изображение водяного знака?
        if (isset($upload_url)) $this->editor->processWatermark($upload_folder, $upload_url);
      }
    }

    // обработка входных параметров и команд =================================

    protected function process () {

      // пока никаких изменений в базе данных нет,
      // по умолчанию все команды позволяют на последнем запросе отследить изменения в базе данных,
      // пока нет отмены перенаправления на страницу возврата
      $this->changed = FALSE;
      $watching = TRUE;
      $cancel = FALSE;

      // читаем входной параметр ITEMID - идентификатор оперируемой записи,
      // параметр FROM - на какую страницу вернуться после операции,
      // параметр ACTION - какую команду требовали сделать
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      $act = trim($this->param(REQUEST_PARAM_NAME_ACTION));

      // если действительно передали идентификатор оперируемой записи
      if (!empty($id)) {

        // создаем пустой массив для запросов
        $query = array();

        // какую команду требовали сделать во входном параметре ACTION?
        switch ($act) {

          // если команду "Удалить запись"
          case ACTION_REQUEST_PARAM_VALUE_DELETE:
            $this->action_delete($id, $query);
            break;

          // если команду "Разрешить / запретить показ на сайте"
          case ACTION_REQUEST_PARAM_VALUE_ENABLED:
            $this->action_enabled($id, $query);
            break;

          // если команду "Выделить / НеВыделять визуально"
          case ACTION_REQUEST_PARAM_VALUE_HIGHLIGHTED:
            $this->action_highlighted($id, $query);
            break;

          // если команду "Скрыть / открыть для незарегистрированных пользователей"
          case ACTION_REQUEST_PARAM_VALUE_HIDDEN:
            $this->action_hidden($id, $query);
            break;

          // если команду "Разрешить / запретить комментирование" (она для таблиц articles или news базы данных)
          case ACTION_REQUEST_PARAM_VALUE_COMMENTED:
            if (($this->dbtable == "articles") || ($this->dbtable == "news")) {
              $this->action_commented($id, $query);
            }
            break;

          // если команду "Включить / выключить блокировку доступа к клиентской стороне" (она для таблицы banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_NOACCESS:
            if ($this->dbtable == "banneds") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET no_access = 1 - no_access "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Включить / выключить блокировку регистраций" (она для таблицы banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_NOREGISTER:
            if ($this->dbtable == "banneds") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET no_register = 1 - no_register "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Включить / выключить блокировку комментариев" (она для таблицы banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_NOCOMMENT:
            if ($this->dbtable == "banneds") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET no_comment = 1 - no_comment "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Включить / выключить запросы связи" (она для таблицы banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_NOCALLME:
            if ($this->dbtable == "banneds") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET no_callme = 1 - no_callme "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Включить / выключить блокировку доступа к админпанели" (она для таблицы banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_NOADMIN:
            if ($this->dbtable == "banneds") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET no_admin = 1 - no_admin "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Разрешить / запретить показ в анонсовых списках" (она для таблиц articles или news базы данных)
          case ACTION_REQUEST_PARAM_VALUE_LISTED:
            if (($this->dbtable == "articles") || ($this->dbtable == "news")) {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET listed = 1 - listed "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Разрешен / запрещен для специальных страниц" (она для таблицы modules базы данных)
          case ACTION_REQUEST_PARAM_VALUE_VALUABLE:
            if ($this->dbtable == "modules") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET valuable = 1 - valuable "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Это плагин / модуль" (она для таблицы modules базы данных)
          case ACTION_REQUEST_PARAM_VALUE_PLUGIN:
            if ($this->dbtable == "modules") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET plugin = 1 - plugin "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Поднять выше" (она не для таблиц menu, modules и banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVEUP:
            if (($this->dbtable != DATABASE_MENUS_TABLENAME) && ($this->dbtable != "modules") && ($this->dbtable != "banneds")) {
              switch ($this->dbtable) {
                case "sections":
                case "files":
                  $branch_field = "menu_id";
                  break;
                case "articles":
                case "news":
                default:
                  $branch_field = "category_id";
              }
              $this->action_move_up($id, $query, $branch_field);
            }
            break;

          // если команду "Опустить ниже" (она не для таблиц menu, modules и banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVEDOWN:
            if (($this->dbtable != DATABASE_MENUS_TABLENAME) && ($this->dbtable != "modules") && ($this->dbtable != "banneds")) {
              switch ($this->dbtable) {
                case "sections":
                case "files":
                  $branch_field = "menu_id";
                  break;
                case "articles":
                case "news":
                default:
                  $branch_field = "category_id";
              }
              $this->action_move_down($id, $query, $branch_field);
            }
            break;

          // если команду "Поставить первым" (она не для таблиц menu, modules и banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVEFIRST:
            if (($this->dbtable != DATABASE_MENUS_TABLENAME) && ($this->dbtable != "modules") && ($this->dbtable != "banneds")) {
              switch ($this->dbtable) {
                case "sections":
                case "files":
                  $branch_field = "menu_id";
                  break;
                case "articles":
                case "news":
                default:
                  $branch_field = "category_id";
              }
              $this->action_move_first($id, $query, $branch_field);
            }
            break;

          // если команду "Поставить последним" (она не для таблиц menu, modules и banneds базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVELAST:
            if (($this->dbtable != DATABASE_MENUS_TABLENAME) && ($this->dbtable != "modules") && ($this->dbtable != "banneds")) {
              switch ($this->dbtable) {
                case "sections":
                case "files":
                  $branch_field = "menu_id";
                  break;
                case "articles":
                case "news":
                default:
                  $branch_field = "category_id";
              }
              $this->action_move_last($id, $query, $branch_field);
            }
            break;

          // если команду "Удалить изображение" (она для таблиц articles или news или sections базы данных)
          case ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE:
            if (($this->dbtable == "articles") || ($this->dbtable == "news") || ($this->dbtable == "sections")) {

              // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
              // удаляем заказанные изображения
              $this->check_token();
              $this->action_delete_image($id, $query);
            }
            break;

          // если команду "Удалить файл" (она для таблицы files базы данных)
          case ACTION_REQUEST_PARAM_VALUE_DELETEFILE:
            if ($this->dbtable == "files") {

              // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
              // удаляем заказанные файлы
              $this->check_token();
              $this->action_delete_file($id, $query);
            }
            break;
        }

        // если получен набор запросов, то есть готовы выполнить операцию,
        //   проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
        //   делаем все запросы операции,
        //   если для команды не снято отслеживание изменений в базе данных, делаем его оценкой затронутых записей
        //   если страница возврата не указана, используем рекомендуемую страницу возврата
        if (!empty($query)) {
          $this->check_token();
          if ($this->config->demo) {
            switch ($this->dbtable) {
              case "banneds":
                $this->push_error("В демо версии запрещено модифицировать записи запретов доступа.");
                return;
              case "files":
                $this->push_error("В демо версии запрещено модифицировать записи страниц медиа файлов.");
                return;
              case "modules":
                $this->push_error("В демо версии запрещено модифицировать записи зарегистрированных модулей.");
                return;
            }
          }
          foreach ($query as &$command) $this->db->query($command);
          if ($watching) $this->changed = $this->changed || ($this->db->affected_rows() > 0);
          if (empty($result_page)) $result_page = trim($this->result_page);
        }
      }

      // обрабатываем редакторские изменения в записях (битовый OR использован для гарантии выполнения метода posting() независимо от настроек препроцессора)
      $cancel = $this->posting($result_page) | $cancel;

      // если произошли изменения в базе данных, очищаем соответствующие кеш-таблицы
      if ($this->changed) $this->resetCaches();

      // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
      if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);
    }

    // обработка редактирования записей ======================================

    protected function posting (&$result_page) {

      // ошибки здесь еще не было (пока не отменяем перенаправление на страницу возврата)
      $cancel = FALSE;

      // если получены данные об изменениях
      if (isset($_POST[REQUEST_PARAM_NAME_POST]) && is_array($_POST[REQUEST_PARAM_NAME_POST])) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        if ($this->config->demo) {
          switch ($this->dbtable) {
            case "banneds":
              return $this->push_error("В демо версии запрещено редактировать запреты доступа.");
            case "files":
              return $this->push_error("В демо версии запрещено редактировать записи страниц медиа файлов.");
            case "modules":
              return $this->push_error("В демо версии запрещено редактировать зарегистрированные модули.");
          }
        }

        // цикл по измененным записям
        foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {
          $item_cancel = FALSE;
          $value = $this->dbtable_field;

          // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
          $this->item = null;
          // следующие команды не для таблицы menu базы данных
          if ($this->dbtable != DATABASE_MENUS_TABLENAME) {
            // поле category_id (идентификатор категории)
            if (isset($_POST["category_id"][$id])) $this->item->category_id = trim($_POST["category_id"][$id]);
            // поле brand_id (идентификатор бренда)
            if (isset($_POST["brand_id"][$id])) $this->item->brand_id = trim($_POST["brand_id"][$id]);
            // поле user_id (идентификатор пользователя)
            if (isset($_POST["user_id"][$id])) $this->item->user_id = trim($_POST["user_id"][$id]);
            // поле listed (видна ли в анонсовых списках)
            $this->item->listed = isset($_POST["listed"][$id]) ? (($_POST["listed"][$id] == 1) ? 1 : 0) : 0;
            // поле commented (разрешено ли комментировать)
            $this->item->commented = isset($_POST["commented"][$id]) ? (($_POST["commented"][$id] == 1) ? 1 : 0) : 0;
            // поля url, url_special (адрес страницы записи)
            $this->editor->processUrl($this->item, $id, $item_cancel);
            // поле meta_title (мета заголовок)
            if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
            // поле meta_keywords (мета ключевые слова)
            if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
            // поле meta_description (мета описание)
            if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
            // поле section (к какому разделу сайта принадлежит - это поле нужно обработать до полей "название в меню" и "заголовок")
            if (isset($_POST["section_field"][$id])) $this->item->section = trim($_POST["section_field"][$id]);
            // поле menu_id (идентификатор меню - это поле нужно обработать до полей "название в меню" и "заголовок")
            if (isset($_POST["menu_id"][$id])) $this->item->menu_id = trim($_POST["menu_id"][$id]);
            // поле module_id (идентификатор модуля)
            if (isset($_POST["module_id"][$id])) $this->item->module_id = trim($_POST["module_id"][$id]);
            // поле objects (перечень подключаемых модулей через запятую)
            $this->editor->processObjects($this->item, $id, $item_cancel);
            // поле template (имя шаблона)
            $this->editor->processTemplate($this->item, $id, $item_cancel);
            // поле header (заголовок)
            $this->process_header($this->item, $id, $item_cancel);
            // поле annotation (краткий текст)
            $this->editor->processAnnotation($this->item, $id, $item_cancel);
            // поле body (полный текст)
            $this->editor->processBody($this->item, $id, $item_cancel);
            // поле description (полный текст - в таблице files базы данных)
            $this->editor->processDescription($this->item, $id, $item_cancel);
            // поле seo_description (SEO текст)
            $this->editor->processSeoDescription($this->item, $id, $item_cancel);
            // поля images, images_alts, images_texts, images_view (изображения)
            $this->editor->processImages($this->item, $id, $item_cancel);
            // поля files, files_alts, files_texts (файлы)
            $this->editor->processFiles($this->item, $id, $item_cancel);
            // поле date (дата поста для читателей)
            if (isset($_POST["date"][$id])) $this->item->date = $this->date->fixDate($_POST["date"][$id]);
            // поле tags (теги)
            if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
            // поле created (дата создания)
            if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
            // поле modified (дата изменения)
            $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
            // поле browsed (количество просмотров)
            if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
            // поля rating, votes (рейтинг)
            $this->editor->processRating($this->item, $id, $item_cancel);
            // поле order_num (позиция элемента среди равных в ветви)
            if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
            // поле rss_disabled (запрещена ли демонстрация в RSS)
            $this->item->rss_disabled = isset($_POST["rss_disabled"][$id]) ? (($_POST["rss_disabled"][$id] == 1) ? 1 : 0) : 0;
            // поле export_disabled (запрещена ли демонстрация в информерах)
            $this->item->export_disabled = isset($_POST["export_disabled"][$id]) ? (($_POST["export_disabled"][$id] == 1) ? 1 : 0) : 0;
            // поле valuable (разрешен ли для специальных страниц)
            $this->item->valuable = isset($_POST["valuable"][$id]) ? (($_POST["valuable"][$id] == 1) ? 1 : 0) : 0;
            // поле plugin (это плагин)
            $this->item->plugin = isset($_POST["plugin"][$id]) ? (($_POST["plugin"][$id] == 1) ? 1 : 0) : 0;
            // поле class (класс модуля)
            $this->process_class($this->item, $id, $item_cancel);
            // поле filename (имя файла модуля)
            $this->process_filename($this->item, $id, $item_cancel);
          }
          // поле enabled (разрешена ли к показу на сайте)
          $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
          // поле highlighted (выделена ли визуально)
          $this->item->highlighted = isset($_POST["highlighted"][$id]) ? (($_POST["highlighted"][$id] == 1) ? 1 : 0) : 0;
          // поле hidden (скрыта ли от незарегистрированных пользователей)
          $this->item->hidden = isset($_POST["hidden"][$id]) ? (($_POST["hidden"][$id] == 1) ? 1 : 0) : 0;
          // поле name (название в меню)
          $this->editor->processName($this->item, $id, $item_cancel);

          // для какой таблицы базы данных предназначена запись?
          switch ($this->dbtable) {
            case 'banneds':
              // поле ip (IP-адрес)
              $this->editor->processIp($this->item, $id, $item_cancel);
              // поле begin_date (дата начала блокировки)
              if (isset($_POST["begin_date"][$id])) $this->item->begin_date = $this->date->fixDate($_POST["begin_date"][$id]);
              // поле end_date (дата конца блокировки)
              if (isset($_POST["end_date"][$id])) $this->item->end_date = $this->date->fixDate($_POST["end_date"][$id]);
              // поле no_access (включена ли блокировка доступа к клиентской стороне)
              $this->item->no_access = isset($_POST["no_access"][$id]) ? (($_POST["no_access"][$id] == 1) ? 1 : 0) : 0;
              // поле no_register (включена ли блокировка регистраций)
              $this->item->no_register = isset($_POST["no_register"][$id]) ? (($_POST["no_register"][$id] == 1) ? 1 : 0) : 0;
              // поле no_comment (включена ли блокировка комментариев)
              $this->item->no_comment = isset($_POST["no_comment"][$id]) ? (($_POST["no_comment"][$id] == 1) ? 1 : 0) : 0;
              // поле no_callme (включена ли блокировка запросов связи)
              $this->item->no_callme = isset($_POST["no_callme"][$id]) ? (($_POST["no_callme"][$id] == 1) ? 1 : 0) : 0;
              // поле no_admin (включена ли блокировка доступа к админпанели)
              $this->item->no_admin = isset($_POST["no_admin"][$id]) ? (($_POST["no_admin"][$id] == 1) ? 1 : 0) : 0;
              // поле remark (примечание о запрете доступа)
              if (isset($_POST["remark"][$id])) $this->item->remark = trim($_POST["remark"][$id]);
              // поле enabled (разрешена ли к показу на сайте)
              $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
              // поле created (дата создания)
              if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
              // поле modified (дата изменения)
              $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
              // поле attempts (количество попыток доступа)
              if (isset($_POST["attempts"][$id])) $this->item->attempts = trim($_POST["attempts"][$id]);
              // поле attempts_date (дата попытки доступа)
              if (isset($_POST["attempts_date"][$id])) $this->item->attempts_date = $this->date->fixDate($_POST["attempts_date"][$id]);
              break;
          }

          // поле идентификатора записи
          if (!empty($id) && !empty($this->item)) {
            // это не добавление новой записи, поэтому устанавливаем идентификатор записи
            $this->item->$value = $id;
          } else {
            // если не передано значений дат для новой записи, ставим дату поста и создания равной текущей дате
            if (!isset($this->item->created)) $this->item->created = time();
            if (!isset($this->item->date)) $this->item->date = time();
          }

          // если ошибок нет (не включился признак отмены)
          if (!$item_cancel && !empty($this->item)) {
            // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы,
            // битовый OR использован для гарантии выполнения метода update() независимо от настроек препроцессора)
            $this->item->indifferent_caches = TRUE;
            $this->changed = ($this->update($this->item) != "") | $this->changed;
            // если страница возврата не указана, используем рекомендуемую страницу
            if (empty($result_page)) $result_page = trim($this->result_page);
          }

          $cancel = $cancel || $item_cancel;
        }
      }

      // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
      return $cancel;
    }

    // обработка изменения поля CLASS записи =================================

    private function process_class (&$item, $id, &$cancel) {
      if (isset($_POST["class"][$id])) {
        $item->class = trim($_POST["class"][$id]);
        $item->class = str_replace("\\", "", $item->class);
        $item->class = str_replace("/", "", $item->class);
        $item->class = str_replace(":", "", $item->class);
        $item->class = trim($item->class);
        if ($item->class == "") $cancel = $this->push_error("Не указан класс модуля.");
      }
    }

    // обработка изменения поля FILENAME записи ==============================

    private function process_filename (&$item, $id, &$cancel) {
      if (isset($_POST["filename"][$id])) {
        $item->filename = trim($_POST["filename"][$id]);
        $item->filename = str_replace("\\", "", $item->filename);
        $item->filename = str_replace("/", "", $item->filename);
        $item->filename = str_replace(":", "", $item->filename);
        $item->filename = trim($item->filename);
      }
    }

    // обработка изменения поля HEADER записи ================================

    private function process_header ( & $item, $id, & $cancel ) {
        if (isset($_POST['header'][$id])) {
            $item->header = trim($_POST['header'][$id]);
            if ($item->header == '') {
                $cancel = $this->push_error('Не указан заголовок.');
            } else {
                $row = null;
                $params = new stdClass;
                if (!empty($id)) $params->exclude_id = $id;
                $params->header = $item->header;
                $params->menu_id = isset($item->menu_id) ? $item->menu_id : 0;
                $params->section = isset($item->section) ? $item->section : 1;
                switch ($this->dbtable) {
                    case 'articles':
                        $this->db->get_article($row, $params);
                        break;
                    case 'news':
                        $this->db->news->one($row, $params);
                        break;
                    case 'sections':
                        $this->db->sections->one($row, $params);
                        break;
                    case 'files':
                        $this->db->get_file($row, $params);
                        break;
                    case 'menus':
                    case 'modules':
                    default:
                }
                if (!empty($row)) {
                    $cancel = $this->push_error('Уже есть другая запись с аналогичным заголовком ' . (isset($item->menu_id) ? 'в таком' : 'вне') . ' меню' . (isset($item->section) ? ' указанного раздела магазина' : '') . '.');
                }
            }
        }
    }

    // обновление записи в базе данных =======================================

    protected function update ( & $item ) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_article($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // сбор параметров html-формы ============================================

    protected function collect_inputs (&$inputs, &$params, $default_sort, $session_param) {

      $inputs = array();
      $params = new stdClass;

      // собираем параметры сортировки
      $params->sort = $default_sort;
      if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT])) $_SESSION[$session_param] = $_REQUEST[REQUEST_PARAM_NAME_SORT];
      if (isset($_SESSION[$session_param])) $params->sort = intval($_SESSION[$session_param]);
      $inputs[REQUEST_PARAM_NAME_SORT] = $params->sort;

      // собираем параметры фильтра (категория)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY]);
        if ($value != "") $params->category_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $value;
      }

      // собираем параметры фильтра (бренд)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND]);
        if ($value != "") $params->brand_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_BRAND] = $value;
      }

      // собираем параметры фильтра (автор)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER]);
        if ($value != "") $params->user_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_USER] = $value;
      }

      // собираем параметры фильтра (раздел)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION]);
        if ($value != "") $params->section = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_SECTION] = $value;
      }

      // собираем параметры фильтра (разрешена)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED]);
        if ($value != "") $params->enabled = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_ENABLED] = $value;
      }

      // собираем параметры фильтра (блокировка доступа к клиентской стороне)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOACCESS])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOACCESS]);
        if ($value != "") $params->no_access = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOACCESS] = $value;
      }

      // собираем параметры фильтра (блокировка регистраций)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOREGISTER])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOREGISTER]);
        if ($value != "") $params->no_register = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOREGISTER] = $value;
      }

      // собираем параметры фильтра (блокировка комментариев)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOCOMMENT])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOCOMMENT]);
        if ($value != "") $params->no_comment = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOCOMMENT] = $value;
      }

      // собираем параметры фильтра (блокировка запросов связи)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOCALLME])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOCALLME]);
        if ($value != "") $params->no_callme = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOCALLME] = $value;
      }

      // собираем параметры фильтра (блокировка доступа к админпанели)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOADMIN])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOADMIN]);
        if ($value != "") $params->no_admin = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOADMIN] = $value;
      }

      // собираем параметры фильтра (с попытками доступа)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ATTEMPTED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ATTEMPTED]);
        if ($value != "") $params->attempted = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_ATTEMPTED] = $value;
      }

      // собираем параметры фильтра (скрыта от чужих)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN]);
        if ($value != "") $params->hidden = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $value;
      }

      // собираем параметры фильтра (в анонсах)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_LISTED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_LISTED]);
        if ($value != "") $params->listed = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_LISTED] = $value;
      }

      // собираем параметры фильтра (обсуждаема)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_COMMENTED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_COMMENTED]);
        if ($value != "") $params->commented = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_COMMENTED] = $value;
      }

      // собираем параметры фильтра (с картинками)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED]);
        if ($value != "") $params->imaged = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_IMAGED] = $value;
      }

      // собираем параметры фильтра (с файлами)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_FILED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_FILED]);
        if ($value != "") $params->filed = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_FILED] = $value;
      }

      // собираем параметры фильтра (меню)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU]);
        if ($value != "") $params->menu_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_MENU] = $value;
      }

      // собираем параметры фильтра (модуль)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MODULE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_MODULE]);
        if ($value != "") $params->module_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_MODULE] = $value;
      }

      // собираем параметры фильтра (с модулями)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED]);
        if ($value != "") $params->objected = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $value;
      }

      // собираем параметры фильтра (с SEO текстом)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED]);
        if ($value != "") $params->SEOed = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_SEOED] = $value;
      }

      // собираем параметры фильтра (с особым url)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL]);
        if ($value != "") $params->url_special = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $value;
      }

      // собираем параметры фильтра (не для rss)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS]);
        if ($value != "") $params->rss_disabled = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $value;
      }

      // собираем параметры фильтра (не для экспорта)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT]);
        if ($value != "") $params->export_disabled = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $value;
      }

      // собираем параметры фильтра (разрешен для специальных страниц)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_VALUABLE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_VALUABLE]);
        if ($value != "") $params->valuable = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_VALUABLE] = $value;
      }

      // собираем параметры фильтра (это плагин)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PLUGIN])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PLUGIN]);
        if ($value != "") $params->plugin = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_PLUGIN] = $value;
      }

      // собираем параметры фильтра (аутентификатор операции)
      $inputs[REQUEST_PARAM_NAME_TOKEN] = $this->token;
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Статьи";

      // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, SORT_ARTICLES_MODE_BY_CREATED, ARTICLES_SORT_SESSION_PARAM_NAME);

      // читаем список статей на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_articles($items, $params);
      $this->db->fix_articles_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->category_id)) $this->params[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $params->category_id;
      if (isset($params->brand_id)) $this->params[REQUEST_PARAM_NAME_FILTER_BRAND] = $params->brand_id;
      if (isset($params->user_id)) $this->params[REQUEST_PARAM_NAME_FILTER_USER] = $params->user_id;
      if (isset($params->section)) $this->params[REQUEST_PARAM_NAME_FILTER_SECTION] = $params->section;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
      if (isset($params->listed)) $this->params[REQUEST_PARAM_NAME_FILTER_LISTED] = $params->listed;
      if (isset($params->commented)) $this->params[REQUEST_PARAM_NAME_FILTER_COMMENTED] = $params->commented;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->menu_id)) $this->params[REQUEST_PARAM_NAME_FILTER_MENU] = $params->menu_id;
      if (isset($params->objected)) $this->params[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $params->objected;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      if (isset($params->url_special)) $this->params[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $params->url_special;
      if (isset($params->rss_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $params->rss_disabled;
      if (isset($params->export_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $params->export_disabled;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи статей оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_articles($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_ARTICLES_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Article (админ модуль страницы статьи)
  // =========================================================================

  class Article extends Articles {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_ARTICLE_CLASS_RESULT_PAGE;



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // если в запросе есть параметр FROM (страница возврата из операции),
      // запоминаем его, передаем в шаблонизатор и убираем из запроса
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      if (!empty($result_page)) {
        $this->result_page = $result_page;
        $this->destroy_param(REQUEST_PARAM_NAME_FROM);
        $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
      }

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды
      $this->process_setup();
      $this->process();

      // читаем входной параметр ITEMID - идентификатор оперируемой записи
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

      // устанавливаем заголовок страницы,
      // если нет данных статьи или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новая статья";
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_article($this->item, $params);
      }

      // если данные статьи получены,
      //   меняем заголовок страницы,
      //   выправляем текст статьи согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование статьи \"" . (isset($this->item->header) ? $this->item->header : "") . "\"";
        if ($this->settings->articles_wysiwyg_disabled == 1) {
          if (isset($this->item->annotation)) $this->item->annotation = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->annotation, $this->settings->articles_wysiwyg_disabled_mode);
          if (isset($this->item->body)) $this->item->body = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->body, $this->settings->articles_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->articles_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_articles_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->hidden = 0;
        $this->item->listed = 1;
        $this->item->browsed = 0;
        $this->item->url_special = 0;
        $this->item->date = date('Y-m-d H:i');
        $this->item->section = 1;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_ARTICLE_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс News (админ модуль списка новостей)
  // =========================================================================

  class News extends Articles {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'news';
    public $dbtable_field = 'news_id';



    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_NEWS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_NEWS_ON_PAGE_IN_ADMIN;



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений
        $this->upload_folder = $this->settings->news_files_folder_prefix . $this->upload_folder;
    }



    // обновление записи в базе данных =======================================

    protected function update ( & $item ) {

        // приказываем объекту базы данных обновить/добавить указанную запись
        return $this->db->news->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новости";

      // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $inputs = null;
      $params = null;
      $this->collect_inputs($inputs, $params, SORT_NEWS_MODE_BY_CREATED, NEWS_SORT_SESSION_PARAM_NAME);

      // читаем список новостей на текущей странице согласно параметрам фильтра и сортировки
      $items = null;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->news->get($items, $params);
      $this->db->news->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->category_id)) $this->params[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $params->category_id;
      if (isset($params->brand_id)) $this->params[REQUEST_PARAM_NAME_FILTER_BRAND] = $params->brand_id;
      if (isset($params->user_id)) $this->params[REQUEST_PARAM_NAME_FILTER_USER] = $params->user_id;
      if (isset($params->section)) $this->params[REQUEST_PARAM_NAME_FILTER_SECTION] = $params->section;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
      if (isset($params->listed)) $this->params[REQUEST_PARAM_NAME_FILTER_LISTED] = $params->listed;
      if (isset($params->commented)) $this->params[REQUEST_PARAM_NAME_FILTER_COMMENTED] = $params->commented;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->menu_id)) $this->params[REQUEST_PARAM_NAME_FILTER_MENU] = $params->menu_id;
      if (isset($params->objected)) $this->params[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $params->objected;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      if (isset($params->url_special)) $this->params[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $params->url_special;
      if (isset($params->rss_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $params->rss_disabled;
      if (isset($params->export_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $params->export_disabled;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи новостей оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->news->operable($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_NEWS_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс NewsLine (админ модуль списка новостей) - клон класса News
  // =========================================================================

  class NewsLine extends News {}

  // =========================================================================
  // Класс NewsItem (админ модуль страницы новости)
  // =========================================================================

  class NewsItem extends News {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_NEWSITEM_CLASS_RESULT_PAGE;



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // если в запросе есть параметр FROM (страница возврата из операции),
      // запоминаем его, передаем в шаблонизатор и убираем из запроса
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      if (!empty($result_page)) {
        $this->result_page = $result_page;
        $this->destroy_param(REQUEST_PARAM_NAME_FROM);
        $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
      }

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды
      $this->process_setup();
      $this->process();

      // читаем входной параметр ITEMID - идентификатор оперируемой записи
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

      // устанавливаем заголовок страницы,
      // если нет данных новости или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новая новость';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->news->one($this->item, $params);
      }

      // если данные новости получены,
      //   меняем заголовок страницы,
      //   выправляем текст новости согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование новости "' . (isset($this->item->header) ? $this->item->header : '') . '"';
        if ($this->settings->news_wysiwyg_disabled == 1) {
          if (isset($this->item->annotation)) $this->item->annotation = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->annotation, $this->settings->news_wysiwyg_disabled_mode);
          if (isset($this->item->body)) $this->item->body = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->body, $this->settings->news_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->news_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->news->unpack($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->hidden = 0;
        $this->item->listed = 1;
        $this->item->browsed = 0;
        $this->item->url_special = 0;
        $this->item->date = date('Y-m-d H:i');
        $this->item->section = 1;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_NEWSITEM_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Sections (админ модуль списка специальных страниц)
  // =========================================================================

  class Sections extends Articles {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'sections';
    public $dbtable_field = 'section_id';



    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_SECTIONS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_SECTIONS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('all_users',
                                  'menus');



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений
        $this->upload_folder = $this->settings->sections_files_folder_prefix . $this->upload_folder;
    }



    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->sections->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Специальные страницы";

      // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $inputs = null;
      $params = null;
      $this->collect_inputs($inputs, $params, SORT_SECTIONS_MODE_AS_IS, SECTIONS_SORT_SESSION_PARAM_NAME);

      // читаем список специальных страниц на текущей странице согласно параметрам фильтра и сортировки
      $items = null;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->sections->get($items, $params);
      $this->db->sections->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->user_id)) $this->params[REQUEST_PARAM_NAME_FILTER_USER] = $params->user_id;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->menu_id)) $this->params[REQUEST_PARAM_NAME_FILTER_MENU] = $params->menu_id;
      if (isset($params->module_id)) $this->params[REQUEST_PARAM_NAME_FILTER_MODULE] = $params->module_id;
      if (isset($params->objected)) $this->params[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $params->objected;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      if (isset($params->url_special)) $this->params[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $params->url_special;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи специальных страниц оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->sections->operable($items, $params);

      // читаем и передаем в шаблонизатор список зарегистрированных модулей, разрешенных для специальных страниц
      $params = new stdClass;
      $params->sort = SORT_MODULES_MODE_BY_NAME;
      $params->valuable = 1;
      $params->plugin = 0;
      $this->db->get_modules($modules, $params);
      $this->smarty->assignByRef(SMARTY_VAR_MODULES, $modules);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_MODULES, $modules);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef("Sections", $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SECTIONS_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Section (админ модуль специальной страницы)
  // =========================================================================

  class Section extends Sections {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_SECTION_CLASS_RESULT_PAGE;



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // если в запросе есть параметр FROM (страница возврата из операции),
      // запоминаем его, передаем в шаблонизатор и убираем из запроса
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      if (!empty($result_page)) {
        $this->result_page = $result_page;
        $this->destroy_param(REQUEST_PARAM_NAME_FROM);
        $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
      }

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды
      $this->process_setup();
      $this->process();

      // читаем входной параметр ITEMID - идентификатор оперируемой записи
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

      // устанавливаем заголовок страницы,
      // если нет данных специальной страницы или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новая специальная страница";
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->sections->one($this->item, $params);
      }

      // если данные специальной страницы получены,
      //   меняем заголовок страницы,
      //   выправляем текст специальной страницы согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование специальной страницы \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
        if ($this->settings->sections_wysiwyg_disabled == 1) {
          if (isset($this->item->body)) $this->item->body = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->body, $this->settings->sections_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->sections_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->sections->unpack($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->hidden = 0;
        $this->item->browsed = 0;
        $this->item->url_special = 0;
      }

      // читаем и передаем в шаблонизатор список зарегистрированных модулей, разрешенных для специальных страниц
      $params = new stdClass;
      $params->sort = SORT_MODULES_MODE_BY_NAME;
      $params->valuable = 1;
      $params->plugin = 0;
      $this->db->get_modules($modules, $params);
      $this->smarty->assignByRef(SMARTY_VAR_MODULES, $modules);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_MODULES, $modules);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef("Section", $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SECTION_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Files (админ модуль списка медиафайлов)
  // =========================================================================

  class Files extends Articles {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'files';
    public $dbtable_field = 'file_id';



    // в какую папку выгружать файлы,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_FILES_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_FILES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('menus');



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки файлов
        $this->upload_folder = $this->settings->files_files_folder_prefix . $this->upload_folder;
    }



    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_file($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Страницы медиа файлов";

      // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, SORT_FILES_MODE_AS_IS, FILES_SORT_SESSION_PARAM_NAME);

      // читаем список медиафайлов на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_files($items, $params);
      $this->db->fix_files_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->section)) $this->params[REQUEST_PARAM_NAME_FILTER_SECTION] = $params->section;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
      if (isset($params->filed)) $this->params[REQUEST_PARAM_NAME_FILTER_FILED] = $params->filed;
      if (isset($params->menu_id)) $this->params[REQUEST_PARAM_NAME_FILTER_MENU] = $params->menu_id;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи медиафайлов оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_files($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_FILES_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс File (админ модуль страницы медиафайла)
  // =========================================================================

  class File extends Files {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_FILE_CLASS_RESULT_PAGE;



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // если в запросе есть параметр FROM (страница возврата из операции),
      // запоминаем его, передаем в шаблонизатор и убираем из запроса
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      if (!empty($result_page)) {
        $this->result_page = $result_page;
        $this->destroy_param(REQUEST_PARAM_NAME_FROM);
        $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
      }

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды
      $this->process_setup();
      $this->process();

      // читаем входной параметр ITEMID - идентификатор оперируемой записи
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

      // устанавливаем заголовок страницы,
      // если нет данных медиафайла или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новая страница медиа файла";
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_file($this->item, $params);
      }

      // если данные медиафайла получены,
      //   меняем заголовок страницы,
      //   выправляем описание медиафайла согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование страницы медиа файла \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
        if ($this->settings->files_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->files_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->files_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_files_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->hidden = 0;
        $this->item->browsed = 0;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_FILE_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Menus (админ модуль списка меню)
  // =========================================================================

  class Menus extends Articles {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_MENUS_TABLENAME;
    public $dbtable_field = 'menu_id';

    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_MENUS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_MENUS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_menu($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {

      // приказываем объекту базы данных безусловно очистить нужные кеш-таблицы
      $this->db->reset_menus_caches();
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Меню";

      // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, SORT_MENUS_MODE_BY_NAME, MENUS_SORT_SESSION_PARAM_NAME);

      // читаем список меню на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_menus($items, $params);
      $this->db->fix_menus_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи меню оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_menus($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_MENUS_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Menu (админ модуль страницы меню)
  // =========================================================================

  class Menu extends Menus {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_MENU_CLASS_RESULT_PAGE;



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // если в запросе есть параметр FROM (страница возврата из операции),
      // запоминаем его, передаем в шаблонизатор и убираем из запроса
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      if (!empty($result_page)) {
        $this->result_page = $result_page;
        $this->destroy_param(REQUEST_PARAM_NAME_FROM);
        $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
      }

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды
      $this->process_setup();
      $this->process();

      // читаем входной параметр ITEMID - идентификатор оперируемой записи
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

      // устанавливаем заголовок страницы,
      // если нет данных меню или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новое меню";
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_menu($this->item, $params);
      }

      // если данные меню получены,
      //   меняем заголовок страницы
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование меню \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_menus_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->hidden = 0;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_MENU_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Modules (админ модуль списка зарегистрированных модулей)
  // =========================================================================

  class Modules extends Articles {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'modules';
    public $dbtable_field = 'module_id';

    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_MODULES_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_MODULES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_module($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Модули";

      // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, SORT_MODULES_MODE_BY_NAME, MODULES_SORT_SESSION_PARAM_NAME);

      // читаем список зарегистрированных модулей на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_modules($items, $params);
      $this->db->fix_modules_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->valuable)) $this->params[REQUEST_PARAM_NAME_FILTER_VALUABLE] = $params->valuable;
      if (isset($params->plugin)) $this->params[REQUEST_PARAM_NAME_FILTER_PLUGIN] = $params->plugin;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи зарегистрированных модулей оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_modules($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_MODULES_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Module (админ модуль страницы зарегистрированного модуля)
  // =========================================================================

  class Module extends Modules {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_MODULE_CLASS_RESULT_PAGE;



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // если в запросе есть параметр FROM (страница возврата из операции),
      // запоминаем его, передаем в шаблонизатор и убираем из запроса
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      if (!empty($result_page)) {
        $this->result_page = $result_page;
        $this->destroy_param(REQUEST_PARAM_NAME_FROM);
        $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
      }

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды
      $this->process_setup();
      $this->process();

      // читаем входной параметр ITEMID - идентификатор оперируемой записи
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

      // устанавливаем заголовок страницы,
      // если нет данных зарегистрированного модуля или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новый модуль";
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_module($this->item, $params);
      }

      // если данные зарегистрированного модуля получены,
      //   меняем заголовок страницы
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование модуля \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_modules_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->valuable = 1;
        $this->item->plugin = 0;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_MODULE_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Banneds (админ модуль списка запретов доступа)
  // =========================================================================

  class Banneds extends Articles {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'banneds';
    public $dbtable_field = 'ban_id';

    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_BANNEDS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_BANNEDS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_banned($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Запреты доступа";

      // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, SORT_BANNEDS_MODE_BY_IP, BANNEDS_SORT_SESSION_PARAM_NAME);

      // читаем список запретов доступа на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_banneds($items, $params);
      $this->db->fix_banneds_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->no_access)) $this->params[REQUEST_PARAM_NAME_FILTER_NOACCESS] = $params->no_access;
      if (isset($params->no_register)) $this->params[REQUEST_PARAM_NAME_FILTER_NOREGISTER] = $params->no_register;
      if (isset($params->no_comment)) $this->params[REQUEST_PARAM_NAME_FILTER_NOCOMMENT] = $params->no_comment;
      if (isset($params->no_callme)) $this->params[REQUEST_PARAM_NAME_FILTER_NOCALLME] = $params->no_callme;
      if (isset($params->no_admin)) $this->params[REQUEST_PARAM_NAME_FILTER_NOADMIN] = $params->no_admin;
      if (isset($params->attempted)) $this->params[REQUEST_PARAM_NAME_FILTER_ATTEMPTED] = $params->attempted;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи запретов доступа оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_banneds($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_BANNEDS_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс Banned (админ модуль страницы запрета доступа)
  // =========================================================================

  class Banned extends Banneds {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_BANNED_CLASS_RESULT_PAGE;



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

      // если в запросе есть параметр FROM (страница возврата из операции),
      // запоминаем его, передаем в шаблонизатор и убираем из запроса
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      if (!empty($result_page)) {
        $this->result_page = $result_page;
        $this->destroy_param(REQUEST_PARAM_NAME_FROM);
        $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
      }

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды
      $this->process_setup();
      $this->process();

      // читаем входной параметр ITEMID - идентификатор оперируемой записи
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

      // устанавливаем заголовок страницы,
      // если нет данных запрета доступа или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новый запрет доступа";
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_banned($this->item, $params);
      }

      // если данные запрета доступа получены,
      //   меняем заголовок страницы
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование запрета доступа на \"" . (isset($this->item->ip) ? $this->item->ip : "") . "\"";
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_banneds_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->no_access = 0;
        $this->item->no_register = 0;
        $this->item->no_comment = 1;
        $this->item->no_callme = 1;
        $this->item->no_admin = 0;
        $this->item->attempts = 0;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_BANNED_CLASS_TEMPLATE_FILE);
    }
  }



  return;
?>