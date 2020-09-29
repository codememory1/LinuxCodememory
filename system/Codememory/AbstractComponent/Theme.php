<?php

namespace System\Codememory\AbstractComponent;

use File;
use Store;
use Customize;

/**
 * Class View
 * @package System\Codememory\AbstractComponent
 */
class Theme
{

    const PATCH_THEME = 'resources/Theme';

    /**
     * @param $params
     */
    public static function loadTheme($params)
    {
        
        extract($params['method']);
        
        $settings = Customize::get('Settings', 'Settings');
        (is_array($settings)) ? extract($settings) : null;
        
        $theme = (isset($params['params'][0])) ? $params['params'][0].'/' : $layout.'/';
		
		File::import('resources/Theme/'.$theme.'/'.$method.'.php');

        
    }

    /**
     * @return bool
     */
    private static function hasEmpty()
    {

        $scan = Store::scan(static::PATCH_THEME);

        if(count($scan) < 1)
        {
            return false;
        }

        return true;

    }

    /**
     * @return array|bool|false|string
     */
    public static function lists()
    {

        $hasList = (self::hasEmpty() === false) ? 'Themes folder is empty!' : true;

        if($hasList === true)
        {

            $scan = Store::scan(static::PATCH_THEME);

            for($i = 0; $i < count($scan); $i++)
            {
                if(strpos($scan[$i], '.php'))
                {
                    unset($scan[$i]);
                    return $scan;
                }

            }

        }
        return $hasList;

    }
    
}