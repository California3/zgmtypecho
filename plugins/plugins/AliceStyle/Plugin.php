<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * <strong style="color:#9e5df3;">萌卜兔's 前台美化插件</strong>
 *
 * @package AliceStyle
 * @author racns
 * @version 2.3.3
 * @update: 2019-11-11
 * @link //racns.com
 */
class AliceStyle_Plugin implements Typecho_Plugin_Interface
{

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
        Typecho_Plugin::factory('admin/menu.php')->navBar = array('AliceStyle_Plugin', 'render');
        return '恭喜你！发现了一个全网独一无二的插件';
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
    	return '插件卸载成功了呢';
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {

        //定义插件当前版本号
        $client_version = 20191111;
        //获取服务器上面的版本号
        $data = file_get_contents('http://racns.com/usr/program/api/Server/AliceStyle/');
        /*获取json数据*/
        $result = json_decode($data, true);
        /*获取输出类型*/
        $select = $result['select'];
        //最新版本号
        $server_version = $result['version'];
        //下载地址
        $url = $result['url'];
        //头部信息
        $title = $result['title'];
        //更新说明
        $tips = $result['tips'];
        
        $styleUrl = Helper::options()->pluginUrl . '/AliceStyle/static/css/style.css';
        echo '<link rel="stylesheet" href=" '. $styleUrl .'"/>';
        
        if ($client_version < $server_version) {
        	echo '<div class="container">
					<div class="inner">
						<span>i</span>
						<h1>'. $title .'</h1>
						<p> '. $tips .' </p>
						<p>下载地址：<a href="'. $url .'"> '. $url .' </a></p>
					</div>
				  </div>';
        }elseif($select === 2) {
        	echo '<div class="container">
					<div class="inner" style="background:linear-gradient(to right , #7A88FF, #9b83ff);">
						<span>i</span>
						<h1>'. $title .'</h1>
						<p> '. $tips .' </p>
						<p>下载地址：<a href="'. $url .'"> '. $url .' </a></p>
					</div>
				  </div>';
        }
        

        //设置代码风格样式
        $JSstyles = array_map('basename', glob(dirname(__FILE__) . '/static/js/bg_file/*.js'));
        $JSstyles = array_combine($JSstyles, $JSstyles);
        $name = new Typecho_Widget_Helper_Form_Element_Select('code_js', $JSstyles, 'RiseBalloon.js',
            _t('动态背景选择'), _t('默认背景：PinkBubble，如不需要动态背景，请选择"Null.js"'));
        $form->addInput($name->addRule('enum', _t('必须选择背景'), $JSstyles));

        //主题开关
        $type = new Typecho_Widget_Helper_Form_Element_Radio('type', array(
            '1' => '透明样式',
            '2' => '默认样式'
        ),
            '1', _t('主题样式选择'), _t('如果不需要透明样式"默认样式"'));
        $form->addInput($type);

        //返回顶部、底部
        $RamRem = new Typecho_Widget_Helper_Form_Element_Radio('ramrem', array(
            '1' => '开启',
            '2' => '关闭'
        ),
            '2', _t('返回顶部(拉姆雷姆)'), _t('拉姆：返回顶部；雷姆：返回底部"'));
        $form->addInput($RamRem);

        /*夏目的喵*/
        $Ban = new Typecho_Widget_Helper_Form_Element_Radio('ban', array(
            '1' => '开启',
            '2' => '关闭'
        ),
            '1', _t('返回顶部(夏目的喵)'), _t('夏目的喵：返回顶部'));
        $form->addInput($Ban);
        
        /* 分类名称 */
        $headtips = new Typecho_Widget_Helper_Form_Element_Radio('headtips', array(
            '1' => '开启',
            '2' => '关闭'
        ),
            '1', _t('显示授权信息'), _t('这个功能还在开发中，暂时展示效果，等待功能实现'));
        $form->addInput($headtips);


    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
    {
    	$headtips = Typecho_Widget::widget('Widget_Options')->plugin('AliceStyle')->headtips;
    	$StaticCssUrl = Helper::options()->pluginUrl . '/AliceStyle/static/css/';
    	$StaticJsNeed_file = Helper::options()->pluginUrl . '/AliceStyle/static/js/need_file/';
    	if ( $headtips == 1) {
	        echo '<link rel="stylesheet" href=" '. $StaticCssUrl .'jquery.toolbar.css"/>';
	        echo '<script type="text/javascript" src="' . $StaticJsNeed_file . 'jquery-1.11.0.min.js"></script>';
	        echo '<script type="text/javascript" src="' . $StaticJsNeed_file . 'jquery.toolbar.js"></script>';
	    	echo '
				<section class="btn-set-03">
					<div class="samples">
						<div data-toolbar="set-03" class="btn-toolbar pull-left"><i>AliceStyle</i></div>
					</div>
				</section>
					<div class="clear"></div>
				</section>
				<div id="set-03-options">
					<a href="#"><i style="color:white;">已</i></a>
					<a href="#"><i style="color:white;">授</i></a>
					<a href="#"><i style="color:white;">权</i></a>
				</div>';
			}
    }

    /**
     *为header添加css文件
     * @return void
     */
    public static function header()
    {

        /*主题样式*/
        $type = Typecho_Widget::widget('Widget_Options')->plugin('AliceStyle')->type;
        $cssUrl = Helper::options()->pluginUrl . '/AliceStyle/static/css/custom.css';
        $defaultUrl = Helper::options()->pluginUrl . '/AliceStyle/static/css/default.css';

        //主题开关
        if ($type == 1) {
            echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
        } else {
            echo '<link rel="stylesheet" type="text/css" href="' . $defaultUrl . '" />';
        }

        /*拉姆雷姆返回顶部、底部开关*/
        $RamRem = Typecho_Widget::widget('Widget_Options')->plugin('AliceStyle')->ramrem;
        $ramremUrl = Helper::options()->pluginUrl . '/AliceStyle/static/css/top.css';
        if ($RamRem == 1) {
            echo '<link rel="stylesheet" type="text/css" href="' . $ramremUrl . '" />';
        }

        /*夏目的喵*/
        $Ban = Typecho_Widget::widget('Widget_Options')->plugin('AliceStyle')->ban;
        $banUrl = Helper::options()->pluginUrl . '/AliceStyle/static/css/szgotop.css';
        if ($Ban == 1) {
            echo '<link rel="stylesheet" type="text/css" href="' . $banUrl . '" />';
        }

        echo <<<HTML
		<!-- 顶部跑马灯特效 --><div id="top-grrk"></div>
HTML;
    }


    /**
     *为footer添加js文件
     * @return void
     */
    public static function footer()
    {

        /*主题样式*/
        $Path = Helper::options()->pluginUrl . '/AliceStyle/';
        $JSstyle = Helper::options()->plugin('AliceStyle')->code_js;
        $jsUrl = Helper::options()->pluginUrl . '/AliceStyle/static/js/bg_file/' . $JSstyle;
        echo '<script type="text/javascript" src="' . $jsUrl . '"></script>';
        $jsUrl_custom = Helper::options()->pluginUrl . '/AliceStyle/static/js/need_file/custom.js';


        /*拉姆雷姆返回顶部、底部控件*/
        $RamRem = Typecho_Widget::widget('Widget_Options')->plugin('AliceStyle')->ramrem;
        if ($RamRem == 1) {
            echo '<div id="updown"><div class="sidebar_wo" id="leimu">
	        <img src="' . $Path . 'static/img/leimuA.png" alt="雷姆" onmouseover="this.src=\'' . $Path . 'static/img/leimuB.png\'" onmouseout="this.src=\'' . $Path . 'static/img/leimuA.png\'" id="audioBtn"></div>
	        <div class="sidebar_wo" id="lamu"><img src="' . $Path . 'static/img/lamuA.png" alt="雷姆" onmouseover="this.src=\'' . $Path . 'static/img/lamuB.png\'" onmouseout="this.src=\'' . $Path . 'static/img/lamuA.png\'" id="audioBtn"></div>';
            echo '<script type="text/javascript" src="' . $Path . 'static/js/need_file/RamRem.jquery.min.js"></script>';
            echo '<script type="text/javascript" src="' . $Path . 'static/js/need_file/top.js"></script>';
        }


        /*夏目的喵*/
        $Ban = Typecho_Widget::widget('Widget_Options')->plugin('AliceStyle')->ban;
        if ($Ban == 1) {
            echo '<div class="back-to-top cd-top faa-float animated cd-is-visible" style="top: -900px;"></div>';
            echo '<script type="text/javascript" src="' . $Path . 'static/js/need_file/szgotop.js"></script>';
        }


        echo <<<HTML
		<script type="text/javascript" src="{$jsUrl_custom}"></script>
HTML;
    }
}
