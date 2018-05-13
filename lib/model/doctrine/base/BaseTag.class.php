<?php

/**
 * BaseTag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $body
 * @property Doctrine_Collection $Article
 * 
 * @method string              getBody()    Returns the current record's "body" value
 * @method Doctrine_Collection getArticle() Returns the current record's "Article" collection
 * @method Tag                 setBody()    Sets the current record's "body" value
 * @method Tag                 setArticle() Sets the current record's "Article" collection
 * 
 * @package    sf14
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTag extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tag');
        $this->hasColumn('body', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Article', array(
             'refClass' => 'ArticleTag',
             'local' => 'tag_id',
             'foreign' => 'article_id'));
    }
}