<?php
/**
 * Created by IntelliJ IDEA.
 * User: ishara
 * Date: 10/6/22
 * Time: 10:15 AM
 */

namespace App\repo;


use App\Base\BaseRepository;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Model;

class TodoListRepository extends BaseRepository
{
    public function __construct(TodoList $model)
    {
        parent::__construct($model);
    }
}
