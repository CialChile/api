<?php
namespace App\Http\Controllers\Client\Certifications;

use App\Etrack\Entities\Certification\Certification;
use App\Etrack\Repositories\Certification\CertificationRepository;
use App\Etrack\Services\Client\Certification\CertificationValidationService;
use App\Etrack\Transformers\Certification\CertificationDocumentsTransformer;
use App\Etrack\Transformers\Certification\CertificationTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Certification\CertificationDocumentStoreRequest;
use App\Http\Requests\Certification\CertificationStoreRequest;
use App\Http\Requests\Certification\CertificationUpdateRequest;
use DB;
use Dingo\Api\Http\Request;
use Yajra\Datatables\Datatables;

class CertificationsController extends Controller
{
    /**
     * @var CertificationRepository
     */
    private $certificationRepository;
    /**
     * @var CertificationValidationService
     */
    private $certificationValidationService;

    public function __construct(CertificationRepository $certificationRepository, CertificationValidationService $certificationValidationService)
    {
        $this->module = 'client-certifications-certifications';
        $this->certificationRepository = $certificationRepository;
        $this->certificationValidationService = $certificationValidationService;
    }

    public function index()
    {

    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Certification::inCompany()->with(['institute', 'status'])->select('certifications.*'))
            ->setTransformer(CertificationTransformer::class)
            ->make(true);
    }

    public function show($certificationId)
    {
        $this->userCan('show');
        $certification = Certification::inCompany()->find($certificationId);
        if (!$certification) {
            $this->response->errorForbidden('No tienes permiso para ver esta certificación');
        }

        return $this->response->item($certification, new CertificationTransformer());
    }

    public function store(CertificationStoreRequest $request)
    {
        $user = $this->loggedInUser();
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = $user->company_id;
        $certification = new Certification();
        $certification->fill($data);
        $certification->save();
        DB::commit();
        return $this->response->item($certification, new CertificationTransformer());

    }

    public function update(CertificationUpdateRequest $request, $certificationId)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        /** @var Certification $certification */
        $certification = Certification::inCompany()->with(['assets', 'workers'])->find($certificationId);
        if (!$certification) {
            $this->response->errorForbidden('No tiene permiso para actualizar esta certificación');
        }
        $data = $this->cleanRequestData($request->all());
        $data['company_id'] = $user->company_id;
        $this->certificationValidationService->validateCertificationTypeChange($certification, (int)$data['type']);
        DB::beginTransaction();
        $certification->fill($data);
        $certification->save();
        DB::commit();
        return $this->response->item($certification, new CertificationTransformer());

    }

    public function destroy($certificationId)
    {
        $this->userCan('destroy');
        $certificationToDestroy = Certification::inCompany()->find($certificationId);
        if (!$certificationToDestroy) {
            $this->response->errorForbidden('No tiene permiso para eliminar esta certificación');
        }
        DB::beginTransaction();
        $certificationToDestroy->delete();
        DB::commit();
        return response()->json(['message' => 'Certificación Eliminada con Exito']);

    }

    public function uploadDocuments(CertificationDocumentStoreRequest $request, $id)
    {
        $this->userCan('update');
        /** @var Certification $certification */
        $certification = Certification::inCompany()->find($id);
        if (!$certification) {
            $this->response->errorForbidden('No tiene permiso para actualizar añadir imagenes a esta certificación');
        }

        $documents = collect($request->file('documents'));

        $documents->each(function ($document) use ($certification) {
            $certification->addMedia($document)->toMediaLibrary('documents', 'documents');
        });

        $certificationDocuments = $certification->getMedia('documents');

        return $this->response->collection($certificationDocuments, new CertificationDocumentsTransformer());

    }

    public function downloadDocument($certificationId, $documentId)
    {
        $this->userCan('show');
        /** @var Certification $certification */
        $certification = Certification::inCompany()->find($certificationId);
        if (!$certification) {
            $this->response->errorForbidden('No tiene permiso para descragra documentos de esta certificación');
        }

        $certificationDocuments = $certification->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });

        $document = $certificationDocuments->first();
        $documentPath = $document->getPath();


        return response()->file($documentPath, ['Content-Type' => $document->mime_type, 'Content-Di‌​sposition' => 'inline']);
    }

    public function removeDocument($certificationId, $documentId)
    {
        $this->userCan('update');
        /** @var Certification $certification */
        $certification = Certification::inCompany()->find($certificationId);
        if (!$certification) {
            $this->response->errorForbidden('No tiene permiso para actualizar añadir documentos a esta certificación');
        }

        $certificationDocuments = $certification->getMedia('documents', function ($document) use ($documentId) {
            return $document->id == $documentId;
        });

        $document = $certificationDocuments->first();
        $document->delete();

        $certificationDocuments = $certification->getMedia('documents');

        return $this->response->collection($certificationDocuments, new CertificationDocumentsTransformer());

    }

    public function search(Request $request)
    {
        $name = $request->get('name');
        $type = $request->get('type');
        if ($type === null) {
            return $this->response->errorForbidden('Debe establecer un tipo de certificación');
        }
        $certfications = Certification::inCompany()->where('type', $type)->orWhere('type', 2);
        if ($name) {
            $certfications->where("name", $name);
        }


        $certfications = $certfications->take(10)->get();
        return $this->response->collection($certfications, new CertificationTransformer());
    }
}