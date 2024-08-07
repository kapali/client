<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class restaurant extends Sximo  {
	
	protected $table = 'abserve_restaurants';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_restaurants.* FROM abserve_restaurants  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_restaurants.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public function resrating($id=''){
		$overall_rate 	= $this->getRating($id);
		$round_overall	= round($overall_rate);
		return $round_overall;
	}
	public function getRating($id){
		$star_1 = \DB::select("SELECT count(rating)as rating1 FROM `abserve_rating` WHERE `res_id` = ".$id." AND `rating` = 1");
		$star_2 = \DB::select("SELECT count(rating)as rating2 FROM `abserve_rating` WHERE `res_id` = ".$id." AND `rating` = 2");
		$star_3 = \DB::select("SELECT count(rating)as rating3 FROM `abserve_rating` WHERE `res_id` = ".$id." AND `rating` = 3");
		$star_4 = \DB::select("SELECT count(rating)as rating4 FROM `abserve_rating` WHERE `res_id` = ".$id." AND `rating` = 4");
		$star_5 = \DB::select("SELECT count(rating)as rating5 FROM `abserve_rating` WHERE `res_id` = ".$id." AND `rating` = 5");

		$str_1 = $star_1[0]->rating1;
		$str_2 = $star_2[0]->rating2;
		$str_3 = $star_3[0]->rating3;
		$str_4 = $star_4[0]->rating4;
		$str_5 = $star_5[0]->rating5;

		$total_count = $str_5 + $str_4 + $str_3 + $str_2 + $str_1;

		$Rating = (($str_5 * 5) + ($str_4 * 4) + ($str_3 * 3) + ($str_2 * 2) + ($str_1 * 1));
		if($total_count == 0 || $Rating == 0) {
			$tot = 0;
			return $tot;
		}
		else{
			$tot = ($Rating/$total_count);
			return $tot;
		}
	}
	function getRatingAttribute()
	{
		return round($this->attributes['rating'], 1);
	}	
		function getAdvertiseAttribute()
		{
			$image = \DB::table('location')->where('id',$this->l_id)->pluck('image as advert');
			
			return !empty($image[0]) ? \URL('/uploads/location_ad/'.$image[0]): \URL::to('uploads/location_ad/'.\AbserveHelpers::getDefaultAdvert());
		}
	function getAdvertiseTypeAttribute()
	{
		$image = \DB::table('location')->where('id',$this->l_id)->pluck('image as advert');
		$image =  !empty($image) ? \URL('/uploads/location_ad/'.$image): \URL::to('uploads/location_ad/'.\AbserveHelpers::getDefaultAdvert());
        $ext   =  pathinfo($image);
       
		//return \AbserveHelpers::ImageOrVideo($ext['extension']);
	}
	function getAdvertiseExtUrlAttribute()
	{
		$image = \DB::table('location')->where('id',$this->l_id)->pluck('ext_url');
		$image =  !empty($image) ? $image: '';
		return $image;
	}

}
