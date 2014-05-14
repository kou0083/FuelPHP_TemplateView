<?php

namespace TemplateView;
/**
 * FuelPHP FrameworkでViewModelにテンプレート機能を持たせる拡張クラスです。
 * 
 * @package    FuelPHP TemplateView
 * @version    0.1
 * @author     Koji Mimura
 * @license    MIT License
 * @link       http://fuelphp.com
 */
class TemplateViewModel extends \ViewModel
{
    /**
     * Construct the TemplateView object
     */
    protected function set_view()
    {
            $this->_view instanceOf View or $this->_view = TemplateView::forge($this->_view);
    }
}

