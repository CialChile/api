<?php

namespace App\Etrack\Repositories\Template;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Etrack\Entities\Template\TemplateType;

/**
 * Class TemplateTypeRepositoryEloquent
 * @package namespace App\Etrack\Repositories\Template;
 */
class TemplateTypeRepositoryEloquent extends BaseRepository implements TemplateTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TemplateType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
