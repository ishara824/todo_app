<?php
/**
 * Created by IntelliJ IDEA.
 * User: ishara
 * Date: 10/6/22
 * Time: 9:45 AM
 */

namespace App\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param object
     * @return mixed
     * @throws Exception
     */
    public function save(Model $object)
    {
        DB::beginTransaction();
        try {
            $object = $object->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception);
        }
        return $object;
    }

    public function saveAll(array $list)
    {
        DB::beginTransaction();
        try {
            $this->model->newQuery()->insert($list);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception);
        }
        return $list;
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes, int $id): bool
    {
        $object = null;
        DB::beginTransaction();
        try {
            $this->find($id)->update($attributes);
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc')
    {
        $this->model->belongsTo('App\User');
        return $this->model->newQuery()->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->newQuery()->where('id', $id)->first();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail(int $id)
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data)
    {
        return $this->model->newQuery()->where($data)->get();
    }

    public function count()
    {
        return $this->model->newQuery()->count();
    }

    public function findAll(array $data, int $pageSize = 10, string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->newQuery()->where($data)->orderBy($orderBy, $sortBy)->paginate($pageSize);
    }

    public function findAllByOrderBy(array $data, string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->newQuery()->where($data)->orderBy($orderBy, $sortBy)->get();
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function findByWithSql(string $data)
    {
        return $this->model->newQuery()->whereRaw($data)->get();
    }

    public function findBySqlWithPaginate(string $data,int $pageSize = 10)
    {
        return $this->model->newQuery()->whereRaw($data)->paginate($pageSize);
    }

    public function findByWithSqlAndPaginate(string $data,int $pageSize = 10){
        return $this->model->newQuery()->whereRaw($data)->paginate($pageSize);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->newQuery()->where($data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->newQuery()->where($data)->firstOrFail();
    }

    /**
     * @param array $data
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginateArrayResults(array $data, int $perPage = 50)
    {
        $page = request()->get('page', 1);
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
            array_slice($data, $offset, $perPage, false),
            count($data),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        return $this->model->newQuery()->where(['id'=>$id])->delete();
    }


    public function deleteAll(array $array, $withDetail = false): bool
    {
        try {
            $this->model->newQuery()->where($array);
            $this->model->delete();
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception);
        }
    }

}
