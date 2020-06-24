<?php

namespace App\Http\Controllers\Api\V1\Agent;

use App\Models\Ads;
use App\Models\Country;
use App\Models\AdsImage;
use App\Models\UnitView;
use App\Models\Amenities;
use App\Models\OfferType;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\AdsEditHistory;
use App\Models\LevelOfFinished;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\CoreController;

class AdsController extends CoreController
{
    protected function scoper()
    {
        $ads = Ads::where('agent_id',$this->auth->id);
        return $ads;
        // return $this->auth->ads();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $active_ads  = $this->scoper()->valid()->get();
        $expired_ads = $this->scoper()->expired()->get();

        return $this->response(compact('active_ads','expired_ads'));
    }


    public function create()
    {
        $model = new Ads;
        $proprty_type_list = PropertyType::get(['name_en','name_ar', 'id']);
        if (request('locale') == 'en') {
            $offer_type_list = OfferType::pluck('title_en', 'id');
        }else {
            $offer_type_list = OfferType::pluck('title_ar', 'id');
        }
        $countries = Country::with('cities')->get(['name_en','name_ar', 'id']);
        $amenities = Amenities::where('activation', 1)->get(['name_en','name_ar', 'id']);
        $level_of_finished = LevelOfFinished::where('activation', 1)->get(['name_en','name_ar', 'id']);
        $unit_view_list = UnitView::get(['name_en','name_ar', 'id']);
        $sale_rent = [
            [
                'id' => 1,
                'name' => __('lang.sale')
            ],
            [
                'id' => 2,
                'name'=> __('lang.rent')
            ],
        ];
        $number_of_regular_ads = $this->auth->myAgent->hasMorePoints('number_of_regular_ads');
        $number_of_premium_ads = $this->auth->myAgent->hasMorePoints('number_of_premium_ads');
        return $this->response(compact('proprty_type_list', 'sale_rent', 'unit_view_list', 'owner', 'agent', 'countries', 'cities', 'offer_type_list','amenities','level_of_finished','number_of_regular_ads','number_of_premium_ads'));
    }


      /**
     * Before go inside @store method
     * @return avoid
     */
    public function onStore()
    {
        $this->setCreatableAttibutes($this->request->only('title','offer_type_id','latitude','longitude','size','property_type_id','price','price_negotiable','bedrooms_num','bathrooms_num','finishing_level','unit_view_id','building_year','description','country_id','city_id','is_premium','contact_method','able_call','able_email','able_chat','level_of_finished_id','amenitie_id') + ['owner_id'=>$this->auth->comapny_id, 'agent_id'=>$this->auth->id]);

        $this->validator([
            'title' => 'required|max:255',
            'country_id' => 'required',
            'city_id' => 'required',
            'price'=>'required'
        ]);

        //'number_of_premium_ads','number_of_regular_ads',

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->ifMethodExistCallIt('onStore');
        if (request('is_premium') == 1) {
            if ($this->auth->myAgent->hasMorePoints('number_of_premium_ads')) {
                $this->auth->myAgent->decrementPoints('number_of_premium_ads');
            }else {
                return $this->buildValidationMessage('title','Your package has been expired',422);
            }
        }
        elseif($this->auth->myAgent->hasMorePoints('number_of_regular_ads')) {
            $this->auth->myAgent->decrementPoints('number_of_regular_ads');
        }else {
            return $this->buildValidationMessage('title','Your package has been expired',422);
        }
        $row = $this->scoper()->create($this->creatable_attributes);
        $this->ifMethodExistCallIt('isStored', $row);
        $row = $this->scoper()->find($row->id);
        return $this->response([
            'data' => $row,
            'message' => 'Added successfully'
        ]);
    }

    public function isStored($row)
    {

        // Store product images
        if(request('images')) {
            foreach (request('images') as $key => $image) {
                $row->images()->create([
                    'image' => $image
                ]);
            }
        }
    }



    /**
    * Before go inside @update method
    * @return avoid
    */
   public function onUpdate()
    {
        $this->setUpdatableAttributes($this->request->only('title','offer_type_id','latitude','longitude','size','property_type_id','price','price_negotiable','bedrooms_num','bathrooms_num','finishing_level','unit_view_id','building_year','description','country_id','city_id','contact_method','able_call','able_email','able_chat','level_of_finished_id','amenitie_id'));
       return $this->validator([
            'title' => 'required|max:255',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);
    }

    public function update($id)
    {
        $this->ifMethodExistCallIt('onUpdate');
        $row = $this->scoper()->find($id);
        $update = AdsEditHistory::create($this->request->all() + ["ad_id" => $id , "expire_date" => $row->expire_date]);
        // $update = $row->update($this->request->all());
        $this->ifMethodExistCallIt('isUpdated',$update);
        return $this->response([
            'data'=>$row,
            'message'=>'updated successfully'
        ]);
    }


    public function isUpdated($row)
    {
        // Store product images
        if(request('images')) {
            foreach (request('images') as $key => $image) {
                $row->images()->create([
                    'image' => $image
                ]);
            }
        }
    }


    public function destroyImage($ads_id,$image_id)
    {
        $row = $this->scoper()->find($ads_id);
        if (!$row) {
            return $this->buildValidationMessage('id','Resource not found',422);
        }
        $row->images()->find($image_id)->delete();
        return $this->response(['message'=>'deleted successfully']);
    }



    public function patchDeactive($id)
    {
        $row = $this->scoper()->find($id);
        if (!$row) {
            return $this->buildValidationMessage('id','Resource not found',422);
        }
        $row->update(['status'=>0]);
        return $this->response([
            'data'=>$row,
            'message'=>'updated successfully'
        ]);
    }

    public function patchRenewAd($id)
    {
        $row = $this->scoper()->find($id);
        if (!$row) {
            return $this->buildValidationMessage('id','Resource not found',422);
        }
        $row->renewAd();
        return $this->response([
            'data'=>$row,
            'message'=>'updated successfully'
        ]);

    }

    public function patchUpdateAdToPremuim($id)
    {
        $row = $this->scoper()->find($id);
        if (!$row) {
            return $this->buildValidationMessage('id','Resource not found',422);
        }
        $row->updateAdToPremuim();
        return $this->response([
            'data'=>$row,
            'message'=>'updated successfully'
        ]);
    }

}
