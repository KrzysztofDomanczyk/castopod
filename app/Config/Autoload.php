<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTO-LOADER
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * This maps the locations of any namespaces in your application to
     * their location on the file system. These are used by the autoloader
     * to locate files the first time they have been instantiated.
     *
     * The '/app' and '/system' directories are already mapped for you.
     * you may change the name of the 'App' namespace if you wish,
     * but this should be done prior to creating any namespaced classes,
     * else you will need to modify all of those classes for this to work.
     *
     * Prototype:
     *
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'	       => APPPATH
     *   ];
     *
     * @var array<string, string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH,
        'Modules' => ROOTPATH . 'modules/',
        'Modules\Admin' => ROOTPATH . 'modules/Admin/',
        'Modules\Auth' => ROOTPATH . 'modules/Auth/',
        'Modules\Analytics' => ROOTPATH . 'modules/Analytics/',
        'Modules\Install' => ROOTPATH . 'modules/Install/',
        'Modules\Update' => ROOTPATH . 'modules/Update/',
        'Modules\Fediverse' => ROOTPATH . 'modules/Fediverse/',
        'Modules\Media' => ROOTPATH . 'modules/Media/',
        'Modules\WebSub' => ROOTPATH . 'modules/WebSub/',
        'Modules\Api\Rest\V1' => ROOTPATH . 'modules/Api/Rest/V1',
        'Modules\PremiumPodcasts' => ROOTPATH . 'modules/PremiumPodcasts/',
        'Config' => APPPATH . 'Config/',
        'ViewComponents' => APPPATH . 'Libraries/ViewComponents/',
        'ViewThemes' => APPPATH . 'Libraries/ViewThemes/',
        'MediaClipper' => APPPATH . 'Libraries/MediaClipper/',
        'Vite' => APPPATH . 'Libraries/Vite/',
        'Themes' => ROOTPATH . 'themes',
    ];

    /**
     * -------------------------------------------------------------------
     * Class Map
     * -------------------------------------------------------------------
     * The class map provides a map of class names and their exact
     * location on the drive. Classes loaded in this manner will have
     * slightly faster performance because they will not have to be
     * searched for within one or more directories as they would if they
     * were being autoloaded through a namespace.
     *
     * Prototype:
     *
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     *
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * -------------------------------------------------------------------
     * Files
     * -------------------------------------------------------------------
     * The files array provides a list of paths to __non-class__ files
     * that will be autoloaded. This can be useful for bootstrap operations
     * or for loading functions.
     *
     * Prototype:
     * ```
     *	  $files = [
     *	 	   '/path/to/my/file.php',
     *    ];
     * ```
     * @var array<int, string>
     */
    public $files = [APPPATH . 'Libraries/ViewComponents/Helpers/view_components_helper.php'];
}
