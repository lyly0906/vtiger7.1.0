<?php /* Smarty version Smarty-3.1.7, created on 2018-06-07 05:55:12
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Settings\Departments\EditView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:324725b18c8c0934406-26334090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4dd4b0d1c87da59e1b059cfbbab64ec899d62a62' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Settings\\Departments\\EditView.tpl',
      1 => 1527833672,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '324725b18c8c0934406-26334090',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'RECORD_ID' => 0,
    'MODE' => 0,
    'PROFILE_ID' => 0,
    'HAS_PARENT' => 0,
    'parent_company' => 0,
    'ShowMultiCompany' => 0,
    'MultiCompany' => 0,
    'index' => 0,
    'its4you_company' => 0,
    'value' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b18c8c0b2840',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b18c8c0b2840')) {function content_5b18c8c0b2840($_smarty_tpl) {?>



<div class="editViewPageDiv viewContent">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="editViewHeader">
                <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getId()){?>
                    <h4>
                        <?php echo vtranslate('LBL_EDIT_DEPARTMENT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

                    </h4>
                <?php }else{ ?>
                    <h4>
                        <?php echo vtranslate('LBL_CREATE_DEPARTMENT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

                    </h4>
                <?php }?>
            </div>
            <hr>
        <form class="form-horizontal" id="EditView" name="EditRole" method="post" action="index.php" enctype="multipart/form-data">
            <div class="editViewBody">
                <div class="editViewContents">
                    <input type="hidden" name="module" value="Departments">
                    <input type="hidden" name="action" value="Save">
                    <input type="hidden" name="parent" value="Settings">
                    <?php $_smarty_tpl->tpl_vars['RECORD_ID'] = new Smarty_variable($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getId(), null, 0);?>
                    <input type="hidden" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
" />
                    <input type="hidden" name="mode" value="<?php echo $_smarty_tpl->tpl_vars['MODE']->value;?>
">
                    <input type="hidden" name="profile_directly_related_to_role_id" value="<?php echo $_smarty_tpl->tpl_vars['PROFILE_ID']->value;?>
" />
                    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getParent()){?><?php echo "true";?><?php }?><?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['HAS_PARENT'] = new Smarty_variable($_tmp1, null, 0);?>
                    <?php if ($_smarty_tpl->tpl_vars['HAS_PARENT']->value){?>
                        <input type="hidden" name="parent_roleid" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getParent()->getId();?>
">
                        <input type="hidden" name="companyId" value="<?php echo $_smarty_tpl->tpl_vars['parent_company']->value;?>
">
                    <?php }?>
                    <div name='editContent'>
                        <div class="form-group">
                            <label class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">
                                <strong><?php echo vtranslate('LBL_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
&nbsp;<span class="redColor">*</span></strong>
                            </label>
                            <div class="controls fieldValue col-lg-4 col-md-4 col-sm-4" >
                                <div class=""> <input type="text" class="inputElement" name="rolename" id="profilename" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getName();?>
" data-rule-required='true'  />
                                </div> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">
                                <strong><?php echo vtranslate('LBL_REPORTS_TO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
                            </label>
                            <div class="controls fieldValue col-lg-4 col-md-4 col-sm-4" >
                                <input type="hidden" name="parent_roleid" <?php if ($_smarty_tpl->tpl_vars['HAS_PARENT']->value){?>value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getParent()->getId();?>
"<?php }?>>
                                <div class=""> <input type="text" class="inputElement" name="parent_roleid_display" <?php if ($_smarty_tpl->tpl_vars['HAS_PARENT']->value){?>value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getParent()->getName();?>
"<?php }?> readonly>
                                </div></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-md-3 col-sm-3 fieldLabel control-label">
                                <?php echo vtranslate('LBL_SYNLHC',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

                            </label>
                            <div class="fieldValue col-lg-9 col-md-9 col-sm-9">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input class="inputElement" name="synlhc" id="synlhc" type="checkbox" value="1" <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getSynlhc()){?>checked<?php }?>/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['ShowMultiCompany']->value){?>
                        <div class="form-group row">
                            <label class="col-lg-3 col-md-3 col-sm-3 fieldLabel control-label">
                                <?php echo vtranslate('LBL_COMPANY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

                            </label>
                            <div class="fieldValue col-lg-9 col-md-9 col-sm-9">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <select style="width: 140px;" class="select2 referenceModulesList" name="companyId">
                                            <option value=""></option>
                                            <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['MultiCompany']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['its4you_company']->value==$_smarty_tpl->tpl_vars['index']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['value']->value->getname();?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            <div class='modal-overlay-footer  clearfix'>
                <div class="row clearfix">
                    <div class=' textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
                        <button type='submit' class='btn btn-success saveButton' ><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button>&nbsp;&nbsp;
                        <a class='cancelLink'  href="javascript:history.back()" type="reset"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
</div>
</div>
</div>
<?php }} ?>