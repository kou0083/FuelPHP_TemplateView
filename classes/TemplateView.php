<?php

// ホワイトリストにViewContainerを追加
// TODO:もっとスマートに書く方法無い？
$whiteList = \Config::get('security.whitelisted_classes');
array_push($whiteList, 'ViewContainer');
\Config::set('security.whitelisted_classes', $whiteList);

/**
 * FuelPHP FrameworkでViewにテンプレート機能を持たせる拡張クラスです。
 *
 * @package    FuelPHP TemplateView
 * @version    0.1
 * @author     Koji Mimura
 * @license    MIT License
 * @link       http://fuelphp.com
 */
class TemplateView extends \View
{
    protected $template = 'template';

    public function __construct($file = null, $data = null, $filter = null) {
        parent::__construct($file, $data, $filter);
    }
    
    /**
     * Templateファイル名をtemplate以外にする場合はこのメソッドで設定して下さい。
     * 引数無しで呼び出した場合、デフォルト値('template')に設定し直します。
     * @param type $template
     */
    public function set_template($template = 'template')
    {
        $this->template = $template;
    }
    
    /**
     * set_filenameメソッドをオーバーライドし、ファイル名を
     * @param type $file
     * @return \TemplateView
     * @throws \FuelException
     */
    public function set_filename($file)
    {
        // スーパークラスのset_filenameをtemplateパスで実行
        parent::set_filename($this->template);

        // $file を探す。
        if (($path = \Finder::search('views', $file, '.'.$this->extension, false, false)) === false)
        {
                throw new \FuelException('The requested view could not be found: '.\Fuel::clean_path($file));
        }
        
        $this->container = ViewContainer::forge(\View::forge($file, $this->data));
        
        return $this;
    }
}

/**
 * TemplateView用データコンテナ
 *
 * @package    FuelPHP TemplateView
 * @version    0.1
 * @author     Koji Mimura
 * @license    MIT License
 * @link       http://fuelphp.com
 */
class ViewContainer
{
    public $content;
    private $property;
    
    public static function forge(\View $view)
    {
        $response = new static();
        $response->content = $view;
        
        $view->container = $response;
        $view->render();
        
        return $response;
    }
    
    /**
     * 項目を取得する。
     * @param type $property
     * @return type
     */
    public function get_item($property)
    {
        $this->property = $property;
        return isset($this->{$this->property}) ? $this->{$this->property} : null;
    }
}
