<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_DetailView_Model extends Vtiger_DetailView_Model {
    /**
     * Function to get the detail view related links
     * @return <array> - list of links parameters
     */
    public function getDetailViewRelatedLinks() {
        $recordModel = $this->getRecord();
        $moduleName = $recordModel->getModuleName();

        $relatedLinks = parent::getDetailViewRelatedLinks();

        $relatedLinkNumbering = array(
            'linktype' => 'DETAILVIEWTAB',
            'linklabel' => vtranslate('LBL_NUMBERING', $moduleName),
            'linkurl' => $recordModel->getDetailViewUrl().'&mode=showCompanyNumbering',
            'linkicon' => ''
        );

        array_push($relatedLinks, $relatedLinkNumbering);

        return $relatedLinks;
    }

    /**
     * Function to get the detail view links (links and widgets)
     * @param <array> $linkParams - parameters which will be used to calicaulate the params
     * @return <array> - array of link models in the format as below
     *                   array('linktype'=>list of link models);
     */
    public function getDetailViewLinks($linkParams) {
        $detailViewLink = parent::getDetailViewLinks($linkParams);

        /**
         * @var $linkModel  Vtiger_Link_Model
         */
        foreach ($detailViewLink['DETAILVIEW'] as $key => $linkModel) {
            if ($linkModel->getLabel() === 'LBL_DUPLICATE')
            {
                unset($detailViewLink['DETAILVIEW'][$key]);
            }
        }

        return $detailViewLink;
    }
}