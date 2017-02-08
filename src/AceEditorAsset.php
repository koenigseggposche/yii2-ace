<?php

namespace koenigseggposche\yii2ace;

use yii\web\AssetBundle;

/**
 * Class AceEditorAsset
 * @package koenigseggposche\yii2ace
 * @author liwei <koenigseggposche@gmail.com>
 */
class AceEditorAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/ace-builds/src-min-noconflict';

    /**
     * @inheritdoc
     */
    public $js = [
        'ace.js',
    ];

    /**
     * @param \yii\web\View $view
     * @param array $extensions
     * @return static
     */
    public static function register($view, $extensions = [])
    {
        $bundle = parent::register($view);

        foreach ($extensions as $_ext) {
            $view->registerJsFile($bundle->baseUrl . "/ext-{$_ext}.js", ['depends' => [static::className()]], "ACE_EXT_" . $_ext);
        }

        return $bundle;
    }
} 
