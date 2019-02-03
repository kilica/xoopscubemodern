<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_TRUST_PATH. "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class User_AvatarUploadForm extends XCube_ActionForm
{
    public $mOldFileName = null;
    public $_mIsNew = null;
    public $mFormFile = null;
    public $_allowExtensions = array('tar', 'tar.gz', 'tgz', 'gz', 'zip');

    public function getTokenName()
    {
        return "module.user.AvatarUploadForm.TOKEN";
    }

    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['upload'] =new XCube_FileProperty('upload');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['upload'] =new XCube_FieldProperty($this);
        $this->mFieldProperties['upload']->setDependsByArray(array('required'));
        $this->mFieldProperties['upload']->addMessage('required', _AD_USER_ERROR_REQUIRED, _AD_USER_LANG_AVATAR_UPLOAD_FILE);
    }
    
    public function validateUpload()
    {
        $formFile = $this->get('upload');
        if ($formFile != null) {
            $flag = false;
            foreach ($this->_allowExtensions as $ext) {
                $flag |= preg_match("/" . str_replace(".", "\.", $ext) . "$/", $formFile->getFileName());
            }
            
            if (!$flag) {
                $this->addErrorMessage(_AD_USER_ERROR_EXTENSION_IS_WRONG);
            }
        }
    }
}
