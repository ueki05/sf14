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
    // レコードクラスを使った更新の例
    $article = ArticleTable::getInstance()->find(1);
    $article->setPublishedAt(null);
    $article->save();
  }

  public function executeDelete(sfWebRequest $request)
  {
    // レコードクラスを使った削除の例
    $article = ArticleTable::getInstance()->find(1);
    $article->delete();
  }

  private function makeRandStr($length) {
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
      $r_str .= $str[rand(0, count($str) - 1)];
    }
    return $r_str;
  }

  public function executeFind(sfWebRequest $request)
  {
    // find()メソッドの使用例
    $article1 = ArticleTable::getInstance()->find(2);
    echo $article1->getTitle(), PHP_EOL;

    // findAll()メソッドの使用例
    $articles1 = ArticleTable::getInstance()->findAll();
    if (count($articles1) > 0) {
      foreach ($articles1 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }

    // findBy()メソッドの使用例
    $articles2 = ArticleTable::getInstance()->findBy('created_at', '2018-04-29 18:37:35');
    if (count($articles2) > 0) {
      foreach ($articles2 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }

    // findOneBy()メソッドの使用例
    $article2 = ArticleTable::getInstance()->findOneBy('title', 'Article 2');
    echo $article2->getTitle(), PHP_EOL;

    // マジックファインダの使用例
    $article3 = ArticleTable::getInstance()->findOneByTitle('Article 2');
    echo $article3->getTitle(), PHP_EOL;

    // マジックファインダによる複数カラムの条件指定の例
    $articles3 = ArticleTable::getInstance()->findByTitleOrCreatedAt('Article 2', '2018-04-29 18:37:35');
    if (count($articles3) > 0) {
      foreach ($articles3 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
  }

  public function executeDoctrineQuery(sfWebRequest $request)
  {
    // Doctrine_Queryでクエリーを組み立てる例
    $q = Doctrine_Query::create()
      ->from('Article a')
      ->where('a.title LIKE ?', '%Article%')
      ->andwhere('a.published_at IS NOT NULL')
      ->orderBy('a.published_at DESC')
      ->limit(10);

    $articles = $q->execute();

    if (count($articles) > 0) {
      foreach ($articles as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }

  }
}
