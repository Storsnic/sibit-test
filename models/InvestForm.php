<?php

namespace app\models;

use Yii;
use yii\base\Model;

class InvestForm extends Model
{
    public $sumInv = 10000;
    public $mult = 20;
    public $takeProfit;
	public $stopLoss;
	public $direction;
	public $dollar;
	public $percent;
	public $factInv;
	public $restriction = 1;
	public $income;
	public $outcome;
	public $takeIncome;
	public $takeOutcome;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
             [['sumInv', 'mult'], 'required'],            
            ['sumInv', 'compare', 'compareValue' => 100, 'operator' => '>=', 'type' => 'number', 'message' => 'Минимальная сумма инвестиции $ 100'],
            ['mult', 'in','range'=>range(1,40), 'message' => 'Неверное значение мультипликатора'],
			['takeIncome', 'compare', 'compareValue' => 999999, 'operator' => '>=',
				'whenClient' => "function (attribute, value) {
					if($('#radiobutton1').is(':checked') && parseInt($('#investform-takeincome').val()) < parseInt($('#investform-suminv').val())*0.1)
						return true;
					return false;
				}",
			'message' => 'Не может быть меньше 10%'
			],
			['takeIncome', 'compare', 'compareValue' => 10, 'operator' => '>=',
				'whenClient' => "function (attribute, value) {
					return $('#radiobutton0').is(':checked');
				}",
				'message' => 'Не может быть меньше 10%'
			],
			['takeOutcome', 'compare', 'compareValue' => 999999, 'operator' => '>=',
				'whenClient' => "function (attribute, value) {
					if($('#radiobutton1').is(':checked') && parseInt($('#investform-takeoutcome').val()) < parseInt($('#investform-suminv').val())*0.1)
						return true;
					return false;
				}",
				'message' => 'Не может быть меньше 10%'
			],
			['takeOutcome', 'compare', 'compareValue' => 10, 'operator' => '>=',
				'whenClient' => "function (attribute, value) {
					return $('#radiobutton0').is(':checked');
				}",
				'message' => 'Не может быть меньше 10%'
			],
			['takeOutcome', 'compare', 'compareValue' => 999999, 'operator' => '>=',
				'whenClient' => "function (attribute, value) {
					if($('#radiobutton1').is(':checked') && parseInt($('#investform-takeoutcome').val()) > parseInt($('#investform-suminv').val()))
						return true;
					return false;
				}",
				'message' => 'Не может быть больше 100%'
			],
			['takeOutcome', 'compare', 'compareValue' => 100, 'operator' => '<=',
				'whenClient' => "function (attribute, value) {
					return $('#radiobutton0').is(':checked');
				}",
				'message' => 'Не может быть больше 100%'
			],
			
        ];
    }
	
}
