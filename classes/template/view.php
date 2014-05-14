<?php

namespace Template;

/**
 * FuelPHP FrameworkでViewにテンプレート機能を持たせる拡張クラスです。
 *
 * @package    FuelPHP TemplateView
 * @version    0.1
 * @author     Koji Mimura
 * @license    MIT License
 * @link       http://fuelphp.com
 */
class View extends \View
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
        
        $this->container = Container::forge(\View::forge($file, $this->data));
        
        return $this;
    }
}
