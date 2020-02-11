<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 显示评论人使用的操作系统和浏览器信息（Handsome主题专用）</br> 更新时间: <code style="padding: 2px 4px; font-size: 90%; color: #c7254e; background-color: #f9f2f4; border-radius: 4px;">2019-09-17</code>
 * @package UserAgent
 * @author  松鼠大大
 * @version 1.0.7
 * @link https://doge.uk/
 */
class UserAgent_Plugin implements Typecho_Plugin_Interface
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
		return _t('插件安装成功,请在需要显示评论信息的位置插入嵌入点代码!!!');
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
		return _t('插件卸载成功');
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
		$element = new Typecho_Widget_Helper_Form_Element_Radio('info', array(0 => _t('只显示 ICON'), 1 => _t('显示 ICON + UA 详细 ')), 1, _t('请选择 UA 信息展示方式'));
		$form->addInput($element);

		$element = new Typecho_Widget_Helper_Form_Element_Checkbox('effect', array('color' => _t('鼠标经过或悬停时显示UA信息'), 'visible' => _t('仅博主可见')), array('color', 'visible'), _t('请选择 UA 信息展示效果'));
        $form->addInput($element);

		$element = new Typecho_Widget_Helper_Form_Element_Checkbox('color', array('color' => _t('显示随机颜色')), array('color'), _t('是否显示随机颜色'), _t('默认勾选,显示随机颜色,此时自定义RGB颜色值不可用.'));
        $form->addInput($element);
		
		$element = new Typecho_Widget_Helper_Form_Element_Text('color_value', null, '#924cda', _t('自定义RGB颜色值'), _t('填入自己喜欢的RGB颜色值代码,例如: #924cda </br><b>注意: </b>随机颜色未选中时方可使用！！！'));
        $form->addInput($element);

		$element = new Typecho_Widget_Helper_Form_Element_Checkbox('ip', array('loc' => _t('显示IP位置信息'), 'visible' => _t('仅博主可见')), array('loc', 'visible'), _t('是否显示IP位置信息'), _t('默认勾选,显示IP位置信息,查询比较耗时,轻微影响用户浏览体验.'));
        $form->addInput($element);
		
		$element = new Typecho_Widget_Helper_Form_Element_Select('api',
		    array(
                'SB'=>_t('IP.SB (国内)'),
                'TaoBao'=>_t('淘宝 (国内)'),
				'IpApi'=>_t('IP-API (国外)')
            ),
			'SB',
			_t('请选择第三方获取IP信息的API接口'),
			_t('此项用于本地IP数据库查询失败后,选择第三方接口继续查询</br>默认选择 <a href="https://ip.sb/">IP.SB</a>,国外服务器建议选择 IP-API')
		);
		$form->addInput($element);

		$element = new Typecho_Widget_Helper_Form_Element_Select('instant_page',
		    array(
		    	'off'=>_t('禁用此功能'),
                'local'=>_t('本地加载源'),
                'official'=>_t('官方加载源'),
                'baomitu'=>_t('75CDN')
            ),
			'off',
			_t('Instant.page（提高网站页面加载速度）[可选]'),
			_t('由于官方加载源是存储在国外,所以建议各位合理选择加载源,以缩短脚本载入的时间</br><a href="https://instant.page/">Instant.page官网</a> | <a href="https://www.usebsd.com/633.html">了解Instant.page</a></br></br>请在需要显示评论信息的位置插入下方嵌入点代码:</br><code style="padding: 2px 4px; font-size: 90%; color: #c7254e; background-color: #f9f2f4; border-radius: 4px;">&lt;?php UserAgent_Plugin::get_useragent($comments->agent,$comments->ip); ?&gt;</code>')
		);
		$form->addInput($element);

    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

	 /**
     *为header添加css文件
     *@return void
     */
	public static function header()
	{
		$cssUrl = Helper::options()->pluginUrl . '/UserAgent/css/useragent.css';
        echo '<link rel="stylesheet" type="text/css" href="https://at.alicdn.com/t/font_1166601_ukjy21v4twb.css">' . PHP_EOL . '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
	}

	/**
     *为footer添加js文件
     *@return void
     */
    public static function footer() {
    	$type = Helper::options()->plugin('UserAgent')->instant_page;
    	switch ($type) {
    		case 'official':
    			echo '<script src="//instant.page/2.0.0" type="module" defer integrity="sha384-D7B5eODAUd397+f4zNFAVlnDNDtO1ppV8rPnfygILQXhqu3cUndgHvlcJR2Bhig8"></script>';
    			break;

    		case 'local':
    			$jsUrl = helper::options()->pluginUrl . '/UserAgent/js/instant.page-2.0.0.js';
    			echo '<script src="' . $jsUrl . '" type="module" integrity="sha384-D7B5eODAUd397+f4zNFAVlnDNDtO1ppV8rPnfygILQXhqu3cUndgHvlcJR2Bhig8"></script>';
    				break;	

    		case 'baomitu':
    			echo '<script crossorigin="anonymous" integrity="sha384-RkKxVxUkNzCNeymCLaCBKuTAvEVqbPZJ7xGI/g2QrsADow2m/3TVQFQW86mbjyAA" src="https://lib.baomitu.com/instant.page/2.0.0/instantpage.min.js"></script>';
    			break;

    		default:
    			//none
    			break;	
    	}
    	
    }

    /**
     * 获取浏览器型号
     * @access public
     * @param $ua => $comments->agent
	 * @return $array['title'] => 返回浏览器型号, $array['icon'] => 返回浏览器对应图标
     */	
	public static function get_browsers($ua){
		$title = '非主流浏览器';
		$icon = 'iconfontua icon-globe';
		if(preg_match('/rv:(11.0)/i', $ua, $matches)){
			$title = 'Internet Explorer '. $matches[1];
			$icon = 'iconfontua icon-internet-explorer';//ie11
		}elseif (preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'Internet Explorer '. $matches[1];
			
			if ( strpos($matches[1], '7') !== false || strpos($matches[1], '8') !== false)
				$icon = 'iconfontua icon-internet-explorer';//ie8
			elseif ( strpos($matches[1], '9') !== false)
				$icon = 'iconfontua icon-internet-explorer';//ie9
			elseif ( strpos($matches[1], '10') !== false)
				$icon = 'iconfontua icon-internet-explorer';//ie10
		}elseif (preg_match('#Edge?/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'Edge '. $matches[1];
			$icon = 'iconfontua icon-edge';	
		}elseif (preg_match('#TheWorld ([a-zA-Z0-9.]+)#i', $ua, $matches)){
			$title = 'TheWorld(世界之窗) '. $matches[1];
			$icon = 'iconfontua icon-theworld';
		}elseif (preg_match('#JuziBrowser#i', $ua, $matches)){
			$title = 'Juzi(桔子) '.$matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('#KBrowser#i', $ua, $matches)){
			$title = 'KBrowser(超快) '.$matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('#MyIE#i', $ua, $matches)){
			$title = 'MyIE(蚂蚁) '.$matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('#(?:Firefox|Phoenix|Firebird|BonEcho|GranParadiso|Minefield|Iceweasel)/([a-zA-Z0-9.]+)#i', $ua, $matches)){
			$title = 'Firefox '. $matches[1];
			$icon = 'iconfontua icon-firefox';
		}elseif (preg_match('#CriOS/([a-zA-Z0-9.]+)#i', $ua, $matches)){
			$title = 'Chrome for iOS '. $matches[1];
			$icon = 'iconfontua icon-chrome';
		} elseif (preg_match('#(?:LieBaoFast|LBBROWSER)/?([a-zA-Z0-9.]+)#i', $ua, $matches)) {
            $title = '猎豹 '. $matches[1];
			$icon = 'iconfontua icon-liebaoliulanqi';
		}elseif (preg_match('#Opera.(.*)Version[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'Opera '. $matches[2];
			$icon = 'iconfontua icon-opera';
			if (preg_match('#opera mini#i', $ua)) 
				$title = 'Opera Mini '. $matches[2];
		}elseif (preg_match('#OPR/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'Opera '. $matches[1];
			$icon = 'iconfontua icon-opera';
		}elseif (preg_match('#Maxthon( |\/)([a-zA-Z0-9.]+)#i', $ua,$matches)) {
			$title = 'Maxthon(遨游) '. $matches[2];
			$icon = 'iconfontua icon-liulanqi-aoyou';
		}elseif (preg_match('/360/i', $ua, $matches)) {
			$title = '360浏览器';//放弃360怪异UA
			$icon = 'iconfontua icon-browser-360';
			if (preg_match('/Alitephone Browser/i', $ua)) {
				$title = '360极速浏览器';
				$icon = 'iconfontua icon-liulanqi-jisu';
			}
		}elseif (preg_match('#(?:SE |SogouMobileBrowser/)([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '搜狗浏览器 '.$matches[1];
			$icon = 'iconfontua icon-liulanqi-sougou';
		}elseif (preg_match('#QQ/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'QQ '.$matches[1];
			$icon = 'iconfontua icon-qq';
		}elseif (preg_match('#MicroMessenger/([a-zA-Z0-9.]+)#i', $ua,$matches)) {
			$title = '微信 '. $matches[1];
			$icon = 'iconfontua icon-wechat';
		}elseif (preg_match('#QQBrowser/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'QQ浏览器 '.$matches[1];
			$icon = 'iconfontua icon-QQliulanqi';
		}elseif (preg_match('#YYE/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'YY浏览器 '.$matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('#115Browser/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '115 '.$matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('#37abc/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '37abc '.$matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('#UCWEB([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'UC '. $matches[1];
			$icon = 'iconfontua icon-ucliulanqi';
		}elseif (preg_match('#UC?Browser/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'UC '. $matches[1];
			$icon = 'iconfontua icon-ucliulanqi';
		}elseif (preg_match('#Quark/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '夸克 '. $matches[1];
			$icon = 'iconfontua icon-kuakeliulanqi';
		}elseif (preg_match('#2345(?:Explorer|Browser)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '2345浏览器 '. $matches[1];
			$icon = 'iconfontua icon-globe';	
		}elseif (preg_match('#XiaoMi/MiuiBrowser/([0-9.]+)#i', $ua, $matches)) {
			$title = '小米 '. $matches[1];
			$icon = 'iconfontua icon-xiaomi';	
		}elseif (preg_match('#SamsungBrowser/([0-9.]+)#i', $ua, $matches)) {
			$title = '三星 '. $matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('/WeiBo/i', $ua, $matches)) {
			$title = '微博 '. $matches[1];
			$icon = 'iconfontua icon-weibo';
		}elseif (preg_match('/BIDU/i', $ua, $matches)) {
			$title = '百度 '. $matches[1];
			$icon = 'iconfontua icon-browser-baidu';
		}elseif (preg_match('#baiduboxapp/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '百度 '. $matches[1];
			$icon = 'iconfontua icon-browser-baidu';	
		}elseif (preg_match('#SearchCraft/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '简单搜索 '. $matches[1];
			$icon = 'iconfontua icon-browser-baidu';
		}elseif (preg_match('#Qiyu/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = '旗鱼浏览器 '. $matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('/mailapp/i', $ua, $matches)) {
			$title = 'EmailApp '. $matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('/Sleipnir/i', $ua, $matches)) {
			$title = '神马 '. $matches[1];
			$icon = 'iconfontua icon-browser-shenma';
		}elseif (preg_match('/MZBrowser/i', $ua, $matches)) {
			$title = '魅族 '. $matches[1];
			$icon = 'iconfontua icon-meizu';
		}elseif (preg_match('/VivoBrowser/i', $ua, $matches)) {
			$title = 'ViVO '. $matches[1];
			$icon = 'iconfontua icon-VIVO';
		}elseif (preg_match('/mixia/i', $ua, $matches)) {
			$title = '米侠 '. $matches[1];
			$icon = 'iconfontua icon-globe';
		}elseif (preg_match('/CoolMarket/i', $ua, $matches)) {
			$title = '酷安 '. $matches[1];
			$icon = 'iconfontua icon-coolapk';	
		}elseif (preg_match('#YaBrowser/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'Yandex '. $matches[1];
			$icon = 'iconfontua icon-yandex';	
		}elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'Google Chrome '. $matches[1];
			$icon = 'iconfontua icon-chrome';
		}elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$title = 'Safari '. $matches[1];
			$icon = 'iconfontua icon-safari';
		}
		return array('title' => $title, 'icon' => $icon);
	}

    /**
     * 获取操作系统类型
     * @access public
     * @param $ua => $comments->agent
     * @return $array['title'] => 返回操作系统类型, $array['icon'] => 返回操作系统对应图标 
     */
	public static function get_os($ua){
		$title = '非主流操作系统';
		$icon = 'iconfontua icon-search';
		if (preg_match('/win/i', $ua)) {
			if (preg_match('/Windows NT 6.1/i', $ua)) {
				$title = "Windows 7";
				$icon = "iconfontua icon-win";
			}elseif (preg_match('/Windows 98/i', $ua)) {
				$title = "Windows 98";
				$icon = "iconfontua icon-win2";
			}elseif (preg_match('/Windows NT 5.0/i', $ua)) {
				$title = "Windows 2000";
				$icon = "iconfontua icon-win2";	
			}elseif (preg_match('/Windows NT 5.1/i', $ua)) {
				$title = "Windows XP";
				$icon = "iconfontua icon-win";
			}elseif (preg_match('/Windows NT 5.2/i', $ua)) {
				if (preg_match('/Win64/i', $ua)) {
					$title = "Windows XP 64 bit";
				} else {
					$title = "Windows Server 2003";
				}
				$icon = 'iconfontua icon-win';
			}elseif (preg_match('/Windows NT 6.0/i', $ua)) {
				$title = "Windows Vista";
				$icon = "iconfontua icon-windows";
			}elseif (preg_match('/Windows NT 6.2/i', $ua)) {
				$title = "Windows 8";
				$icon = "iconfontua icon-win8";
			}elseif (preg_match('/Windows NT 6.3/i', $ua)) {
				$title = "Windows 8.1";
				$icon = "iconfontua icon-win8";
			}elseif (preg_match('/Windows NT 10.0/i', $ua)) {
				$title = "Windows 10";
				$icon = "iconfontua icon-win3";
			}elseif (preg_match('/Windows Phone/i', $ua)) {
				$matches = explode(';',$ua);
				$title = $matches[2];
				$icon = "iconfontua icon-winphone";
			}
		} elseif (preg_match('#iPod.*.CPU.([a-zA-Z0-9.( _)]+)#i', $ua, $matches)) {
			$title = "iPod ".str_replace('_', '.', $matches[1]);
			$icon = "iconfontua icon-ipod";
		} elseif (preg_match('/iPhone OS ([_0-9]+)/i', $ua, $matches)) {
			$title = "iPhone ".str_replace('_', '.', $matches[1]);
			$icon = "iconfontua icon-iphone";
		} elseif (preg_match('/iPad; CPU OS ([_0-9]+)/i', $ua, $matches)) {
			$title = "iPad ".str_replace('_', '.', $matches[1]);
			$icon = "iconfontua icon-ipad";
		} elseif (preg_match('/Mac OS X ([0-9_]+)/i', $ua, $matches)) {
			if (count(explode(7,$matches[1]))>1) $matches[1] = 'Lion '.$matches[1];
			elseif (count(explode(8,$matches[1]))>1) $matches[1] = 'Mountain Lion '.$matches[1];
			$title = "Mac OS X ".str_replace('_', '.', $matches[1]);

			$icon = "iconfontua icon-MacOS";
		} elseif (preg_match('/Macintosh/i', $ua)) {
			$title = "Mac OS";
			$icon = "iconfontua icon-iconmacos";
		} elseif (preg_match('/CrOS/i', $ua)){
			$title = "Google Chrome OS";
			$icon = "iconfontua icon-iconchromeos";
		} elseif (preg_match('/Android.([0-9. _]+)/i',$ua, $matches)) {
				$title= "Android " . $matches[1];
				$icon = "iconfontua icon-android";	
		} elseif (preg_match('/Linux/i', $ua)) {
			$title = 'Linux';
			$icon = 'iconfontua icon-linux';
			if (preg_match('/Ubuntu/i', $ua)) {
				$title = "Ubuntu Linux";
				$icon = "iconfontua icon-ubuntu";
			} elseif (preg_match('#Debian#i', $ua)) {
				$title = "Debian GNU/Linux";
				$icon = "iconfontua icon-debian";
			} elseif (preg_match('#Fedora#i', $ua)) {
				$title = "Fedora Linux";
				$icon = "iconfontua icon-fedora";
			}
		}	
		return array('title' => $title, 'icon' => $icon);
	}

    /**
     * 嵌入点,输出信息
     * @access public
     * @param $ua => $comments->agent, $ip => $comments->ip
     * @return void
     */	
	public static function get_useragent($ua, $ip=null)
	{
		$options = Typecho_Widget::widget('Widget_Options');
		$plugin_opt = $options->plugin('UserAgent');
		//if (!isset($options->plugins['activated']['UserAgent'])) {
			//return _t('UserAgent插件未激活');
		//}

		//UA仅博主可见
		Typecho_Widget::widget('Widget_User')->to($user);
		if ($user->uid !== '1' && in_array('visible', $plugin_opt->effect)) {
			return;
		}

		$color_info = self::get_color($ua . 'xiaojian');
		$os_info = self::get_os($ua);
		$br_info = self::get_browsers($ua);

		//显示IP位置信息
		if (in_array('loc', $plugin_opt->ip) && (!in_array('visible', $plugin_opt->ip) || $user->uid === '1')) {
			$ip_info = self::get_loc($ip);
			if ($plugin_opt->info) {
				$code_ip = self::get_format($color_info, $ip_info, '', $ip_info);
			} else {
				$code_ip = self::get_format($color_info, $ip_info);	
			}
		}
		
		//显示UA详细信息
		$plugin_opt->info ? $br_info_title=$br_info['title'] : $br_info_title=null ;
		$plugin_opt->info ? $os_info_title=$os_info['title'] : $os_info_title=null ;
		$code_br = self::get_format($color_info, $br_info['title'], $br_info['icon'], $br_info_title);
		$code_os = self::get_format($color_info, $os_info['title'], $os_info['icon'], $os_info_title);

		//显示悬停效果
		$ua_class = in_array('color', $plugin_opt->effect) ? 'class="ua-hover"' : '' ;

		//输出前检查变量是否存在
		//首行 - error_reporting(0);
		//php.ini - error_reporting = E_ALL & ~E_NOTICE
		$code_ip = isset($code_ip) ? $code_ip : '' ;

		//输出信息 - '@' 掩耳盗铃之术
		echo "<span {$ua_class}>" . @$code_br . @$code_os . @$code_ip . '</span>';
	}

    /**
     * 控制输出格式
     */	
	public static function get_format($color, $title, $icon=null, $text=null) 
	{
		empty($icon) ? $icon_code='iconfontua icon-location-arrow' : $icon_code=$icon ;
		$code = '<span class="ua-icon"' . $color . ' data-toggle="tooltip" data-original-title="'. $title .'"><i class="' . $icon_code . ' " aria-hidden="true"></i> ' . $text . '</span>';
		return $code;
	}
	
    /**
     * 获取颜色
     * @access public
     * @param $text => $comments->agent
     * @return $code => 返回style代码
	 *
	 * 灵感来源: https://black1ce.com/website/typecho-ua.html
     */	
	public static function get_color($text)
	{
		if (Helper::options()->plugin('UserAgent')->color) {//随机颜色
			$hash = md5(strtolower($text));
			$color = '#' . substr($hash,9,6);
			$code = 'style="background:' . $color . '"';
		} elseif (Helper::options()->plugin('UserAgent')->color_value == '') {//默认颜色
			$code = 'style="background:#924cda"';
		} else {//自定义颜色
			$code = 'style="background:' . htmlspecialchars(Helper::options()->plugin('UserAgent')->color_value) . '"';
		}
		return $code;
	}

    /**
     * 获取位置信息
     * @access public
     * @param $ip => $comments->ip
     * @return 返回对应IP的位置信息
     */		
	public static function get_loc($ip)
	{
        include_once 'lib/Get_Ip.php';

        try {
        	$response = Get_Ip::find($ip);

    		if (is_array($response)) {
       			$response = array(
					'code' => 0,
					'data' => implode(' ', $response),
				);
				return $response['data'];

			} else {
				throw new Exception('解析ip失败');
			}
        } catch (Exception $e) {
			$type = Helper::options()->plugin('UserAgent')->api;
			$http = Typecho_Http_Client::get();
			$http->setHeader('user-agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36');
			$http->setTimeout(3);
			switch ($type) {
				case 'TaoBao':
					$url = 'http://ip.taobao.com/service/getIpInfo2.php';
					$http->setHeader('referer','http://ip.taobao.com/ipSearch.html');
					$http->setHeader('Host','ip.taobao.com');
					$http->setHeader('Origin','http://ip.taobao.com');
					$http->setData(array('ip'=>$ip));
					break;
				
				case 'SB':
					$url = 'https://api.ip.sb/geoip/' . $ip;
					$http->setHeader('referer','https://ip.sb/api/');
					break;
				
				case 'IpApi':
					$url = 'http://ip-api.com/json/' . $ip . '?lang=zh-CN';
					$http->setHeader('referer','http://ip-api.com');
					$http->setHeader('Accept-Language','zh-CN,zh;q=0.9');
					break;
				
				default:
					$url = 'https://api.ip.sb/geoip/' . $ip;
					$http->setHeader('referer','https://ip.sb/api/');
					break;
			}

			try {
				$json = $http->send($url);
				$msg = json_decode($json);
				if ($msg->code === '1' || $msg->code === '401' || $msg->status ==='fail') {
					return '暂无此IP信息!';
				} elseif ($msg->code === null && $type === 'TaoBao') {
					return '接口速率限制!';
				}
				if ($type === 'TaoBao') {
					return $msg->data->country . ',' . $msg->data->city . ',' . $msg->data->isp;
				} elseif ($type === 'SB') {
					if ($msg->city === null && $msg->country == null) {
						return '暂无此IP信息!';
					} elseif ($msg->city === null) {
						return $msg->country . ' ' . $msg->organization;
					}
					return $msg->city . ', ' . $msg->country . ' ' . $msg->organization;
				} elseif ($type === 'IpApi') {
					return $msg->country . ', ' . $msg->city . ' ' . $msg->org;
				}
			} catch (Exception $e) {
				$msg = '无法获取IP信息!';
				return $msg;
			}        	       	
        }
	}
	
	public static function get_Uagent($ua, $ip=null)
	{
		$options = Typecho_Widget::widget('Widget_Options');
		$plugin_opt = $options->plugin('UserAgent');
		//if (!isset($options->plugins['activated']['UserAgent'])) {
			//return _t('UserAgent插件未激活');
		//}

		//UA仅博主可见
		Typecho_Widget::widget('Widget_User')->to($user);
		if ($user->uid !== '1' && in_array('visible', $plugin_opt->effect)) {
			return;
		}

		$color_info = self::get_color($ua . 'xiaojian');
		$os_info = self::get_os($ua);
		$br_info = self::get_browsers($ua);

		//显示IP位置信息
		if (in_array('loc', $plugin_opt->ip) && (!in_array('visible', $plugin_opt->ip) || $user->uid === '1')) {
			$ip_info = self::get_loc($ip);
			if ($plugin_opt->info) {
				$code_ip = self::get_mymat($color_info, $ip_info, '', $ip_info);
			} else {
				$code_ip = self::get_mymat($color_info, $ip_info, '', $ip_info);
			}
		}
		
		//显示UA详细信息
		$plugin_opt->info ? $br_info_title=$br_info['title'] : $br_info_title=$br_info['title'] ;
		$plugin_opt->info ? $os_info_title=$os_info['title'] : $os_info_title=$os_info['title'] ;
		$code_br = self::get_mymat($color_info, $br_info['title'], $br_info['icon'], $br_info_title);
		$code_os = self::get_mymat($color_info, $os_info['title'], $os_info['icon'], $os_info_title);

		//显示悬停效果
		$ua_class = in_array('color', $plugin_opt->effect) ? 'class="ua-hover"' : '' ;

		//输出前检查变量是否存在
		//首行 - error_reporting(0);
		//php.ini - error_reporting = E_ALL & ~E_NOTICE
		$code_ip = isset($code_ip) ? $code_ip : '' ;

		//输出信息 - '@' 掩耳盗铃之术
		echo "浏览器:". @$br_info['title'] ."<br>系统:" .  @$os_info['title'] ."<br>&nbsp;位置:" . @$ip_info ."<br>&nbsp;IP:" .@$ip;
		
	}
	
	public static function get_Uagents($ua, $ip=null)
	{
		$options = Typecho_Widget::widget('Widget_Options');
		$plugin_opt = $options->plugin('UserAgent');
		//if (!isset($options->plugins['activated']['UserAgent'])) {
			//return _t('UserAgent插件未激活');
		//}

		//UA仅博主可见
		Typecho_Widget::widget('Widget_User')->to($user);
		if ($user->uid !== '1' && in_array('visible', $plugin_opt->effect)) {
			return;
		}

		$color_info = self::get_color($ua . 'xiaojian');
		$os_info = self::get_os($ua);
		$br_info = self::get_browsers($ua);

		//显示IP位置信息
		if (in_array('loc', $plugin_opt->ip) && (!in_array('visible', $plugin_opt->ip) || $user->uid === '1')) {
			$ip_info = self::get_loc($ip);
			if ($plugin_opt->info) {
				$code_ip = self::get_mymat($color_info, $ip_info, '', $ip_info);
			} else {
				$code_ip = self::get_mymat($color_info, $ip_info, '', $ip_info);
			}
		}
		
		//显示UA详细信息
		$plugin_opt->info ? $br_info_title=$br_info['title'] : $br_info_title=$br_info['title'] ;
		$plugin_opt->info ? $os_info_title=$os_info['title'] : $os_info_title=$os_info['title'] ;
		$code_br = self::get_mymat($color_info, $br_info['title'], $br_info['icon'], $br_info_title);
		$code_os = self::get_mymat($color_info, $os_info['title'], $os_info['icon'], $os_info_title);

		//显示悬停效果
		$ua_class = in_array('color', $plugin_opt->effect) ? 'class="ua-hover"' : '' ;

		//输出前检查变量是否存在
		//首行 - error_reporting(0);
		//php.ini - error_reporting = E_ALL & ~E_NOTICE
		$code_ip = isset($code_ip) ? $code_ip : '' ;

		//输出信息 - '@' 掩耳盗铃之术
		echo "<br>浏览器：". @$br_info['title'] ."<br>系统：" .  @$os_info['title'] ."<br>&nbsp;位置：" . @$ip_info ."<br>&nbsp;IP地址：" .@$ip."</br>";
		
	}
	
	
	public static function get_Uagents_Notecho($ua, $ip=null)
	{
		$options = Typecho_Widget::widget('Widget_Options');
		$plugin_opt = $options->plugin('UserAgent');
		//if (!isset($options->plugins['activated']['UserAgent'])) {
			//return _t('UserAgent插件未激活');
		//}

		//UA仅博主可见
		Typecho_Widget::widget('Widget_User')->to($user);
		if ($user->uid !== '1' && in_array('visible', $plugin_opt->effect)) {
			return;
		}

		$color_info = self::get_color($ua . 'xiaojian');
		$os_info = self::get_os($ua);
		$br_info = self::get_browsers($ua);

		//显示IP位置信息
		if (in_array('loc', $plugin_opt->ip) && (!in_array('visible', $plugin_opt->ip) || $user->uid === '1')) {
			$ip_info = self::get_loc($ip);
			if ($plugin_opt->info) {
				$code_ip = self::get_mymat($color_info, $ip_info, '', $ip_info);
			} else {
				$code_ip = self::get_mymat($color_info, $ip_info, '', $ip_info);
			}
		}
		
		//显示UA详细信息
		$plugin_opt->info ? $br_info_title=$br_info['title'] : $br_info_title=$br_info['title'] ;
		$plugin_opt->info ? $os_info_title=$os_info['title'] : $os_info_title=$os_info['title'] ;
		$code_br = self::get_mymat($color_info, $br_info['title'], $br_info['icon'], $br_info_title);
		$code_os = self::get_mymat($color_info, $os_info['title'], $os_info['icon'], $os_info_title);

		//显示悬停效果
		$ua_class = in_array('color', $plugin_opt->effect) ? 'class="ua-hover"' : '' ;

		//输出前检查变量是否存在
		//首行 - error_reporting(0);
		//php.ini - error_reporting = E_ALL & ~E_NOTICE
		$code_ip = isset($code_ip) ? $code_ip : '' ;

		//输出信息 - '@' 掩耳盗铃之术
		return "<br>浏览器：". @$br_info['title'] ."<br>系统：" .  @$os_info['title'] ."<br>&nbsp;位置：" . @$ip_info ."<br>&nbsp;IP地址：" .@$ip."</br>";
		
	}
	
	public static function get_mymat($color, $title, $icon=null, $text=null) 
	{
		empty($icon) ? $icon_code='iconfontua icon-location-arrow' : $icon_code=$icon ;
		$code = '<span class="ua-icon"' . $color . ' data-toggle="tooltip" data-original-title="'. $title .'"><i class="' . $icon_code . ' " aria-hidden="true"></i> ' . $text . '</span>';
		return $code;
	}
}
