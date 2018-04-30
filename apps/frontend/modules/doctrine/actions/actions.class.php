<?php

/**
 * doctrine actions.
 *
 * @package    sf14
 * @subpackage doctrine
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class doctrineActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeCreate(sfWebRequest $request)
  {
    // レコードクラスを使った保存の例
    $article = new Article();
    $article->setTitle($this->makeRandStr(10));
    $article->setBody($this->makeRandStr(100));
    $article->setPublishedAt(date('Y-m-d H:m:s'));

    // save()メソッドを呼び出して保存
    $article->save();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $article = ArticleTable::getInstance()->find(1);
    $article->setPublishedAt(null);
    $article->save();
  }

  private function makeRandStr($length) {
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
      $r_str .= $str[rand(0, count($str) - 1)];
    }
    return $r_str;
  }
}
