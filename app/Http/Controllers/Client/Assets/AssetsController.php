<?php

namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Repositories\Assets\AssetRepository;
use App\Etrack\Transformers\Asset\AssetDocumentsTransformer;
use App\Etrack\Transformers\Asset\AssetImagesTransformer;
use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Asset\AssetDocumentStoreRequest;
use App\Http\Request\Asset\AssetStoreRequest;
use App\Http\Request\Asset\AssetUpdateRequest;
use DB;
use Dingo\Api\Http\Request;
use File;
use Response;
use Yajra\Datatables\Datatables;

class AssetsController extends Controller
{

    /**
     * @var AssetRepository
     */
    private $assetRepository;

    public function __construct(AssetRepository $assetRepository)
    {
        $this->module = 'client-assets';
        $this->assetRepository = $assetRepository;
    }

    public function index()
    {

    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Asset::inCompany()->with(['brand', 'category', 'subcategory', 'brandModel', 'status', 'workplace']))
            ->setTransformer(AssetTransformer::class)
            ->make(true);
    }

    public function show($assetId)
    {
        $this->userCan('show');
        $asset = Asset::inCompany()->find($assetId);
        if (!$asset) {
            $this->response->errorForbidden('No tienes permiso para ver este activo');
        }

        return $this->response->item($asset, new AssetTransformer());
    }

    public function store(AssetStoreRequest $request)
    {
        $user = $this->loggedInUser();
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = $user->company_id;
        $asset = new Asset();
        $asset->fill($data);
        $asset->save();
        if ($request->hasFile('image')) {
            $asset->clearMediaCollection('cover');
            $asset->addMedia($request->file('image'))->preservingOriginal()->toMediaLibrary('cover');
        }

        DB::commit();
        return $this->response->item($asset, new AssetTransformer());

    }

    public function update(AssetUpdateRequest $request, $assetId)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        $asset = Asset::inCompany()->find($assetId);
        if (!$asset) {
            $this->response->errorForbidden('No tiene permiso para actualizar este activo');
        }
        $data = $this->cleanRequestData($request->all());
        $data['company_id'] = $user->company_id;
        DB::beginTransaction();
        $asset->fill($data);
        $asset->save();
        if ($request->hasFile('image')) {
            $asset->clearMediaCollection('cover');
            $asset->addMedia($request->file('image'))->preservingOriginal()->toMediaLibrary('cover');
        } elseif ($request->has('removeImage')) {
            $asset->clearMediaCollection('cover');
        }

        DB::commit();
        return $this->response->item($asset, new AssetTransformer());

    }

    public function destroy($assetId)
    {
        $this->userCan('destroy');
        /** @var Asset $assetToDestroy */
        $assetToDestroy = Asset::inCompany()->find($assetId);
        if (!$assetToDestroy) {
            $this->response->errorForbidden('No tiene permiso para eliminar este activo');
        }
        DB::beginTransaction();
        $assetToDestroy->delete();
        DB::commit();
        return response()->json(['message' => 'Activo Eliminado con Exito']);

    }

    public function uploadImages(Request $request, $id)
    {
        $this->userCan('update');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($id);
        if (!$asset) {
            $this->response->errorForbidden('No tiene permiso para actualizar añadir imagenes a este activo');
        }

        $images = collect($request->file('images'));

        $images->each(function ($image) use ($asset) {
            $asset->addMedia($image)->preservingOriginal()->toMediaLibrary('images');
        });

        $assetImages = $asset->getMedia('images');

        return $this->response->collection($assetImages, new AssetImagesTransformer());

    }

    public function uploadDocuments(AssetDocumentStoreRequest $request, $id)
    {
        $this->userCan('update');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($id);
        if (!$asset) {
            $this->response->errorForbidden('No tiene permiso para actualizar añadir imagenes a este activo');
        }

        $documents = collect($request->file('documents'));

        $documents->each(function ($document) use ($asset) {
            $asset->addMedia($document)->toMediaLibrary('documents', 'documents');
        });

        $assetDocuments = $asset->getMedia('documents');

        return $this->response->collection($assetDocuments, new AssetDocumentsTransformer());

    }

    public function downloadDocument($assetId, $documentId)
    {
        $this->userCan('show');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($assetId);
        if (!$asset) {
            $this->response->errorForbidden('No tiene permiso para descragra documentos de este activo');
        }

        $assetDocuments = $asset->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });

        $document = $assetDocuments->first();
        $documentPath = $document->getPath();


        return response()->file($documentPath, ['Content-Type' => $document->mime_type, 'Content-Di‌​sposition' => 'inline']);
    }

    public function removeImage($assetId, $imageId)
    {
        $this->userCan('update');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($assetId);
        if (!$asset) {
            $this->response->errorForbidden('No tiene permiso para actualizar añadir imagenes a este activo');
        }

        $assetImages = $asset->getMedia('images', function ($image) use ($imageId) {
            return $image->id == $imageId;
        });

        $image = $assetImages->first();
        $image->delete();

        $assetImages = $asset->getMedia('images');

        return $this->response->collection($assetImages, new AssetImagesTransformer());

    }

    public function removeDocument($assetId, $documentId)
    {
        $this->userCan('update');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($assetId);
        if (!$asset) {
            $this->response->errorForbidden('No tiene permiso para actualizar añadir imagenes a este activo');
        }

        $assetDocuments = $asset->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });

        $document = $assetDocuments->first();
        $document->delete();

        $assetDocuments = $asset->getMedia('documents');

        return $this->response->collection($assetDocuments, new AssetDocumentsTransformer());

    }
}
