<?php

namespace App\Http\Controllers\Admin\Activities;

use App\Etrack\Entities\Activity\ProgramType;
use App\Etrack\Entities\Template\Template;
use App\Etrack\Transformers\Activity\ProgramTypeTransformer;
use App\Http\Requests\Activity\ProgramTypeStoreRequest;
use App\Http\Requests\Activity\ProgramTypeUpdateRequest;
use Datatables;
use DB;
use App\Http\Controllers\Controller;

class ProgramTypesController extends Controller
{

    public function __construct()
    {
        $this->module = 'admin-program-types';
    }

    public function datatable()
    {
        $this->userCan('list');
        return Datatables::of(ProgramType::query())
            ->setTransformer(ProgramTypeTransformer::class)
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $programType = ProgramType::find($id);
        if (!$programType) {
            $this->response->errorForbidden('Tipo de Programa no encontrado');
        }
        return $this->response->item($programType, new ProgramTypeTransformer());
    }

    public function store(ProgramTypeStoreRequest $request)
    {
        $this->userCan('store');
        $data = $request->all();
        DB::beginTransaction();
        $programType = ProgramType::create($data);
        DB::commit();
        return $this->response->item($programType, new ProgramTypeTransformer());
    }

    public function update(ProgramTypeUpdateRequest $request, $id)
    {
        $this->userCan('update');
        $programType = ProgramType::find($id);
        if (!$programType) {
            $this->response->errorForbidden('Tipo de Programa no encontrado');
        }
        $data = $request->all();
        DB::beginTransaction();
        $programType->fill($data);
        $programType->save();

        DB::commit();

        return $this->response->item($programType, new ProgramTypeTransformer());
    }

    public function destroy($id)
    {
        $this->userCan('destroy');
        /** @var ProgramType $programType */
        $programType = ProgramType::find($id);
        if (!$programType) {
            $this->response->errorForbidden('Tipo de Programa no encontrado');
        }

        $templates = Template::where('program_type_id', $id)->get();
        if ($templates->count()) {
            $this->response->errorForbidden('Este Tipo de Programa ya se esta utilizando en una o más plantillas, por lo que no puede ser eliminado');
        }

        DB::beginTransaction();
        $programType->delete();
        DB::commit();
        return response()->json(['message' => 'Tipo de programa Eliminado con Éxito']);
    }
}
