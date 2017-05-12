<?php
namespace App\Http\Controllers\Client\Workers;

use App\Etrack\Entities\Certification\Certification;
use App\Etrack\Entities\Certification\CertificationWorkerAsset;
use App\Etrack\Entities\Worker\Worker;
use App\Etrack\Transformers\Asset\AssetDocumentsTransformer;
use App\Etrack\Transformers\Certification\CertificationTransformer;
use App\Etrack\Transformers\Worker\WorkerCertificationTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\Certification\WorkerCertificationDocumentStoreRequest;
use App\Http\Requests\Worker\Certification\WorkerCertificationStoreRequest;
use App\Http\Requests\Worker\Certification\WorkerCertificationUpdateRequest;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;

class WorkersCertificationsController extends Controller
{
    public function __construct()
    {
        $this->module = 'client-rrhh-workers';
    }

    public function index($workerId)
    {
        $this->userCan('show');
        $worker = Worker::inCompany()->with('certifications')->find($workerId);
        if (!$worker) {
            $this->response->errorForbidden('No tienes permiso para ver este trabajador');
        }

        return $this->response->collection($worker->certifications, new WorkerCertificationTransformer());

    }

    public function show($workerId, $certificationId)
    {
        $this->userCan('show');
        $worker = Worker::inCompany()->with(['certifications' => function ($q) use ($certificationId) {
            return $q->where('certification_id', $certificationId);
        }])->find($workerId);
        if (!$worker) {
            $this->response->errorForbidden('No tienes permiso para ver este trabajador');
        }

        return $this->response->item($worker->certifications->first(), new WorkerCertificationTransformer());

    }

    public function store(WorkerCertificationStoreRequest $request, $workerId)
    {
        $this->userCan('update');
        $data = $request->all();
        /** @var Worker $worker */
        $worker = Worker::inCompany()->find($workerId);
        /** @var Certification $certification */
        $certification = Certification::find($data['certification_id']);
        if (!$worker || !$certification) {
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
        $hasCertification = $worker->certifications()->where('certifications.id', $certification->id)->first();
        if ($hasCertification) {
            $this->response->errorForbidden('Este trabajador ya posee esta certificación asociada');
        }
        $certification = $worker->certifications()->save($certification, ['start_date' => $startDate->toDateString(), 'end_date' => $endDate->toDateString()]);
        DB::commit();
        return $this->response->item($certification, new CertificationTransformer());
    }

    public function update(WorkerCertificationUpdateRequest $request, $workerId)
    {
        $this->userCan('update');
        $data = $request->all();
        /** @var Worker $worker */
        $worker = Worker::inCompany()->find($workerId);
        $certification = $worker->certifications()->find($data['certification_id']);
        if (!$worker || !$certification) {
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
        $worker->certifications()->detach($certification->id);
        $worker->certifications()->attach($certification->id, ['start_date' => $startDate->toDateString(), 'end_date' => $endDate->toDateString()]);
        DB::commit();
        return $this->response->item($certification, new CertificationTransformer());
    }

    public function destroy($workerId, $certificationId)
    {
        $this->userCan('update');
        $worker = Worker::inCompany()->find($workerId);
        $certification = $worker->certifications()->find($certificationId);

        if (!$worker) {
            $this->response->errorForbidden('No tiene permiso para eliminar certificaciones de este trabajador');
        }
        DB::beginTransaction();
        $certificationDocuments = CertificationWorkerAsset::find($certification->pivot->id);
        $certificationDocuments->clearMediaCollection('documents');
        $worker->certifications()->detach($certificationId);
        DB::commit();
        return response()->json(['message' => 'Certificación de trabajador Eliminada con Exito']);

    }

    public function uploadDocuments(WorkerCertificationDocumentStoreRequest $request, $id, $certificationId)
    {
        $this->userCan('update');
        /** @var Worker $worker */
        $worker = Worker::inCompany()->find($id);
        $certification = $worker->certifications()->find($certificationId);

        if (!$worker || !$certification) {
            $this->response->errorForbidden('No tienes permiso para realizar esta acción');
        }

        $documents = collect($request->file('documents'));
        $certificationWorker = CertificationWorkerAsset::find($certification->pivot->id);
        $documents->each(function ($document) use ($certificationWorker) {
            $certificationWorker->addMedia($document)->toMediaLibrary('documents', 'documents');
        });

        $workerCertificationsDocuments = $certificationWorker->getMedia('documents');

        return $this->response->collection($workerCertificationsDocuments, new AssetDocumentsTransformer());

    }

    public function downloadDocument($id, $certificationId, $documentId)
    {
        $this->userCan('show');
        /** @var Worker $worker */
        $worker = Worker::inCompany()->find($id);
        $certification = $worker->certifications()->find($certificationId);

        if (!$worker || !$certification) {
            $this->response->errorForbidden('No tiene permiso para descragra documentos de este activo');
        }
        $certificationWorker = CertificationWorkerAsset::find($certification->pivot->id);

        /** @var Collection $workerCertificationsDocuments */
        $workerCertificationsDocuments = $certificationWorker->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });

        $document = $workerCertificationsDocuments->first();
        $documentPath = $document->getPath();


        return response()->file($documentPath, ['Content-Type' => $document->mime_type, 'Content-Di‌​sposition' => 'inline']);
    }

    public function removeDocument($id, $certificationId, $documentId)
    {
        $this->userCan('update');
        /** @var Worker $worker */
        $worker = Worker::inCompany()->find($id);
        $certification = $worker->certifications()->find($certificationId);

        if (!$worker || !$certification) {
            $this->response->errorForbidden('No tiene permiso para eliminar documentos de esta certificación');
        }

        $certificationWorker = CertificationWorkerAsset::find($certification->pivot->id);

        /** @var Collection $workerCertificationsDocuments */
        $workerCertificationsDocuments = $certificationWorker->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });
        $document = $workerCertificationsDocuments->first();
        $document->delete();

        $workerDocuments = $worker->getMedia('documents');

        return $this->response->collection($workerDocuments, new AssetDocumentsTransformer());

    }
}