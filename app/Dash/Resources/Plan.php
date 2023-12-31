<?php
namespace App\Dash\Resources;
use Dash\Resource;
use App\Dash\Resources\Users;
class Plan extends Resource {

	/**
	 * define Model of resource
	 * @param Model Class
	 */
	public static $model = \App\Models\Plan::class ;


	/**
	 * Policy Permission can handel
	 * (viewAny,view,create,update,delete,forceDelete,restore) methods
	 * @param static property as Policy Class
	 */
	//public static $policy = \App\Policies\UserPolicy::class ;

	/**
	 * define this resource in group to show in navigation menu
	 * if you need to translate a dynamic name
	 * define dash.php in /resources/views/lang/en/dash.php
	 * and add this key directly users
	 * @param static property
	 */
	public static $group = 'Plan';

	/**
	 * show or hide resouce In Navigation Menu true|false
	 * @param static property string
	 */
	public static $displayInMenu = true;

	/**
	 * change icon in navigation menu
	 * you can use font awesome icons LIKE (<i class="fa fa-list"></i>)
	 * @param static property string
	 */
	public static $icon = '<i class="fas fa-list"></i>'; // put <i> tag or icon name

	/**
	 * title static property to labels in Rows,Show,Forms
	 * @param static property string
	 */
	public static $title = 'name_type';

	/**
	 * defining column name to enable or disable search in main resource page
	 * @param static property array
	 */
	public static $search = [
		'id',
		'name',
        'type'
	];

	/**
	 *  if you want define relationship searches
	 *  one or Multiple Relations
	 * 	Example: method=> 'invoices'  => columns=>['title'],
	 * @param static array
	 */
	public static $searchWithRelation = [];

	/**
	 * if you need to custom resource name in menu navigation
	 * @return string
	 */
	public static function customName() {
		return __('dash.plans.plans');
	}

	/**
	 * you can define vertext in header of page like (Card,HTML,view blade)
	 * @return array
	 */
	public static function vertex() {
		return [];
	}

	/**
	 * define fields by Helpers
	 * @return array
	 */
	public function fields() {
		return [
			id()->make(__('dash::dash.id'), 'id'),
            text()->make(__('dash.plans.Name-Type'), 'name_type')
                ->showInShow(),
            text()->make(__('dash.plans.Name'), 'name')
                ->translatable([
                'ar' => 'العربية',
                'en' => 'English',
                ])
                ->showInShow(),
            text()->make(__('dash.plans.Cost'), 'cost')
                ->showInShow(),
            select()->make(__('dash.plans.Type'), 'type')
            ->selected(__('dash.plans.type'))
            ->options([
                __('dash.plans.Monthly')  => __('dash.plans.Monthly'),
                __('dash.plans.Yearly') => __('dash.plans.Yearly'),
               ]),

            hasMany()
            ->make(__('dash.plans.properties'), 'planProperties', PlanProperty::class)
            ->hideInIndex(),

            hasManyThrough()
            ->make(__('dash.plans.users'), 'users', Users::class)
            ->hideInIndex(),
		];
	}

	/**
	 * define the actions To Using in Resource (index,show)
	 * php artisan dash:make-action ActionName
	 * @return array
	 */
	public function actions() {
		return [];
	}

	/**
	 * define the filters To Using in Resource (index)
	 * php artisan dash:make-filter FilterName
	 * @return array
	 */
	public function filters() {
		return [];
	}

}
