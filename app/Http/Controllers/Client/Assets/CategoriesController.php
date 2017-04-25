<?php
namespace App\Http\Controllers\Client\Assets;

use App\Etrack\Entities\Assets\Category;
use App\Etrack\Repositories\Assets\CategoryRepository;
use App\Etrack\Transformers\Asset\CategoryTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\Config\CategoryStoreRequest;
use App\Http\Requests\Asset\Config\CategoryUpdateRequest;
use DB;
use Exception;
use Yajra\Datatables\Datatables;

class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->module = 'client-config-assets-categories';
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $this->userCan('list');
        $categories = $this->categoryRepository->scopeQuery(function (Category $query) {
            return $query->inCompany();
        })->all();

        return $this->response->collection($categories, new CategoryTransformer());
    }

    public function datatable()
    {
        return Datatables::of(Category::inCompany())
            ->setTransformer(CategoryTransformer::class)
            ->make(true);
    }

    public function show($id)
    {
        $this->userCan('show');
        $category = Category::inCompany()->find($id);
        if (!$category) {
            $this->response->errorForbidden('No tienes permiso para ver esta categoría');
        }

        return $this->response->item($category, new CategoryTransformer());
    }

    public function store(CategoryStoreRequest $request)
    {
        $this->userCan('store');
        $user = $this->loggedInUser();
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['company_id'] = $user->company_id;
            $category = $this->categoryRepository->create($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($category, new CategoryTransformer());
    }

    public function update(CategoryUpdateRequest $request, $categoryId)
    {
        $this->userCan('update');
        $user = $this->loggedInUser();
        $category = Category::inCompany()->find($categoryId);
        if (!$category) {
            $data['company_id'] = $user->company_id;
            $this->response->errorForbidden('No tiene permiso para actualizar esta categoría');
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->update($data, $categoryId);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        return $this->response->item($category, new CategoryTransformer());
    }

    public function destroy($brandId)
    {
        $this->userCan('destroy');
        $category = Category::inCompany()->find($brandId);
        if (!$category) {
            $this->response->errorForbidden('No tiene permiso para eliminar esta categoría');
        }

        DB::beginTransaction();
        try {
            $category->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        DB::commit();
        return response()->json(['message' => 'Categoría Eliminada con Exito']);
    }
}