<?php
/**
 * Created by IntelliJ IDEA.
 * User: ishara
 * Date: 10/6/22
 * Time: 10:47 AM
 */

namespace App\repo;


use App\Base\BaseRepository;
use App\Models\TodoItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TodoItemRepository extends BaseRepository
{
    public function __construct(TodoItem $model)
    {
        parent::__construct($model);
    }

    public function getPendingItems($todo_list_id,$uid)
    {
        return DB::select(DB::raw("select * from `todo_items` where todo_list_id = '$todo_list_id' and status = '1' and created_by = '$uid' order by `due_date` asc"));
    }

    public function getCompletedItems($todo_list_id,$uid)
    {
        return DB::select(DB::raw("select * from `todo_items` where todo_list_id = '$todo_list_id' and status = '2' and created_by = '$uid' order by `completed_at` desc"));
    }
}
