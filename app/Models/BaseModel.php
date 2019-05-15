<?php
/**
 * Created by yuxianjun001@icloud.com.
 * User: wuchen
 * Date: 2019/3/27
 * Time: 11:56
 */

namespace App\models;

use App\Helpers\ArrayHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class BaseModel extends Model
{

    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * 手动分页
     * @param $query
     * @param $request
     * @param string $count_distinct
     * @return array
     */
    public  function buildPaginate($query, $request, $count_distinct = '')
    {
        $page     = $request->input('page', 1);//第几页
        $perPage = $request->input('perPage', 10); //每页多少数据
        if ($count_distinct) {
            $count = $query->distinct()->count([$count_distinct]);
        } else {
            $count = $query->count();
        }
        $pages = intval(ceil($count / $perPage));
        $page  = intval($page);
        $page  = $page < 1 ? 1 : $page;
        if ($page > $pages || !$count) {
            $list = [];
        } else {
            $offset = ($page - 1) * $perPage;
            $list   = $query->skip($offset)->take($perPage)->get();
        }

        if(!empty($list)){
            $list=$list->toArray();
        }
        return [
            'page'        => $page,
            'perPage'        =>$perPage,
            'pages'       => $pages,
            'totalCount' => $count,
            'list'        => $list,
        ];
    }

}