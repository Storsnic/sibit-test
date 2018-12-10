<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\InvestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Invest';
?>
<div>
    <p class="top-title">Инвестировать сейчас</p>
	
	<hr/>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
		'method' => 'post',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3 form-input\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]);
	
	$model->restriction = '1';
	Yii::$app->formatter->thousandSeparator = ' ';	?>
	
	<div class="top-block">
		<?= $form->field($model, 'sumInv', ['template' => "{label}\n<div class=\"col-lg-3 form-input invest-input\">{input}</div>{error}"])
											->textInput(['autofocus' => true])->label('Сумма инвестиции') ?>

		<?= $form->field($model, 'mult', ['template' => "{label}\n<div class=\"col-lg-3 mult-input\">{input}</div><div class=\"factInv\">= $ 200000</div>{error}"])
											->textInput()->label('Мультипликатор') ?>
		<div class="mult-slider" >
			<input name="" class="settingsRange" type="range" 
				min="1" 
				max="40" 
				step="1" 
				data-default="" 
				data-value="" 
				value="">
				<div class="mult-numbers">
					1<span class="mult-five">5</span><span class="mult-twenty">20</span>40
				</div>
		</div>
	</div>
	
	<div class="bottom-title">˃ Ограничить прибыль и убыток</div>
	
	<div class="bottom-block">

		<?= $form->field($model, 'restriction')->inline(true)->radioList(['0' => '%', '1' => '$'], 
						[
							'item' => function($index, $label, $name, $checked, $value) {

								$return = '<label class="radio-inline">';
								$return .= '<input type="radio" name="' . $name . '" value="' . $value . '" id="radiobutton' . $index . '" checked="' . $checked . '">';
								$return .= '<span>' . ucwords($label) . '</span>';
								$return .= '</label>';

								return $return;
							}
						])->label('Ограничения в') ?>
		
		<div class="checkbox-row">
			<?= $form->field($model, 'income')->checkbox(['template' => "<div class=\"col-lg-3 income-checkbox income-field\">{input} {label}</div>"])->label('Прибыль') ?>
			
			<?= $form->field($model, 'takeIncome', ['template' => "<div class=\"col-lg-3 income-input income-field-input input-disabled\">{input}</div>{error}", 
												'inputOptions' => ['value' => Yii::$app->formatter->asInteger($model->sumInv)]])
												->textInput(['type' => 'number']) ?>
		</div>
		
		<div class="checkbox-row">
			<?= $form->field($model, 'outcome')->checkbox(['template' => "<div class=\"col-lg-3 income-checkbox outcome-field\">{input} {label}</div>"])->label('Убыток') ?>
			
			<?= $form->field($model, 'takeOutcome', ['template' => "{label}\n<div class=\"col-lg-3 outcome-input outcome-field-input input-disabled\">{input}</div>{error}", 
												'inputOptions' => ['value' => Yii::$app->formatter->asInteger($model->sumInv)]])
												->textInput(['type' => 'number'])->label('') ?>
		</div>
	
	</div>
		
	<div class="form-group button-row">
		<div class="col-lg-offset-1 col-lg-11">
			<?= Html::submitButton(' ', ['class' => 'invest-btn', 'style' => 'background: url(images/button_red.png)', 'name' => 'reduction-btn', 'value' => 'reduction'])?>
			<?= Html::submitButton(' ', ['class' => 'invest-btn', 'style' => 'background: url(images/button_green.png)', 'name' => 'growth-btn', 'value' => 'growth'])?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
