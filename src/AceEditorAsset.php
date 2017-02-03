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
        'ace.js'
    ];

} 
