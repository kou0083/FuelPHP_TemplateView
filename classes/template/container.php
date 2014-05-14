<?php

namespace Template;

// ホワイトリストにこのクラスを追加
$whiteList = \Config::get('security.whitelisted_classes');
array_push($whiteList, 'Template\Container');
\Config::set('security.whitelisted_classes', $whiteList);

class Container
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
