<?php
namespace App\Dash\Dashboard;

use App\Models\Package as ModelsPackage;
use App\Models\Plan;
use Dash\Extras\Inputs\Card;
//use Dash\Extras\Inputs\HTML;
use Dash\Resource;
use \App\Models\User;
use Facade\Ignition\Support\Packagist\Package;

class Help extends Resource {

	/**
	 * add your card here by Card , HTML Class
	 * or by view instnance render blade file
	 * @return array
	 */
    public static function cards()
    {
        $plans = Plan::all();

        $cards = [];

        foreach ($plans as $plan) {
            $cards[] = Card::small()
                ->title(function () use ($plan){
                    return $plan->name;
                })
                ->type(function () use ($plan){
                    return $plan->type;
                })
                ->column(function () {
                    return '3';
                })
                ->icon(function () {
                    return '<i class="fa fa-users"></i>';
                })
                ->content(function () use ($plan){
                    $usersCount = ModelsPackage::where(['status' => 'PAID', 'plan_id' => $plan->id])->count();
                    return $usersCount;
                })
                ->color(function () {
                    return 'success';
                })
                ->link(function () use ($plan) {
                    return '/private_me/resource/Plan/'.$plan->id;
                })
                ->render();
        }

        return $cards;
    }

}
