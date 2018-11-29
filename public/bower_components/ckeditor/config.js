/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';
	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';
	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	// 界面语言，默认为 'en'
    config.language = 'zh-cn';
    // 改变大小的最大高度
    config.resize_maxHeight = 3000;
    // 设置是使用绝对目录还是相对目录，为空为相对目录
    config.baseHref = '';
    // 对应后台语言的类型来对输出的HTML内容进行格式化，默认为空
    config.protectedSource.push( /<"?["s"S]*?"?>/g );
     //载入时，以何种方式编辑 源码和所见即所得 "source"和"wysiwyg" plugins/editingblock/plugin.js.
    config.startupMode ='wysiwyg';
    // 撤销的记录步数 plugins/undo/plugin.js
    config.undoStackSize =20;
    config.image_previewText = '';
    config.removeDialogTabs = 'image:advanced;image:Link';
};
