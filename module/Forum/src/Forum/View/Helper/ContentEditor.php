<?php

namespace Forum\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Returns colored string with status name (human-way)
 *
 */
class ContentEditor extends AbstractHelper {

  /**
   * __invoke
   *
   * @access public
   * @param  int $numberOfDays
   * @return String
   */
  public function __invoke() {
    $this->view->headScript()->appendFile('/js/tinymce/tinymce.min.js');
    $config = <<<'SCRIPT'
    
      tinymce.init({
        selector: 'textarea.edit-content',
        toolbar: 'bold italic underline removeformat blockquote numlist bullist alignleft aligncenter alignright alignjustify ',
        menubar: false,
        statusbar : false

      });

SCRIPT;
    $this->view->headScript()->appendScript($config);
  }

}