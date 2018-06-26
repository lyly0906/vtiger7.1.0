<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * 简体中文语言包 - 安装
 * 版本: 7.1.0 
 * 作者: Maie | www.maie.name
 * 更新日期: 2018-03-06
 * All Rights Reserved.
 * *********************************************************************************** */

$languageStrings = array(
	'ERR_DATABASE_CONNECTION_FAILED' => '不能连接到数据库服务器',
	'ERR_DB_NOT_FOUND' => '此数据库没有找到。尝试更改数据库设置',
	'ERR_DB_NOT_UTF8'  => '数据库字符集或排序规则（整理）与 UTF8 不兼容',
	'ERR_INVALID_MYSQL_PARAMETERS' => '无效的 MySQL 连接参数',
	'ERR_INVALID_MYSQL_VERSION' => 'MySQL 的版本不支持，需要 MySQL 5.1.x 版或以上',
	'ERR_UNABLE_CREATE_DATABASE' => '无法创建数据库',
	'ERR_DB_SQLMODE_NOTFRIENDLY' => 'MySQL 服务器应配置为：<br> sql_mode = ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION',
	'LBL_ADMIN_INFORMATION'=>'管理员用户信息',
	'LBL_ADMIN_USER_INFORMATION' => '管理员用户信息',
	'LBL_CHOOSE_LANGUAGE' => '请为本次安装选择默认语言：',
	'LBL_CONFIRM_CONFIGURATION_SETTINGS' => '确认配置设定',
	'LBL_CREATE_NEW_DB'=>'由系统自动创建新数据库（需要提供有数据库创建权限的帐户）',
	'LBL_CURRENCIES'=>'币种',
	'LBL_CURRENCY' => '币种',
	'LBL_DATABASE_INFORMATION' => '数据库信息',
	'LBL_DATABASE_TYPE' => '数据库类型',
	'LBL_DATE_FORMAT'=>'日期格式',
	'LBL_DB_NAME' => '数据库名称',
	'LBL_DISAGREE' => '不同意',
	'LBL_EMAIL' => 'Email',
	'LBL_GD_LIBRARY' => 'GD 库支持',
	'LBL_HOST_NAME' => '数据库连接地址',
	'LBL_I_AGREE' => '同意',
	'LBL_IMAP_SUPPORT' => 'Imap 支持',
	'LBL_INSTALLATION_IN_PROGRESS'=>'安装正在进行',
	'LBL_INSTALLATION_WIZARD' => '安装向导',
	'LBL_INSTALL_BUTTON' => '安装',
	'LBL_INSTALL_PREREQUISITES' => '安装环境检测',
	'LBL_MORE_INFORMATION' => '更多信息',
	'LBL_NEXT' => '下一步',
	'LBL_ONE_LAST_THING' => '最后一步...',
	'LBL_PASSWORD_MISMATCH' => '请重新输入密码。\"密码\" 和 \"再次输入密码\" 的值不匹配。',
	'LBL_PASSWORD' => '密码',
	'LBL_PHP_CONFIGURATION' => 'PHP 配置',
	'LBL_PHP_RECOMMENDED_SETTINGS'=>'推荐 PHP 设置',
	'LBL_PHP_VERSION' => 'PHP 版本',
	'LBL_PLEASE_WAIT'=>'请稍候',
	'LBL_PRESENT_VALUE' => '当前值',
	'LBL_READ_WRITE_ACCESS' => '读/写访问',
	'LBL_RECHECK' => '重新检测',
	'LBL_REQUIRED_VALUE' => '必需的值',
	'LBL_RETYPE_PASSWORD' => '再次输入密码',
	'LBL_ROOT_PASSWORD' => 'Root 用户密码',
	'LBL_ROOT_USERNAME' => 'Root 用户名',
	'LBL_SYSTEM_CONFIGURATION' => '系统配置',
	'LBL_SYSTEM_INFORMATION' => '系统信息',
	'LBL_TIME_ZONE' => '时区',
	'LBL_TRUE' => 'True',
	'LBL_URL' => '访问链接',
	'LBL_USERNAME' => '用户名',
	'LBL_VTIGER7_SETUP_WIZARD_DESCRIPTION' => '该向导将引导您完成 vtiger CRM 7 的安装',
	'LBL_WELCOME_TO_VTIGER7_SETUP_WIZARD' => '欢迎来到 vtiger CRM 7 的安装向导',
	'LBL_WELCOME' => '欢迎',
	'LBL_ZLIB_SUPPORT' => 'Zlib 支持',
	'LBL_SIMPLEXML' => 'SimpleXML 支持',
	'MSG_DB_PARAMETERS_INVALID' => '指定的数据库用户，密码，主机名，数据库类型，或端口无效',	
	'MSG_DB_ROOT_USER_NOT_AUTHORIZED' => '提示：指定的数据库根用户没有创建数据库的权限或数据库名中含有非法字符。尝试更改数据库设置',
	'MSG_DB_USER_NOT_AUTHORIZED' => '指定的数据库中的用户不具有从本机连接到数据库服务器的访问权限',	
	'MSG_LIST_REASONS' => '这可能是由于以下原因：',
	'LBL_MYSQLI_CONNECT_SUPPORT'=>'mysqli 支持',
	'LBL_OPEN_SSL'=>'openssl 支持',
	'LBL_CURL'=>'cURL 支持',
	
	//模块安装
	'What_used_for' => '你想用 Vtiger CRM 做什么？',
	'Select_features' => '选择您要启用的功能',
	'Select_All' => '全选',
	'View_Modules' => '查看模块',
	'Default_Install' => '此功能将默认安装',
	'These_Modules_will_be_enabled' => '这些模块将在此功能下被启用',
	'Note' => '<strong>注意：</strong> 稍后可以从模块管理器启用/禁用模块',
	'Next' => '下一步',
	'Contact Management' => '联系人管理',
	'Contact Management Description' => '统一并存储您的联系人以及详细的备注，文档，电子邮件，日历事件等。 另外，配置每个CRM用户可以查看和更新的信息，并自动执行业务活动，如电子邮件响应和联系信息更新。',
	'Sales Automation' => '销售自动化',
	'Sales Automation Description' => '从您的网站捕获潜在客户，或导入其中的列表，然后开发一个合格的流程，并将其转化为潜在的销售机会，另一个用于赢得潜在的机会。 此外，跟踪和细分您的销售渠道，个人和团队，绩效领域。',
	'Marketing' => '市场营销',
	'Marketing Description' => '向您的联系人，潜在客户和客户发送个人、有针对性的或批量的电子邮件，并了解他们如何参与每项沟通，并提供分析和改进广告效果的工具。',
	'Support' => '支持',
	'Support Description' => '通过服务单创建和跟踪客户请求/任务，甚至允许您的客户通过客户门户创建和监控自己的工单和详细信息。',
	'Invoicing & Inventory Management' => '账单和库存管理',
	'Invoicing & Inventory Management Description' => '构建您的产品和服务的数据库，维护库存，标准价格和价格表，并基于这些来创建报价单，账单发票和销售订单。',
	'Project Management' => '项目管理',
	'Project Management Description' => '构建和管理与客户相关的项目，具有可分配给 CRM 用户并放置在其日历上的详细任务。',
);
$jsLanguageStrings = array(
	'JS_STEP3' => '某些 PHP 设置不符合推荐值。这可能会影响 vtiger CRM 的一些功能。您确定仍然要继续吗？',
	'JS_STEP4' => '请重新输入密码。\"密码\”和\“重新输入密码\"值不匹配。',
);
