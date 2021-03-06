<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */

$this->title = \Yii::t('app', 'Create Tag');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Tags'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tags-create">

<h1><?php echo Html::encode($this->title); ?></h1>

<?php
    echo $this->render('partials/_form', [
        'model' => $model,
        ]
    );
?>
</div>
