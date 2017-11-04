<?php

/**
 * Page actions.
 *
 * @package    sf14
 * @subpackage Page
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PageActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeShow(sfWebRequest $request)
  {
    $slug = $request->getParameter('slug');
    $this->page = PageTable::getInstance()->findOneBySlug($slug);
  }

  public function executeNewsShow(sfWebRequest $request)
  {
    $slug = $request->getParameter('slug');
    $this->page = PageTable::getInstance()->findOneBySlug($slug);
  }

  public function executeNewsList(sfWebRequest $request)
  {
    $this->pageList = PageTable::getInstance()->findByCategory('news');
  }
}
