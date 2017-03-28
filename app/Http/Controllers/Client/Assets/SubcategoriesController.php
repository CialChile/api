<?php
namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Category;
use App\Etrack\Entities\Assets\Subcategory;
use App\Etrack\Repositories\Assets\SubcategoryRepository;
use App\Etrack\Transformers\Asset\SubcategoryTransformer;
use App\Http\Controllers\Controller;
use App\Http\Request\Asset\Config\SubcategoryStoreRequest;
use App\Http\Request\Asset\Config\SubcategoryUpdateRequest;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Yajra\Datatables\Datatables;

class SubcategoriesController extends Controller
{
    /**
     * @var SubcategoryRepository
     */
    private $subcategoryRepository;

    public function __construct(SubcategoryRepository $subcategoryRepository)
    {
        $this->module = 'client-config-assets-subcategories';
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function index($categoryId)
    {
        $this->userCan('list');
        $subcategories = Subcategory::whereHas('category', function ($query) {
            /** @var Category $query */
            return $query->inCompany();
        })->where('category_id', $categoryId)->get();

        return $this->response->collection($subcategories, new SubcategoryTransformer());
    }

    public function datatable()
    {
        return Datatables::of(Subcategory::whereHas('category', function ($query) {
            /** @var Category $query */
            return $query->inCompany();
        })->with('category'))->setTransformer(SubcategoryTransformer::class)
            ->make(true);
    }

    public function show($categoryId, $subcategoryId)
    {
        $this->userCan('show');
        $category = Category::inCompany()->find($categoryId);
        if (!$category) {
            $this->response->errorForbidden('No tienes permiso para ver esta subcategoría de la categoría referenciada');
        }

        $subcategory = $category->subcategories()->find($subcategoryId);

        return $this->response->item($subcategory, new SubcategoryTransformer());
    }

    public function store(SubcategoryStoreRequest $request, $categoryId)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $user->load('company');
        $category = Category::inCompany()->find($categoryId);
        if (!$category) {
            $this->response->errorForbidden('No tiene permiso para guardar esta subcategoría en la categoría especificada');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $subcategory = $category->subcategories()->create($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($subcategory, new SubcategoryTransformer());
    }

    public function update(SubcategoryUpdateRequest $request, $categoryId, $subcategoryId)
    {
        $this->userCan('update');
        $category = Category::inCompany()->find($categoryId);
        if (!$category) {
            $this->response->errorForbidden('No tiene permiso para actualizar esta subcategoría en esta categoría');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $subcategory = $category->subcategories()->find($subcategoryId);
            /** @var Subcategory $subcategory */
            $subcategory = $subcategory->fill($data);
            $subcategory->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($subcategory, new SubcategoryTransformer());
    }

    public function destroy($categoryId, $subcategoryId)
    {
        $this->userCan('destroy');
        $category = Category::inCompany()->find($categoryId);
        if (!$category) {
            $this->response->errorForbidden('No tiene permiso para eliminar esta subcategoría de la categoría especificada');
        }

        DB::beginTransaction();
        try {
            /** @var Subcategory $subcategory */
            $subcategory = $category->subcategories()->find($subcategoryId);
            $subcategory->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        DB::commit();
        return response()->json(['message' => 'Subcategoría Eliminada con Exito']);
    }
}