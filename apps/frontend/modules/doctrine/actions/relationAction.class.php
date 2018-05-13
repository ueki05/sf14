<?php

class relationAction extends sfAction
{
  public function execute($request)
  {
    // 6-5-1 一対一のリレーション
    // リレーション先のオブジェクトの取得と保存
    // Articleを取得し、その後関連付けられているArticleDetailを取得
    $article = ArticleTable::getInstance()->find(1);
    $articleDetail = $article->getArticleDetail();
    echo $articleDetail->getArticleOption();

    // Articleに新しいArticleDetailを関連付ける
    $newArticleDetail = new ArticleDetail();
    // :
    $article->setArticleDetail($newArticleDetail);
    $article->save();

    // 6-5-2 一対多のリレーション
    $articleComments = $article->getComments();
    foreach ($articleComments as $articleComment) {
      echo $articleComment->getBody();
    }

    $newComment = new Comment();
    $newComment->setArticle($article);
    $newComment->setbody('new body');
    $newComment->save();

    // 6-5-3 多対多のリレーション
    $article = ArticleTable::getInstance()
      ->findOneByTitle('symfonyでDoctrineを使う方法(1)');

    $tags = $article->getTags();

    echo count($tags);
    foreach ($tags as $tag) {
      echo $tag->getBody();
    }

    $newTag = new Tag();
    $newTag->setBody('new tag');

    $tags->add($newTag);
    $article->setTags($tags);
    $article->save();

  }
}
