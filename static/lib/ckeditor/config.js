/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
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

	// config.language = 'ko';			//언어설정
	// config.uiColor = '#EEEEEE';		//ui 색상
	// config.height = '300px';		//Editor 높이  
	// config.width = '777px';			//Editor 넓이
	// config.contentsCss = ['/css/style.css'],['/css/main.css'];	//홈페이지에서 사용하는 Css 파일 인클루드
	// config.font_defaultLabel = 'Gulim';	
	// config.font_names='Gulim/Gulim;Dotum/Dotum;Batang/Batang;Gungsuh/Gungsuh/Arial/Arial;Tahoma/Tahoma;Verdana/Verdana';
	// config.fontSize_defaultLabel = '12px';
	// config.fontSize_sizes='8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;';
	// config.enterMode =CKEDITOR.ENTER_BR;		//엔터키 입력시 br 태그 변경
	config.shiftEnterMode = CKEDITOR.ENTER_P;	//엔터키 입력시 p 태그로 변경
	// config.startupFocus = true;					// 시작시 포커스 설정
	// config.allowedContent = true;				// 기본적인 html이 필터링으로 지워지는데 필터링을 하지 않는다.
	// config.filebrowserImageUploadUrl = '/include/editor/upload/upload.asp';		//이미지 업로드 경로 (설정하면 업로드 플러그인에 탭이생김)
	// config.filebrowserFlashUploadUrl = '/include/editor/upload/upload.asp;';		//플래쉬 업로드 경로 (설정하면 업로드 플러그인에 탭이생김)	
	// config.toolbarCanCollapse = true;		//툴바가 접히는 기능을 넣을때 사용합니다.
	// config.docType = "<!DOCTYPE html>";		//문서타입 설정
};
