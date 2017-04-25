<?php
namespace App\Http\Controllers\Admin\Activities;

use App\Etrack\Entities\Activity\Activity;
use App\Etrack\Entities\Template\Template;
use App\Etrack\Transformers\Template\TemplateTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Template\TemplateStoreRequest;
use App\Http\Requests\Activity\Template\TemplateUpdateRequest;
use Datatables;
use DB;

class TemplatesController extends Controller
{

    public function __construct()
    {
        $this->module = 'admin-templates';

    }

    public function index()
    {

    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(Template::where('is_custom', false)->with(['programType']))
            ->setTransformer(TemplateTransformer::class)
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $template = Template::where('is_custom', false)->find($id);

        if (!$template) {
            $this->response->errorForbidden('No tienes permiso para ver esta platilla');
        }

        return $this->response->item($template, new TemplateTransformer());
    }

    public function store(TemplateStoreRequest $request)
    {
        $user = $this->loggedInUser();
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = null;
        $data['program_type_id'] = $data['program_type_id']['id'];
        $data['is_custom'] = false;
        $data['estimated_execution_time'] = 1;
        $template = new Template();
        $template->fill($data);
        $template->save();
        DB::commit();
        return $this->response->item($template, new TemplateTransformer());

    }

    public function update(TemplateUpdateRequest $request, $id)
    {
        $this->userCan('update');
        $template = Template::where('is_custom', false)->find($id);

        if (!$template) {
            $this->response->errorForbidden('No tiene permiso para actualizar esta plantilla');
        }
        $data = $this->cleanRequestData($request->all());
        $data['company_id'] = null;
        $data['program_type_id'] = $data['program_type_id']['id'];
        $data['is_custom'] = false;
        DB::beginTransaction();
        $template->fill($data);
        $template->save();
        DB::commit();
        return $this->response->item($template, new TemplateTransformer());

    }

    public function destroy($id)
    {
        $this->userCan('destroy');
        /** @var Template $template */
        $company_id = \Auth::user()->company_id;
        $template = Template::where('is_custom', false)->find($id);
        if (!$template) {
            $this->response->errorForbidden('No tiene permiso para eliminar esta platilla');
        }

        $templateActivities = Activity::where('template_id', $id)->get(['id']);
        if ($templateActivities->count()) {
            $this->response->errorForbidden('existen actividades asociadas a esta plantilla');
        }
        DB::beginTransaction();
        $template->delete();
        DB::commit();
        return response()->json(['message' => 'Plantilla Eliminada con Éxito']);
    }

}