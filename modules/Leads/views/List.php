<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Leads_List_View extends Vtiger_List_View {

    function preProcess(Vtiger_Request $request, $display=true) {
        parent::preProcess($request, false);

        $viewer = $this->getViewer ($request);
        $moduleName = $request->getModule();

        $listViewModel = Vtiger_ListView_Model::getInstance($moduleName);
        $linkParams = array('MODULE'=>$moduleName, 'ACTION'=>$request->get('view'));
        $viewer->assign('CUSTOM_VIEWS', CustomView_Record_Model::getAllByGroup($moduleName));
        $this->viewName = $request->get('viewname');
        if(empty($this->viewName)){
            //If not view name exits then get it from custom view
            //This can return default view id or view id present in session
            $customView = new CustomView();
            $this->viewName = $customView->getViewId($moduleName);
        }

        $quickLinkModels = $listViewModel->getSideBarLinks($linkParams);
        $viewer->assign('QUICK_LINKS', $quickLinkModels);
        $this->initializeListViewContents($request, $viewer);
         //echo '<pre>';print_r($this->viewName);die();
        $viewer->assign('VIEWID', $this->viewName);

        if($display) {
            $this->preProcessDisplay($request);
        }
    }

}
