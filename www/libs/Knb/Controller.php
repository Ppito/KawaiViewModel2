<?php


class Knb_Controller extends Vbf_Mvc_Controller
{
  private $autoViewEnabled = TRUE;

  protected function getAutoViewEnabled()       { return $this->autoViewEnabled;    }
  protected function setAutoViewEnabled($value) { $this->autoViewEnabled = $value;  }
  protected function getConnectedUser()         { return $GLOBALS['g_user'];        }
  protected function getDatabaseConnection()    { return $GLOBALS['g_database'];    }

  protected function disablePageTitle() {
    $this->setViewParameter('/__globalViews/' . $this->globalViews, 'noPageTitle', TRUE);
  }

  protected function setSmallBoxes($smallboxes) {
    $this->setViewParameter('/__globalViews/' . $this->globalViews, 'smallboxes', $smallboxes);
  }

  protected function setTitle($title) {
    $this->setViewParameter('/__globalViews/' . $this->globalViews, 'title', $title);
  }

  public function onBefore() {
    $this->setViewParameter('/__globalViews/' . $this->globalViews, 'title', '');
  }

  public function onAfter() {
    if ($this->getAutoViewEnabled()) {
      $this->setViewParameter('/__globalViews/' . $this->globalViews, 'body',     $this->renderView(''));
      $this->setViewParameter('/__globalViews/' . $this->globalViews, 'mainmenu', $this->getMainmenu());
      $this->setViewParameter('/__globalViews/' . $this->globalViews, 'submenu',  $this->getSubmenu());
      $this->setViewParameter('/__globalViews/' . $this->globalViews, 'leftCol',  $this->getLeftCol());
      $this->setViewParameter('/__globalViews/' . $this->globalViews, 'rightCol', $this->getRightCol());
      $this->displayView('/__globalViews/' . $this->globalViews);
    }
  }

  protected function setMainViewParameter($title, $value) {
    $this->setViewParameter('/__globalViews/' . $this->globalViews, $title, $value);
  }

  protected function getMainmenu()  { return array(); }
  protected function getSubmenu()   { return array(); }
  protected function getLeftCol()   { return '';      }
  protected function getRightCol()  { return '';      }

}

?>
