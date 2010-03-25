<?php

/**
 * @file controllers/grid/library/form/FileForm.inc.php
 *
 * Copyright (c) 2003-2010 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class FileForm
 * @ingroup controllers_grid_file_form
 *
 * @brief Form for adding/edditing a file
 * stores/retrieves from an associative array
 */

import('form.Form');

class FileForm extends Form {
	/** the type of file being uploaded */
	var $fileType;
	
	/** the id of the file being edited */
	var $fileId; 
	
	/**
	 * Constructor.
	 */
	function FileForm($fileType, $fileId = null, $isUploading = false) {
		$this->fileType = $fileType;
		$this->fileId = $fileId;		
		parent::Form('controllers/grid/library/form/fileForm.tpl');
		
		if (!$isUploading) {
			$this->addCheck(new FormValidator($this, 'name', 'required', 'submission.nameRequired'));
		}
		$this->addCheck(new FormValidatorPost($this));
	}

	/**
	 * Initialize form data from current settings.
	 */
	function initData(&$args, &$request) {
		if ( isset($this->fileId) ) {
			$this->_data['fileId'] = $this->fileId;
		}
		
		$this->_data['fileType'] = $this->fileType;
		// grid related data
		$this->_data['gridId'] = $args['gridId'];
		if ( isset($this->fileId) ) {
			$this->_data['rowId'] = $this->fileId;
		}
	}

	/**
	 * Display
	 */
	function display() {
		Locale::requireComponents(array(LOCALE_COMPONENT_OMP_MANAGER));

		if ($this->fileId) {
			$libraryFileDao =& DAORegistry::getDAO('LibraryFileDAO');
			$libraryFile =& $libraryFileDao->getById($this->fileId);
			assert(!is_null($libraryFile));
			$templateMgr =& TemplateManager::getManager();
			$templateMgr->assign_by_ref('libraryFile', $libraryFile);
			$templateMgr->assign_by_ref('libraryFileName', $libraryFile->getLocalizedName());
		}
		parent::display();
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(array('gridId', 'rowId', 'name'));
	}

	function uploadFile(&$args, &$request) {
		$router =& $request->getRouter();
		$context =& $router->getContext($request);
		import('file.LibraryFileManager');
		$libraryFileManager = new LibraryFileManager($context->getId());
		
		if ($libraryFileManager->uploadedFileExists('libraryFile')) {
			return $libraryFileManager->handleUpload($this->fileType, 'libraryFile', $this->fileId);
		}
	}

	/**
	 * Save name for library file
	 */
	function execute(&$args, &$request) {
		$name = $this->getData('name');		
		$libraryFileDao =& DAORegistry::getDAO('LibraryFileDAO');
		$libraryFile =& $libraryFileDao->getById($this->fileId);
		$libraryFile->setName($name, Locale::getLocale());
		$libraryFileDao->updateObject($libraryFile);
		
		return $libraryFile;
	}
}

?>
