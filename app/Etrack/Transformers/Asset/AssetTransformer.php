<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Etrack\Transformers\StatusTransformer;
use App\Etrack\Transformers\Worker\WorkerTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class AssetTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class AssetTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'company',
        'worker',
        'brand',
        'brandModel',
        'status',
        'workplace',
        'category',
        'subcategory',
        'images',
        'coverImage',
        'documents'
    ];

    /**
     * Transform the \Asset entity
     * @param Asset $model
     *
     * @return array
     */
    public function transform(Asset $model)
    {
        return [
            'id'                    => (int)$model->id,
            'worker_id'             => $model->worker_id,
            'brand_id'              => $model->brand_id,
            'model_id'              => $model->model_id,
            'category_id'           => $model->category_id,
            'sub_category_id'       => $model->sub_category_id,
            'workplace_id'          => $model->workplace_id,
            'status_id'             => $model->status_id,
            'sku'                   => $model->sku,
            'name'                  => $model->name,
            'tag_rfid'              => $model->tag_rfid,
            'location'              => $model->location,
            'latitude'              => $model->location ? explode(',', $model->location)[0] : null,
            'longitude'             => $model->location ? explode(',', $model->location)[1] : null,
            'serial'                => $model->serial,
            'validity_time'         => $model->validity_time,
            'integration_date'      => $model->integration_date ? $model->integration_date->format('d/m/Y') : null,
            'end_service_life_date' => $model->end_service_life_date ? $model->end_service_life_date->format('d/m/Y') : null,
            'warranty_date'         => $model->warranty_date ? $model->warranty_date->format('d/m/Y') : null,
            'disincorporation_date' => $model->disincorporation_date ? $model->disincorporation_date->format('d/m/Y') : null,
            'custom_fields'         => $model->custom_fields,
            'created_at'            => $model->created_at ? $model->created_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Asset $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeWorker(Asset $model)
    {
        $worker = $model->worker;
        if ($worker) {
            return $this->item($worker, new WorkerTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeBrand(Asset $model)
    {
        return $this->item($model->brand, new BrandTransformer(), 'parent');

    }

    public function includeBrandModel(Asset $model)
    {
        $brandModel = $model->brandModel;
        if ($brandModel) {
            return $this->item($brandModel, new BrandModelTransformer(), 'parent');
        }
    }

    public function includeStatus(Asset $model)
    {
        return $this->item($model->status, new StatusTransformer(), 'parent');

    }

    public function includeCategory(Asset $model)
    {
        return $this->item($model->category, new CategoryTransformer(), 'parent');

    }

    public function includeWorkplace(Asset $model)
    {
        return $this->item($model->workplace, new WorkplaceTransformer(), 'parent');

    }

    public function includeSubcategory(Asset $model)
    {
        $subcategory = $model->subcategory;
        if ($subcategory) {
            return $this->item($subcategory, new SubcategoryTransformer(), 'parent');
        }
    }

    public function includeImages(Asset $model)
    {
        $assetImages = $model->getMedia('images');

        if ($assetImages->isEmpty()) {
            return $this->null();
        }

        return $this->collection($assetImages, new AssetImagesTransformer(), 'parent');
    }


    public function includeDocuments(Asset $model)
    {
        $assetDocuments = $model->getMedia('documents');

        if ($assetDocuments->isEmpty()) {
            return $this->null();
        }

        return $this->collection($assetDocuments, new AssetDocumentsTransformer(), 'parent');
    }

    public function includeCoverImage(Asset $model)
    {
        $coverPicture = $model->getFirstMedia('cover');
        if ($coverPicture) {
            return $this->item($coverPicture, new AssetImagesTransformer(), 'parent');
        }
    }
}
