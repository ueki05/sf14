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
    echo 'Doctrine_Queryでクエリーを組み立てる例' . nl2br("\n");
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
    echo nl2br("\n");

    // テーブルクラスから基本となるクエリーオブジェクトを取得する例
    echo 'テーブルクラスから基本となるクエリーオブジェクトを取得する例' . nl2br("\n");
    $q2 = ArticleTable::getInstance()->createQuery('a');

    $articles2 = $q2->execute();

    if (count($articles2) > 0) {
      foreach ($articles2 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");

    // クエリーのFROMを指定する例
    echo 'クエリーのFROMを指定する例' . nl2br("\n");
    $q3 = Doctrine_Query::create()
      ->from('Article a');

    $articles3 = $q3->execute();

    if (count($articles3) > 0) {
      foreach ($articles3 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");

    // クエリーのSELECTを指定する例
    echo 'クエリーのSELECTを指定する例' . nl2br("\n");
    $q4 = Doctrine_Query::create()
      ->select('a.title, a.body, a.published_at')
      ->addSelect('a.created_at, a.updated_at') // 2回selectを使うと上書きされる
      ->from('Article a');

    $articles4 = $q4->execute();

    if (count($articles4) > 0) {
      foreach ($articles4 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");

    // クエリーのWHEREを指定する例
    echo 'クエリーのWHEREを指定する例' . nl2br("\n");
    $q5 = Doctrine_Query::create()
      ->from('Article a')
      ->where('(a.title LIKE ? OR a.body LIKE ?)', array('%Article%', 'Body'))
      ->andWhere('a.published_at IS NOT NULL');

    $articles5 = $q5->execute();

    if (count($articles5) > 0) {
      foreach ($articles5 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");

    // クエリーでINを使う例
    echo 'クエリーでINを使う例' . nl2br("\n");
    $q6 = Doctrine_Query::create()
      ->from('Article a')
      ->whereIn('a.id', array(2, 3, 4));

    $articles6 = $q6->execute();

    if (count($articles6) > 0) {
      foreach ($articles6 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");

    // 複数のORDEB BYを指定する例
    echo '複数のORDEB BYを指定する例' . nl2br("\n");
    $q7 = Doctrine_Query::create()
      ->from('Article a')
      ->orderBy('a.published_at DESC')
      ->addOrderBy('a.id');

    $articles7 = $q7->execute();

    if (count($articles7) > 0) {
      foreach ($articles7 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");

    // ORDER BY RAND()を使ってランダムにソートする例
    echo 'ORDER BY RAND()を使ってランダムにソートする例' . nl2br("\n");
    $q8 = Doctrine_Query::create()
      ->from('Article a')
      ->orderBy('rand()');

    $articles8 = $q8->execute();

    if (count($articles8) > 0) {
      foreach ($articles8 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");

    // LIMIT, OFFSETの使用例
    echo 'LIMIT, OFFSETの使用例' . nl2br("\n");
    $q9 = Doctrine_Query::create()
      ->from('Article a')
      ->limit(1)
      ->offset(2);

    $articles9 = $q9->execute();

    if (count($articles9) > 0) {
      foreach ($articles9 as $article) {
        echo $article->getTitle(), PHP_EOL;
      }
    }
    echo nl2br("\n");
  }
}
