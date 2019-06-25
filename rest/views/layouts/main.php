<?php
/**
 * @var \common\components\View $this
 * @var string $content
 */

use yii\helpers\Html;

$this->beginPage();

?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>

	<body>
	<?php

	$this->beginBody();

	echo $content;

	$this->endBody();

	?>
	</body>
	</html>
<?php

$this->endPage();