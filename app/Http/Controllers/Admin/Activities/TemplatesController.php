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
        $data = $request->all();
        DB::beginTransaction();
        $data['company_id'] = null;
        $data['program_type_id'] = $data['program_type_id']['id'];
        $data['is_custom'] = false;
        $data['active'] = true;
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
        $template = Template::where('is_custom', false)->with('activities')->find($id);
        if ($template->activities->count()) {
            $this->response->errorForbidden('No puede modificar esta plantilla pues existen actividades asociadas a ella');
        }
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
        $template = Template::where('is_custom', false)->with('activities')->find($id);
        if (!$template) {
            $this->response->errorForbidden('No tiene permiso para eliminar esta platilla');
        }

        if ($template->activities->count()) {
            $this->response->errorForbidden('No puede eliminar esta plantilla pues existen actividades asociadas a ella');
        }

        DB::beginTransaction();
        $template->delete();
        DB::commit();
        return response()->json(['message' => 'Plantilla Eliminada con Éxito']);
    }

    public function toggleActive($id)
    {
        $this->userCan('update');
        /** @var Template $template */
        $template = Template::where('is_custom', false)->find($id);
        if (!$template) {
            $this->response->errorForbidden('No tiene permiso para actualizar esta platilla');
        }
        DB::beginTransaction();
        $template->active = !$template->active;
        $template->save();
        DB::commit();
        return response()->json(['message' => !$template->active ? 'Plantilla desactivada' : 'Plantilla activada']);
    }


}