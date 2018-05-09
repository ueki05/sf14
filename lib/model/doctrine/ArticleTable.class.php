<?php

/**
 * ArticleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ArticleTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ArticleTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Article');
    }

    // ArticleTablesクラスにレコード取得用のメソッドを定義
    public function findAllPublishedArticles()
    {
      return $this->createQuery('a')
        ->where('a.published_at IS NOT NULL')
        ->execute();
    }

    public function findPublishedArticleById($id)
    {
      return $this->createQuery('a')
        ->where('a.published_at IS NOT NULL')
        ->andWhere('a.id = ?', $id)
        ->fetchOne();
    }

    // 特定の条件のクエリーパーツを生成するメソッドを定義した例
    public function findAllPublishedArticles2()
    {
      return $this->addPublishedArticleQuery($this->createQuery('a'))
        ->execute();
    }

    public function findPublishedArticleById2($id)
    {
      return $this->addPublishedArticleQuery($this->createQuery('a'))
        ->andWhere('a.id = ?', $id)
        ->fetchOne();
    }

    public function addPublishedArticleQuery(Doctrine_Query $query, $alias = null, $targetDate = null)
    {
      if (null === $alias)
      {
        $alias = $query->getRootAlias();
      }

      if (null === $targetDate)
      {
        $targetDate = new DateTime();
      }

      return $query->andWhere(
        $alias . '.published_at IS NOT NULL AND ' . $alias . '.published_at <= ?', $targetDate->format('Y-m-d H:i:s')
      );
    }
}