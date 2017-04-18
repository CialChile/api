<?php
namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Entities\Certification\Certification;
use App\Etrack\Entities\Certification\CertificationWorkerAsset;
use App\Etrack\Transformers\Asset\AssetCertificationTransformer;
use App\Etrack\Transformers\Asset\AssetDocumentsTransformer;
use App\Etrack\Transformers\Certification\CertificationTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Asset\Certification\AssetCertificationDocumentStoreRequest;
use App\Http\Request\Asset\Certification\AssetCertificationStoreRequest;
use App\Http\Request\Asset\Certification\AssetCertificationUpdateRequest;
use Carbon\Carbon;
use DB;

class AssetCertificationsController extends Controller
{
    public function __construct()
    {
        $this->module = 'client-assets';
    }

    public function index($assetId)
    {
        $this->userCan('show');
        $asset = Asset::inCompany()->with('certifications')->find($assetId);
        if (!$asset) {
            $this->response->errorForbidden('No tienes permiso para ver este activo');
        }

        return $this->response->collection($asset->certifications, new AssetCertificationTransformer());

    }

    public function show($assetId, $certificationId)
    {
        $this->userCan('show');
        $asset = Asset::inCompany()->with(['certifications' => function ($q) use ($certificationId) {
            return $q->where('certification_id', $certificationId);
        }])->find($assetId);
        if (!$asset) {
            $this->response->errorForbidden('No tienes permiso para ver este activo');
        }

        return $this->response->item($asset->certifications->first(), new AssetCertificationTransformer());

    }

    public function store(AssetCertificationStoreRequest $request, $assetId)
    {
        $this->userCan('update');
        $data = $request->all();
        /** @var Asset $asset */

        $asset = Asset::inCompany()->find($assetId);
        $certification = Certification::find($data['certification_id']);
        if (!$asset || !$certification) {
            $this->response->errorForbidden('No tienes permiso para realizar esta acción');
        }
        DB::beginTransaction();
        $validityUnit = $certification->validity_time_unit;
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['start_date']);
        if ($validityUnit === 0) {
            $endDate = $endDate->addDays($certification->validity_time);
        } else if ($validityUnit === 1) {
            $endDate = $endDate->addMonths($certification->validity_time);
        } else {
            $endDate = $endDate->addYears($certification->validity_time);
        }
        $certification = $asset->certifications()->save($certification, ['start_date' => $startDate->toDateString(), 'end_date' => $endDate->toDateString()]);
        DB::commit();
        return $this->response->item($certification, new CertificationTransformer());
    }

    public function update(AssetCertificationUpdateRequest $request, $assetId)
    {
        $this->userCan('update');
        $data = $request->all();
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($assetId);
        $certification = $asset->certifications()->find($data['certification_id']);
        if (!$asset || !$certification) {
            $this->response->errorForbidden('No tienes permiso para realizar esta acción');
        }

        DB::beginTransaction();
        $validityUnit = $certification->validity_time_unit;
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['start_date']);
        if ($validityUnit === 0) {
            $endDate = $endDate->addDays($certification->validity_time);
        } else if ($validityUnit === 1) {
            $endDate = $endDate->addMonths($certification->validity_time);
        } else {
            $endDate = $endDate->addYears($certification->validity_time);
        }
        $asset->certifications()->detach($certification->id);
        $asset->certifications()->attach($certification->id, ['start_date' => $startDate->toDateString(), 'end_date' => $endDate->toDateString()]);
        DB::commit();
        return $this->response->item($certification, new CertificationTransformer());
    }

    public function destroy($assetId, $certificationId)
    {
        $this->userCan('update');
        $asset = Asset::inCompany()->find($assetId);
        $certification = $asset->certifications()->find($certificationId);

        if (!$asset) {
            $this->response->errorForbidden('No tiene permiso para eliminar certificaciones de este activo');
        }
        DB::beginTransaction();
        $certificationDocuments = CertificationWorkerAsset::find($certification->pivot->id);
        $certificationDocuments->clearMediaCollection('documents');
        $asset->certifications()->detach($certificationId);
        DB::commit();
        return response()->json(['message' => 'Certificación de Activo Eliminada con Exito']);

    }

    public function uploadDocuments(AssetCertificationDocumentStoreRequest $request, $id, $certificationId)
    {
        $this->userCan('update');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($id);
        $certification = $asset->certifications()->find($certificationId);

        if (!$asset || !$certification) {
            $this->response->errorForbidden('No tienes permiso para realizar esta acción');
        }

        $documents = collect($request->file('documents'));
        $certificationAsset = CertificationWorkerAsset::find($certification->pivot->id);
        $documents->each(function ($document) use ($certificationAsset) {
            $certificationAsset->addMedia($document)->toMediaLibrary('documents', 'documents');
        });

        $certificationAssetDocumentos = $certificationAsset->getMedia('documents');

        return $this->response->collection($certificationAssetDocumentos, new AssetDocumentsTransformer());

    }

    public function downloadDocument($id, $certificationId, $documentId)
    {
        $this->userCan('show');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($id);
        $certification = $asset->certifications()->find($certificationId);

        if (!$asset || !$certification) {
            $this->response->errorForbidden('No tiene permiso para descragra documentos de este activo');
        }
        $certificationAsset = CertificationWorkerAsset::find($certification->pivot->id);

        $assetCertficationsDocuments = $certificationAsset->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });

        $document = $assetCertficationsDocuments->first();
        $documentPath = $document->getPath();


        return response()->file($documentPath, ['Content-Type' => $document->mime_type, 'Content-Di‌​sposition' => 'inline']);
    }

    public function removeDocument($id, $certificationId, $documentId)
    {
        $this->userCan('update');
        /** @var Asset $asset */
        $asset = Asset::inCompany()->find($id);
        $certification = $asset->certifications()->find($certificationId);

        if (!$asset || !$certification) {
            $this->response->errorForbidden('No tiene permiso para eliminar documentos de esta certificación');
        }

        $certificationAsset = CertificationWorkerAsset::find($certification->pivot->id);

        $assetCertficationsDocuments = $certificationAsset->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });
        $document = $assetCertficationsDocuments->first();
        $document->delete();

        $assetDocuments = $asset->getMedia('documents');

        return $this->response->collection($assetDocuments, new AssetDocumentsTransformer());

    }

}