<?php

namespace Gee;


use Assetic\FilterManager;
use Assetic\AssetWriter;
use Assetic\Filter\UglifyCssFilter;
use Assetic\Filter\UglifyJs2Filter;
use Assetic\AssetManager;
use Assetic\Asset\GlobAsset;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;

class Assetic {

	private $am;
	private $fm;
	private $css;
	private $js;

	public function __construct() {
		$this->am = new AssetManager();
		$this->fm = new FilterManager();

		$this->fm->set('cssmin', new UglifyCssFilter('uglifycss'));
		$this->fm->set('jsmin', new UglifyJs2Filter('uglifyjs'));

		$this->css = new GlobAsset('css/*.css',$this->fm->get('cssmin'));
		$this->js = new AssetCollection(array(
			new FileAsset('js/tmpl/jquery.min.js'),
			new FileAsset('js/tmpl/angular.min.js'),
			new FileAsset('js/tmpl/angular-cookies.min.js'),
			new FileAsset('js/tmpl/angular-resource.js'),
			new FileAsset('js/tmpl/angular-ui-router.min.js'),
			new FileAsset('js/tmpl/bootstrap.min-1.03.js'),
			new FileAsset('js/tmpl/jquery.slimscroll.min.js'),
			new FileAsset('js/tmpl/jquery.touchSwipe.min.js'),
			new FileAsset('js/tmpl/jquery.elastic.source.js'),
			new FileAsset('js/tmpl/jquery.magnific-popup.min.js'),
			new FileAsset('js/tmpl/dropzone.min.js'),
			new FileAsset('js/tmpl/underscore.js'),
			new FileAsset('js/tmpl/moment.js'),
			new FileAsset('js/tmpl/zh-cn.js'),
			new FileAsset('js/tmpl/highlight.pack.js'),
			new FileAsset('js/tmpl/codemirror.js'),
			new FileAsset('js/tmpl/javascript.js'),
			new FileAsset('js/tmpl/md5.min.js'),
			new GlobAsset('js/*.js'),
			new GlobAsset('js/controllers/*.js'),
			new GlobAsset('js/directives/*.js'),
			new GlobAsset('js/filters/*.js'),
			new GlobAsset('js/services/*.js'),
		), $this->fm->get('jsmin'));

		$this->css->setTargetPath('assetic/app.css');
		$this->js->setTargetPath('assetic/app.js');

		$this->am->set('css', $this->css);
		$this->am->set('js', $this->js);

		$writer = new AssetWriter(PUBLICPATH);
		$writer->writeManagerAssets($this->am);

	}

	public function result() {
		return array('css' => $this->css, 'js' => $this->js);
	}

	public function init() {
		// $am = new AssetManager();
		// $am->set('css', new GlobAsset('css/*'));

		// $fm = new FilterManager();
		// $fm->set('cssmin', new UglifyCssFilter('uglifycss'));
		// $fm->set('jsmin', new UglifyJs2Filter('uglifyjs'));

		// // 設置 Asset 目錄,打開 Debug,指定 Filter,輸出模式
		// $asset_factory = new AssetFactory(PUBLICPATH);
		// $asset_factory->setFilterManager($fm);
		// $asset_factory->setAssetManager($am);
		// $asset_factory->setDebug(false);
		// $asset_factory->addWorker(new CacheBustingWorker());

		// $css = $asset_factory->createAsset(array(
		// 	    '@css',
		// 	), array(
		// 	    'cssmin'
		// 	));

		// $css->setTargetPath('all.css');

		/** assetic 设置 */

		
		/** end assetic 设置*/
	}
}