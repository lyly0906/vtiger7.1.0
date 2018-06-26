<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

vimport('~~/vtlib/Vtiger/Net/Client.php');
class ITS4YouMultiCompany_Save_Action extends Vtiger_Save_Action {
    public function process(Vtiger_Request $request) {
        global $chat_URL;
        $recordModel = $this->saveRecord($request);
        $companyId = $this->savedRecordId;
        /**同步创建chat 的总公司信息 **/
        //创建聊天的公司信息，先查找公司是否存在，如果存在则不添加
        if($companyId){
            $outRelaStr = 'vtiger_com_'.$companyId;
            $searchUrl = $chat_URL."org/company/getout";//查找公司是否存在的url
            $post = array('outRelaId' => $outRelaStr);//参数
            $client = new Vtiger_Net_Client($searchUrl);
            $clientresut = $client->doPost($post);
            file_put_contents("log.txt", "------company-----getout----1--".$clientresut, FILE_APPEND);
            $searchresult = json_decode($clientresut,true);
            if(empty($searchresult['departments'])){//如果不存在则创建公司
                $createurl = $chat_URL."org/company/create";
                $createpost = array('companyName' => $request->get('companyname'),'createUserId' => '10000', 'outRelaId' => $outRelaStr);
                $client = new Vtiger_Net_Client($createurl);
                $createtresut = $client->doPost($createpost);
                file_put_contents("log.txt", "------company-----getout----2--".$createtresut, FILE_APPEND);
            }
        }

        /**同步创建chat 的总公司信息 **/
        if ($request->get('returntab_label')){
            $loadUrl = 'index.php?'.$request->getReturnURL();
        } else if($request->get('relationOperation')) {
            $parentModuleName = $request->get('sourceModule');
            $parentRecordId = $request->get('sourceRecord');
            $parentRecordModel = Vtiger_Record_Model::getInstanceById($parentRecordId, $parentModuleName);
            //TODO : Url should load the related list instead of detail view of record
            $loadUrl = $parentRecordModel->getDetailViewUrl();
        } else if ($request->get('returnToList')) {
            $loadUrl = $recordModel->getModule()->getListViewUrl();
        } else if ($request->get('returnmodule') && $request->get('returnview')) {
            $loadUrl = 'index.php?'.$request->getReturnURL();
        } else {
            $loadUrl = $recordModel->getDetailViewUrl();
        }
        $appName = $request->get('appName');
        if(strlen($appName) > 0){
            $loadUrl = $loadUrl.$appName;
        }

        header("Location: $loadUrl");
    }
}