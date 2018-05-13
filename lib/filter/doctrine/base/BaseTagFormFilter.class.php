<?php

/**
 * Tag filter form base class.
 *
 * @package    sf14
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTagFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'body'         => new sfWidgetFormFilterInput(),
      'article_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
    ));

    $this->setValidators(array(
      'body'         => new sfValidatorPass(array('required' => false)),
      'article_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tag_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addArticleListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ArticleTag ArticleTag')
      ->andWhereIn('ArticleTag.article_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Tag';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'body'         => 'Text',
      'article_list' => 'ManyKey',
    );
  }
}
