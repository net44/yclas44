<?php defined('SYSPATH') or die('No direct script access.');
/**
 * content
 *
 * @author      Chema <chema@garridodiaz.com>
 * @package     Core
 * @copyright   (c) 2009-2013 Open Classifieds Team
 * @license     GPL v3
 */
class Model_Content extends ORM {

    /**
     * @var  string  Table name
     */
    protected $_table_name = 'content';

    /**
     * @var  string  PrimaryKey field name
     */
    protected $_primary_key = 'id_content';


    /**
     * get the model filtered
     * @param  string $seotitle
     * @param  string $type
     */
    public static function get($seotitle, $type = 'page')
    {   
        $content = new self();
        $content = $content->where('seotitle','=', $seotitle)
                 ->where('locale','=', i18n::$locale)
                 ->where('type','=', $type)
                 ->where('status','=', 1)
                 ->limit(1)->cached()->find();

        //was not found try EN translation...
        if (!$content->loaded())
        {

            $content = $content->where('seotitle','=', $seotitle)
                 ->where('locale','=', 'en_UK')
                 ->where('type','=', $type)
                 ->where('status','=', 1)
                 ->limit(1)->cached()->find();
        }

        return $content;
    }

    /**
     * get the model filtered
     * @param  string $seotitle
     * @param  array $replace try to find the matches and replace them
     * @param  string $type
     */
    public static function text($seotitle, $replace = NULL, $type = 'page')
    {
        if ($replace===NULL) $replace = array();
        $content = self::get($seotitle, $type);
        if ($content->loaded())
        {
            $user = Auth::instance()->get_user();

            //adding extra replaces
            $replace+= array('[USER.NAME]' =>  $user->name,
                             '[USER.EMAIL]' =>  $user->email
                            );

            return str_replace(array_keys($replace), array_values($replace), $content->description);
        }
        return FALSE;

    }

    public static function get_pages()
    {
      $pages = new self;
      $pages = $pages ->select('seotitle','title')
                        ->where('type','=', 'page')
                        ->where('status','=', 1)
                        ->order_by('order','asc')
                        ->cached()
                        ->find_all();
      return $pages;
    }

    public function form_setup($form)
    {
        $form->fields['order']['display_as']   = 'select';
        $form->fields['order']['options']      = range(0, 30);

        $form->fields['locale']['display_as']  = 'select';
        $form->fields['locale']['options']     = i18n::get_languages();


    }

    public function exclude_fields()
    {
        return array('created');
    }

    /**
     * is used to create contets if they dont exist
     * @param array
     * @return boolean 
     */
    public static function content_array($contents)
    {
        $return = FALSE;
        foreach ($contents as $c => $value) 
        {
            // get config from DB
            $cont = new self();
            $cont->where('seotitle','=',$value['seotitle'])
                  ->limit(1)->find();

            // if do not exist (not loaded) create them, else do nothing
            if (!$cont->loaded())
            {
                $cont->order = $value['order'];
                $cont->title = $value['title'];
                $cont->seotitle = $value['seotitle'];
                $cont->description = $value['description'];
                $cont->from_email = $value['from_email'];
                $cont->type = $value['type'];
                $cont->status = $value['status'];
                $cont->save();

                $return = TRUE;
            }
        }   

        return $return;
    }

    protected $_table_columns =  
array (
  'id_content' => 
  array (
    'type' => 'int',
    'min' => '0',
    'max' => '4294967295',
    'column_name' => 'id_content',
    'column_default' => NULL,
    'data_type' => 'int unsigned',
    'is_nullable' => false,
    'ordinal_position' => 1,
    'display' => '10',
    'comment' => '',
    'extra' => 'auto_increment',
    'key' => 'PRI',
    'privileges' => 'select,insert,update,references',
  ),
   'locale' => 
  array (
    'type' => 'string',
    'column_name' => 'locale',
    'column_default' => 'en_UK',
    'data_type' => 'varchar',
    'is_nullable' => false,
    'ordinal_position' => 2,
    'character_maximum_length' => '8',
    'collation_name' => 'utf8_general_ci',
    'comment' => '',
    'extra' => '',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
  'order' => 
  array (
    'type' => 'int',
    'min' => '0',
    'max' => '4294967295',
    'column_name' => 'order',
    'column_default' => '0',
    'data_type' => 'int unsigned',
    'is_nullable' => false,
    'ordinal_position' => 3,
    'display' => '2',
    'comment' => '',
    'extra' => '',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
  'title' => 
  array (
    'type' => 'string',
    'column_name' => 'title',
    'column_default' => NULL,
    'data_type' => 'varchar',
    'is_nullable' => false,
    'ordinal_position' => 4,
    'character_maximum_length' => '145',
    'collation_name' => 'utf8_general_ci',
    'comment' => '',
    'extra' => '',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
  'seotitle' => 
  array (
    'type' => 'string',
    'column_name' => 'seotitle',
    'column_default' => NULL,
    'data_type' => 'varchar',
    'is_nullable' => false,
    'ordinal_position' => 5,
    'character_maximum_length' => '145',
    'collation_name' => 'utf8_general_ci',
    'comment' => '',
    'extra' => '',
    'key' => 'UNI',
    'privileges' => 'select,insert,update,references',
  ),
  'description' => 
  array (
    'type' => 'string',
    'character_maximum_length' => '65535',
    'column_name' => 'description',
    'column_default' => NULL,
    'data_type' => 'text',
    'is_nullable' => true,
    'ordinal_position' => 6,
    'collation_name' => 'utf8_general_ci',
    'comment' => '',
    'extra' => '',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
  'from_email' => 
  array (
    'type' => 'string',
    'column_name' => 'from_email',
    'column_default' => NULL,
    'data_type' => 'varchar',
    'is_nullable' => true,
    'ordinal_position' => 7,
    'character_maximum_length' => '145',
    'collation_name' => 'utf8_general_ci',
    'comment' => '',
    'extra' => '',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
  'created' => 
  array (
    'type' => 'string',
    'column_name' => 'created',
    'column_default' => 'CURRENT_TIMESTAMP',
    'data_type' => 'timestamp',
    'is_nullable' => false,
    'ordinal_position' => 8,
    'comment' => '',
    'extra' => 'on update CURRENT_TIMESTAMP',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
  'type' => 
  array (
    'type' => 'string',
    'column_name' => 'type',
    'column_default' => NULL,
    'data_type' => 'enum',
    'is_nullable' => false,
    'ordinal_position' => 9,
    'collation_name' => 'utf8_general_ci',
    'options' => 
    array (
      0 => 'page',
      1 => 'email',
      2 => 'help',
    ),
    'comment' => '',
    'extra' => '',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
  'status' => 
  array (
    'type' => 'int',
    'min' => '-128',
    'max' => '127',
    'column_name' => 'status',
    'column_default' => '0',
    'data_type' => 'tinyint',
    'is_nullable' => false,
    'ordinal_position' => 10,
    'display' => '1',
    'comment' => '',
    'extra' => '',
    'key' => '',
    'privileges' => 'select,insert,update,references',
  ),
);
} // END Model_Content