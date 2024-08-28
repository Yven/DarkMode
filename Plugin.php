<?php

/**
 * 页面切换普通/黑暗模式
 *
 * @package DarkMode
 * @author Yven
 * @version 1.0
 * @link https://yvenchang.cn/
 */

class DarkMode_Plugin implements Typecho_Plugin_Interface
{
    const PROJECT_NAME = "DarkMode";
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array(self::PROJECT_NAME.'_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array(self::PROJECT_NAME.'_Plugin', 'footer');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate() {}

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $jquery = new Typecho_Widget_Helper_Form_Element_Radio(
            'jquerySelect',
            array(
                'true' => '是',
                'false' => '否'
            ),
            'false',
            '加载jQuery库',
            '如果主题本身已经引用了jQuery库，那么请无视此选项。'
        );
        $form->addInput($jquery);

        $isAuto = new Typecho_Widget_Helper_Form_Element_Radio(
            'isAuto',
            array(
                'true' => '是',
                'false' => '否'
            ),
            'false',
            '跟随用户系统自动设置',
            '选择后会跟随用户系统当前是否为黑暗模式自动切换显示。'
        );
        $form->addInput($isAuto);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}


    /**
     * 页头输出相关代码
     *
     * @access public
     * @param unknown header
     * @return void
     */
    public static function header()
    {
        $Path = Helper::options()->pluginUrl . '/' . self::PROJECT_NAME . '/';
        $Options = Helper::options()->plugin('DarkMode');
        if ($Options->jquery != "false") {
            echo '<script type="text/javascript" src="' . $Path . 'js/jquery.min.js"></script>';
        }

        echo '<link rel="stylesheet" type="text/css" href="' . $Path . 'css/btn.css" />';
        echo '<input class="tgl tgl-skewed" id="cb3" type="checkbox"/><label id="cb-btn" class="tgl-btn" data-tg-off="Light" data-tg-on="Dark" for="cb3"></label>';
    }

    /**
     * 页脚输出相关代码
     *
     * @access public
     * @param unknown footer
     * @return void
     */
    public static function footer()
    {
        $Path = Helper::options()->pluginUrl . '/'.self::PROJECT_NAME.'/';
        $Options = Helper::options()->plugin('DarkMode');
        if ($Options->isAuto != "false") {
            echo '<script type="text/javascript">var isAuto = true;</script>';
        } else {
            echo '<script type="text/javascript">var isAuto = false;</script>';
        }
        echo '<script type="text/javascript" src="' . $Path . '/js/modechange.js"></script>';
    }
}
