<?php

namespace koenigseggposche\yii2ace;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class AceEditor
 * @package koenigseggposche\yii2ace
 * @author liwei <koenigseggposche@gmail.com>
 */
class AceEditor extends InputWidget
{
    /**
     * @var string Programming Language Mode
     */
    public $mode = 'html';

    /**
     * @var array Editor options
     */
    public $aceOptions = [];

    /**
     * @var array ace extensions
     */
    public $extensions = [];

    /**
     * @var string Editor theme
     * $see Themes List
     * @link https://github.com/ajaxorg/ace/tree/master/lib/ace/theme
     */
    public $theme = 'github';

    /**
     * @var array Div options
     */
    public $containerOptions = [
        'style' => 'width: 100%; min-height: 400px'
    ];

    /**
     * @var string js
     */
    public $js = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        AceEditorAsset::register($this->getView(), $this->extensions);
        $editor_id = $this->getId();
        $editor_var = 'aceeditor_' . $editor_id;
        $this->getView()->registerJs("var {$editor_var} = ace.edit(\"{$editor_id}\")");
        $this->getView()->registerJs("{$editor_var}.setTheme(\"ace/theme/{$this->theme}\")");
        $this->getView()->registerJs("{$editor_var}.getSession().setMode(\"ace/mode/{$this->mode}\")");
        if ($this->aceOptions) {
            $this->getView()->registerJs("{$editor_var}.setOptions(" . json_encode($this->aceOptions) . ")");
        }

        $textarea_var = 'acetextarea_' . $editor_id;
        $this->getView()->registerJs("
            var {$textarea_var} = $('#{$this->options['id']}').hide();
            {$editor_var}.getSession().setValue({$textarea_var}.val());
            {$editor_var}.getSession().on('change', function(){
                {$textarea_var}.val({$editor_var}.getSession().getValue());
            });
        ");
        Html::addCssStyle($this->options, 'display: none');
        $this->containerOptions['id'] = $editor_id;
        $this->getView()->registerCss("#{$editor_id}{position:relative}");

        if ($this->js) {
            $this->getView()->registerJs($this->js);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $content = Html::tag('div', '', $this->containerOptions);
        if ($this->hasModel()) {
            $content .= Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $content .= Html::textarea($this->name, $this->value, $this->options);
        }
        return $content;
    }
}
