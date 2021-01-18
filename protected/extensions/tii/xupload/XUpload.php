<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');
/**
 * XUpload extension for Yii.
 *
 * jQuery file upload extension for Yii, allows your users to easily upload files to your server using jquery
 * Its a wrapper of  http://blueimp.github.com/jQuery-File-Upload/
 *
 * @author AsgarothBelem <asgaroth.belem@gmail.com>
 * @link http://blueimp.github.com/jQuery-File-Upload/
 * @link https://github.com/Asgaroth/xupload
 * @version 0.2
 *
 */
class XUpload extends CJuiInputWidget {

    /**
     * the url to the upload handler
     * @var string
     */
    public $url;

    /**
     * The upload template id to display files available for upload
     * defaults to null, meaning using the built-in template
     */
    public $uploadTemplate="#template-upload";

    /**
     * The template id to display files available for download
     * defaults to null, meaning using the built-in template
     */
    public $downloadTemplate="#template-download";
    
    /**
     * Wheter or not to preview image files before upload
     */
    public $previewImages = true;

    /**
     * Wheter or not to add the image processing pluing
     */
    public $imageProcessing = true;
    
	/**
	 * @var string name of the form view to be rendered
	 */
	public $method = 'post';

    /**
     * Publishes the required assets
     */
    public function init() 
    {
        parent::init();
        $this -> publishAssets();
         echo CHtml::beginForm($this->url, $this->method, array('id'=>$this->id,'enctype'=>'multipart/form-data'));
    }

    /**
     * Generates the required HTML and Javascript
     */
    public function run() 
    {
        echo CHtml::endForm();
        $options = CJavaScript::encode($this->options);
        Yii::app() -> clientScript -> registerScript(__CLASS__ . '#' . $this->id, "jQuery('#{$this->id}').fileupload({$options});", CClientScript::POS_READY);
    }

    /**
     * Publises and registers the required CSS and Javascript
     * @throws CHttpException if the assets folder was not found
     */
    public function publishAssets() {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app() -> assetManager -> publish($assets);
        if (is_dir($assets)) {
            //@ALEXTODO make ui interface optional
            Yii::app() -> clientScript -> registerCssFile($baseUrl . '/css/jquery.fileupload-ui.css');
            //The Templates plugin is included to render the upload/download listings
            Yii::app() -> clientScript -> registerScriptFile("http://blueimp.github.com/JavaScript-Templates/tmpl.min.js", CClientScript::POS_END);
            // The basic File Upload plugin
            Yii::app() -> clientScript -> registerScriptFile($baseUrl . '/js/jquery.fileupload.js', CClientScript::POS_END);
            if($this->previewImages || $this->imageProcessing){
                Yii::app() -> clientScript -> registerScriptFile("http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js", CClientScript::POS_END);
                Yii::app() -> clientScript -> registerScriptFile("http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js", CClientScript::POS_END);
            }
            //The Iframe Transport is required for browsers without support for XHR file uploads
            Yii::app() -> clientScript -> registerScriptFile($baseUrl . '/js/jquery.iframe-transport.js', CClientScript::POS_END);
            // The File Upload image processing plugin
            if($this->imageProcessing){
                Yii::app() -> clientScript -> registerScriptFile($baseUrl . '/js/jquery.fileupload-ip.js', CClientScript::POS_END);
            }
            //The File Upload user interface plugin
            Yii::app() -> clientScript -> registerScriptFile($baseUrl . '/js/jquery.fileupload-ui.js', CClientScript::POS_END);
            //The localization script
            Yii::app() -> clientScript -> registerScriptFile($baseUrl . '/js/locale.js', CClientScript::POS_END);
            /**
             <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
             <!--[if gte IE 8]><script src="<?php echo Yii::app()->baseUrl; ?>/js/cors/jquery.xdr-transport.js"></script><![endif]-->
             *
             */
        } else {
            throw new CHttpException(500, __CLASS__ . ' - Error: Couldn\'t find assets to publish.');
        }
    }

}
