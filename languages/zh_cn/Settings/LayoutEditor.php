<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * 简体中文语言包 - 布局与字段编辑
 * 版本: 7.1.0 
 * 作者: Maie | www.maie.name
 * 更新日期: 2018-01-08
 * All Rights Reserved.
 *************************************************************************************/
$languageStrings = array(	
	'LayoutEditor' => '布局编辑器',
	'LBL_FIELDS_AND_LAYOUT_EDITOR' => '字段和布局编辑器',
	'LBL_CREATE_CUSTOM_FIELD' => '创建自定义字段',
	'LBL_DETAILVIEW_LAYOUT' => '详细视图布局',
	'LBL_ARRANGE_RELATED_TABS' => '排列相关标签',
	'LBL_ADD_CUSTOM_FIELD' => '添加自定义字段',
	'LBL_ADD_CUSTOM_BLOCK' => '添加自定义区块',
	'LBL_SAVE_FIELD_SEQUENCE' => '保存字段顺序',
	'LBL_BLOCK_NAME' => '区块名称',
	'LBL_ADD_AFTER' => '添加到此区块后面',
	'LBL_ACTIONS' => '操作',	
	'LBL_ALWAYS_SHOW' => '总是显示',
	'LBL_SHOW_INACTIVE_FIELDS' => '显示禁用的字段',
	'LBL_SHOW_HIDDEN_FIELDS' => '显示隐藏字段',
	'LBL_DELETE_CUSTOM_BLOCK' => '删除自定义区块',
	'LBL_MANDATORY_FIELD' => '必填字段',
	'LBL_ACTIVE' => '启用',
	'LBL_QUICK_CREATE' => '快速创建',
	'LBL_SUMMARY_FIELD' => '摘要视图',
	'LBL_KEY_FIELD_VIEW' => '关键字段视图',
	'LBL_MASS_EDIT' => '批量编辑',
	'LBL_DEFAULT_VALUE' => '默认值',
	'LBL_SELECT_FIELD_TYPE' => '选择字段类型',
	'LBL_LABEL_NAME' => '标签名',
	'LBL_LENGTH' => '长度',
	'LBL_DECIMALS' => '小数',
	'LBL_ENTER_PICKLIST_VALUES' => '请依次输入选择列表选项值...',
	'LBL_PICKLIST_VALUES' => '选择列表选项值',
	'LBL_INACTIVE_FIELDS' => '未启用字段',
	'LBL_REACTIVATE' => '重新启用',	
	'LBL_ARRANGE_RELATED_LIST' => '排列相关列表',	
	'LBL_SELECT_MODULE_TO_ADD' => '选择要添加的模块',
	'LBL_SELECT_HIDDEN_MODULE' => '选择隐藏模块',
	'LBL_NO_RELATED_INFORMATION' => '没有相关信息',
	'LBL_RELATED_LIST_INFO' => '按住鼠标拖动模块可以重新排序',							
	'LBL_REMOVE_INFO' => '点击关闭图标从列表中移除模块',
	'LBL_ADD_MODULE_INFO' => '从移除的模块中选择模块可以重新添加到列表中',	
	'LBL_MANY_MANY_TEXT' => '多对多关系仅适用于 %s 和 %s',
	'LBL_SELECT_MODULE' => '选择模块..',
	'LBL_DUPLICATES_EXIST' => '区块名称已存在',		
	'LBL_NON_ROLE_BASED_PICKLIST' => '非基于角色的选择列表',
	'LBL_DUPLICATE_FIELD_EXISTS' => '存在重复字段',
	'LBL_WRONG_FIELD_TYPE' => '错误的字段类型',
	'LBL_ROLE_BASED_PICKLIST' => '基于角色的选择列表',
	'LBL_CLICK_HERE_TO_EDIT' => '点击这里编辑',
	'LBL_EDIT_FIELD' => '编辑字段属性：%s',

	//Field Types
	'Text'=>'文本',
	'Decimal'=>'小数',
	'Integer'=>'整数',
	'Percent'=>'百分数',
	'Currency'=>'货币',
	'Date'=>'日期',
	'Email'=>'Email',
	'Phone'=>'电话号码',
	'Picklist'=>'选择列表',
	'MultiSelectCombo'=>'多选组合框',
	'URL' => '链接',
	'Checkbox' => '复选框',
	'TextArea' => '文本区域',
	'Skype'=>'Skype',
	'Time'=>'时间',
	'Datetime'=>'日期时间',
	'Relation'=>'关联',
	'Owner'=>'所有者',
	'ProductTax'=>'产品税',
	'CurrencyList'=>'货币列表',
	'DocumentsFolder'=>'文档文件夹',
	'DocumentsFileUpload'=>'文档文件上传',
	'FileLocationType'=>'文件位置类型',
	
	//Translation for module
	'Calendar' => '任务',
	'LBL_FIELD_COULD_NOT_BE_CREATED'=>'不能创建 %s 字段',
	'SELECT_MODULE' => '选择模块',
	
    //Related Lists 
    'LBL_RELATION_SHIPS' => '模块关联',
    'LBL_ADD_RELATIONSHIP' => '添加关联',
    'LBL_RELATED_MODULE' => '关联模块',
    'LBL_ADDING_RELATIONSHIP' => '为 %s 添加关联',
    'LBL_SELECTED_RELATED_MODULE' => '选择相关模块',
    'LBL_SELECTED_RELATION_TYPE' => '选择关系类型',
    'ONE_ONE_AND_MANY_ONE_RELATIONSHIP' => '一对一和多对一关系',
    'ONE_MANY_RELATIONSHIP' => '一对多和多对多关系',
    '1-1' => '一对一',
    '1-N' => '一对多',
    'N-1' => '多对一',
    'N-N' => '多对多',
    
	
	//New layout translations
	'LBL_FIELD_TYPES'                   => '字段类型', 
	'LBL_BASIC_FIELDS'             => '基本字段', 
	'LBL_MANDATORY'                => '必填字段', 
	'LBL_PROPERTIES'               => '属性', 
	'LBL_DRAG_UI_TYPE'             => '这里拖放字段', 
	'LBL_RELATION_FIELDS'          => '关联字段', 
	'LBL_SELECT_BLOCK'             => '选择区块', 
    'LBL_RELATION_ADDED_SUCCESS'   => '关联添加成功',
    
    'FIELD_NAME_IN_PRIMARY_MODULE' => '%s 的关联字段',
    'FIELD_NAME_IN_RELATED_MODULE' => '%s 的关联字段',
    'TAB_IN_PRIMARY_MODULE'        => '%s 的表/标签',
    'TAB_IN_RELATED_MODULE'        => '%s 的表/标签',
    
    'LBL_DETAIL_VIEW'              => '详细视图',
    'LBL_EXPANDED'                 => '展开',
    'LBL_COLLAPSED'                => '折叠',
    
    'LBL_FILED_IN_PRIMARY_HELP_TEXT' => '%s 模块的参考字段',
    'LBL_TAB_IN_PRIMARY_HELP_TEXT'   => '%s 模块的表/标签',
    'LBL_FILED_IN_RELATED_HELP_TEXT' => '%s 模块的参考字段',
    'LBL_TAB_IN_RELATED_HELP_TEXT'   => '%s 模块的表/标签',
    'LBL_NO_RELATION_TYPE'         => '没有这种类型的关系存在',

	'LBL_CREATE_ITEM_CUSTOM_FIELD' => '创建行条目自定义字段',
	'LBL_MAP_PRODUCT_FIELD' => '映射到产品字段',
	'LBL_MAP_SERVICE_FIELD' => '映射到服务字段',
	'LBL_ENABLE_TO_MAP_PRODUCT_FIELD' => '启用映射产品字段',
	'LBL_ENABLE_TO_MAP_SERVICE_FIELD' => '启用映射服务字段',
    
    //Vtiger7 Strings
    'LBL_NO_RELATED_INFO' => '没有关联关系',
    'LBL_ADD_NEW_FIELD_HERE' => '添加新字段',
    'LBL_SAVE_LAYOUT' => '保存布局',
    'LBL_SHOW_FIELD' => '显示字段',
    'LBL_ENABLE_OR_DISABLE_FIELD_PROP' => '启用/禁用字段属性',
    'LBL_PROP_MANDATORY' => '必填',
    'LBL_DEFAULT_VALUE_NOT_SET' => '默认值未设置',
    'LBL_INFO' => '信息',
    'LBL_PRODUCTFIELDDEFAULTVALUE' => ' (产品)',
    'LBL_SERVICEFIELDDEFAULTVALUE' => ' (服务)',
    'LBL_SHOW_THIS_FIELD_IN' => '点击这里在 %s 区域中显示此字段',
    'LBL_MAKE_THIS_FIELD' => '点击这里使字段 %s',
    'LBL_HIDE_THIS_FIELD_IN' => '点击这里在 %s 视图中隐藏此字段',
    'LBL_NOT_MAKE_THIS_FIELD' => '点击这里使字段不 %s',
    'LBL_TAB_NAME_HELP_TEXT' => '%s 的列表显示在 %s 记录中',
    'LBL_TAB_NAME_TEXT' => '%s 的标签名在 %s 记录中',
    'LBL_FILED_NAME_HELP_TEXT' => '%s 的一个参考字段在 %s 记录中将被添加',
    'LBL_FIELD_NAME_TEXT' => '%s 的字段名在 %s 记录中',
	'LBL_COLLAPSE_BLOCK' => '折叠区块',
	'LBL_COLLAPSE_BLOCK_DETAIL_VIEW' => '在详细视图中折叠区块',
    'LBL_HEADER' => '头部',
    'LBL_DETAIL_HEADER' => '记录头部',
    'LBL_HEADER_FIELD' => '头部视图',

	'LBL_DUPLICATE_HANDLING' => '重复记录预防',
	'LBL_DUPLICATE_CHECK' => '启用重复记录检测',
	'LBL_DUPLICATION_INFO_MESSAGE' => '重复记录预防功能只能防止用户和外部程序创建新的重复记录。从【导入】和【工作流】创建的记录不会被重复检查。<br><br>可以在模块列表视图页面使用【查找重复】功能删除已有的重复记录。',
	'LBL_SELECT_FIELDS_FOR_DUPLICATION' => '选择要进行重复检查的字段',
	'LBL_SELECT_FIELDS' => '选择字段',
	'LBL_MAX_3_FIELDS' => '最多可以选择三个字段',
	'LBL_SELECT_RULE' => '选择重复处理规则',
	'LBL_ALLOW_DUPLICATES' => '允许重复',
	'LBL_DO_NOT_ALLOW_DUPLICATES' => '不允许重复',
	'LBL_DUPLICATES_IN_SYNC_MESSAGE' => '在与外部应用程序同步时发现重复记录时采取的措施',
	'LBL_PREFER_LATEST_RECORD' => '使用最新记录',
	'LBL_PREFER_INTERNAL_RECORD' => '保留已有记录',
	'LBL_PREFER_EXTERNAL_RECORD' => '首选外部记录',
	'LBL_SYNC_TOOLTIP_MESSAGE' => '使用最新记录 - 最近修改的记录数据将被保留。<br>保留已有记录 - 系统内现有记录将被保留。<br>首选外部记录 - 外部应用程序的数据将被保留。',
);

$jsLanguageStrings = array(
	'JS_BLOCK_VISIBILITY_SHOW' => '此区块已设置为显示',
	'JS_BLOCK_VISIBILITY_HIDE' => '此区块已设置为隐藏',
	'JS_CUSTOM_BLOCK_ADDED' => '新的自定义块已添加',
	'JS_BLOCK_SEQUENCE_UPDATED' => '区块顺序已更新',
	'JS_SELECTED_FIELDS_REACTIVATED' => '所选定的字段已重新激活',
	'JS_FIELD_DETAILS_SAVED' => '字段信息已保存',
	'JS_CUSTOM_BLOCK_DELETED' => '自定义块已删除',
	'JS_CUSTOM_FIELD_ADDED' => '新的自定义字段已添加',
	'JS_CUSTOM_FIELD_DELETED' => '自定义字段已删除',
	'JS_LENGTH_SHOULD_BE_LESS_THAN_EQUAL_TO' => '长度应该小于或等于',
	'JS_PLEASE_ENTER_NUMBER_IN_RANGE_2TO5' => '小数的取值范围为2-5',	
	'JS_SAVE_THE_CHANGES_TO_UPDATE_FIELD_SEQUENCE' => '字段顺序已更新',
	'JS_RELATED_INFO_SAVED' => '相关信息已保存',
	'JS_BLOCK_NAME_EXISTS' => '区块名称已存在',
	'JS_NO_HIDDEN_FIELDS_EXISTS' => '没有隐藏的字段',	
	'JS_SPECIAL_CHARACTERS' => '特殊字符如：',
	'JS_NOT_ALLOWED' => '不允许',
	'JS_FIELD_SEQUENCE_UPDATED' => '字段顺序已更新',
	'JS_DUPLICATES_VALUES_FOUND' => '发现重复值',
    'JS_FIELD_IN_RELATED_MODULE'  => '%s 的关联字段',
    'JS_TAB_IN_RELATED_MODULE' => '%s 的表/标签',
    'JS_FILED_IN_RELATED_HELP_TEXT' => '%s 模块的参考字段',
    'JS_TAB_IN_RELATED_HELP_TEXT'   => '%s 模块的表/标签',
    'JS_TAB_FIELD_DELETION'   => '删除关系将删除 %s 模块中的 %s 字段并在 %s 中删除 %s 表和标签。确定要继续么？',
    'JS_ONE_ONE_RELATION_FIELD_DELETE' => '此操作将删除 %s 模块中的 %s 字段也将删除 %s 模块的 %s 字段。确定要继续么？',
	'JS_CUSTOM_FIELDS_MAX_LIMIT' => '在 %s 块中最多只能添加 %s 个自定义字段',
    'JS_DEFAULT_VALUE_NOT_SET' => '未设置默认值',
    'JS_DEFAULT_VALUE' => '默认值',
    'JS_SAVE_MODULE_SEQUENCE' => '保存将更新相关模块顺序',
    'JS_PRODUCTFIELDDEFAULTVALUE' => ' (产品)',
    'JS_SERVICEFIELDDEFAULTVALUE' => ' (服务)',
    'JS_TAB_TAB_DELETION' => '此操作将删除 %s 模块中的 %s 标签和它的数据。确定要继续么？',
    'JS_SHOW_THIS_FIELD_IN' => '点击这里在 %s 视图中显示此字段',
    'JS_MAKE_THIS_FIELD' => '点击这里使字段 %s',
    'JS_HIDE_THIS_FIELD_IN' => '点击这里在 %s 视图中隐藏此字段',
    'JS_NOT_MAKE_THIS_FIELD' => '点击这里使字段不 %s',
    'JS_TAB_NAME_HELP_TEXT' => '显示在 %s 记录中的 %s 列表',
    'JS_TAB_NAME_TEXT' => '在 %s 记录中的 %s 标签名',
    'JS_FILED_NAME_HELP_TEXT' => '在 %s 记录中的一个参考字段 %s 将被添加',
    'JS_FIELD_NAME_TEXT' => '在 %s 记录中的 %s 字段名',
    'JS_PROP_MANDATORY' => '必填',
    'JS_SUMMARY' => '摘要',
    'JS_KEY_FIELD' => '关键字段',
    
    'JS_QUICK_CREATE' => '快速创建',
    'JS_MASS_EDIT' => '批量处理',
    'JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE' => '此操作将导致永久删除数据。
                                                 当删除字段时，字段中存储的值也将被删除，并且无法恢复。
                                                 如果您不确定并希望将来能够查看此数据，则可以将该字段标记为非活动状态，而不是删除该字段。非活动字段可以在以后任何时间重新激活启用。
                                                 您仍然确定要删除此字段吗？',
    'JS_FIELD_DELETE_CONFIRMATION' => '删除 - 我不再需要字段中的数据。',
	'JS_STATUS_CHANGED_SUCCESSFULLY' => '状态更改成功',
    'JS_FIELD_CAN_EITHER_BE_HEADER_OR_SUMMARY_ENABLED' => '此字段只能头部字段或关键字段任选其一',
    'JS_DETAIL_HEADER' => '记录头部',
    'JS_MAXIMUM_HEADER_FIELDS_ALLOWED' => '最多允许 %s 个标题头部字段',
    'JS_NAME_FIELDS_APPEAR_IN_HEADER_BY_DEFAULT' => '姓名字段已经默认出现在标题头部区域中',
    'JS_FIELD_IS_HEADER_ENABLED_FOR_VTIGER7' => '此字段作为标题头部字段仅限于 vtiger 7 中启用，它会出现在摘要视图中',

	'JS_DUPLICATE_HANDLING_SUCCESS_MESSAGE' => '选定字段的重复记录检测已成功更新。',
	'JS_DUPLICATE_HANDLING_FAILURE_MESSAGE' => '不能启用选定字段的重复记录检测功能。',
	'JS_DUPLICATE_CHECK_DISABLED' => '重复检测已禁用',
);