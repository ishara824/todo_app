<?php
/**
 * Created by IntelliJ IDEA.
 * User: ishara
 * Date: 10/6/22
 * Time: 9:49 AM
 */

namespace App\repo;


use App\Base\BaseRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
