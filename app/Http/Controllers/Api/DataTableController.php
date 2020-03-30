<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


abstract class DataTableController extends Controller
{
    protected $builder;

    abstract public function builder();

    public function __construct()
    {
        $builder = $this->builder();

        if (!$builder instanceof Builder) {
            throw new Exception('Entity builder not instalce of Builder');
        }

        $this->builder = $builder;
    }


    /**
     * Get Records
     *
     * @return illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'updatable' => array_values($this->getUpdatableColumns()),
                'records' => $this->getRecords($request),
            ]
        ]);
    }

    public function update($id, Request $request)
    {
        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }
    public function getDisplayableColumns()
    {
        return array_diff($this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden());
    }

    public function getUpdatableColumns()
    {
        return $this->getDisplayableColumns();
    }


    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function getRecords(Request $request)
    {
        return $this->builder->limit($request->limit)->orderBy('id','asc')->get($this->getDisplayableColumns());
    }
}
