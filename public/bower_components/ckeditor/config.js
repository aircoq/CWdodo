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
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup'] },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
        { name: 'styles' , groups: ['Font', 'FontSize']},
        { name: 'colors' },
        {name: 'paragraph', groups: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }, //对齐栏：左对齐、中心对齐、右对齐、两端对齐
    ];

    // 去除下划线，上标下标
    config.removeButtons = 'Underline,Subscript,Superscript';
    // 设置加粗样式
    config.format_tags = 'p;h1;h2;h3;pre';
    // 简化对话框窗口
    config.removeDialogTabs = 'image:advanced;link:advanced';
    // 界面语言，默认为 'en'
    config.language = 'zh-cn';
    // 设置宽度
    config.width = "70%";
    // 设置是使用绝对目录还是相对目录，为空为相对目录
    config.baseHref = '';
    /*去掉图片预览框的文字*/
    config.image_previewText = ' ';
    // 对应后台语言的类型来对输出的HTML内容进行格式化，默认为空
    config.protectedSource.push( /<"?["s"S]*?"?>/g );
    //载入时，以何种方式编辑 源码和所见即所得 "source"和"wysiwyg" plugins/editingblock/plugin.js.
    config.startupMode ='wysiwyg';
    // 撤销的记录步数 plugins/undo/plugin.js
    config.undoStackSize =20;
    // 字体编辑时的字符集 可以添加常用的中文字符：宋体、楷体、黑体等 plugins/font/plugin.js
    config.font_names ='宋体;楷体;新宋体;黑体;隶书;幼圆;微软雅黑;Arial;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana';
    // 在清除图片属性框中的链接属性时 是否同时清除两边的<a>标签 plugins/image/plugin.js
    config.image_removeLinkByEmptyURL = true;
    //文字方向
    config.contentsLangDirection ='ltr'; //从左到右
    //字体编辑时可选的字体大小 plugins/font/plugin.js
    config.fontSize_sizes ='8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px';
    //起始的索引值
    config.tabIndex = 0;
    //当用户键入TAB时，编辑器走过的空格数，(&nbsp;) 当值为0时，焦点将移出编辑框 plugins/tab/plugin.js
    config.tabSpaces = 0;
    config.extraPlugins = 'uploadimage,imagepaste';

};
