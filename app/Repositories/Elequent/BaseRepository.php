<?php

namespace App\Repositories\Elequent;

use Illuminate\Database\Eloquent\Model;
use Dotenv\Exception\ValidationException;

class BaseRepository
{
    protected $model;

    public function find($id)
    {
        return $this->model->find($id);
    }
    public function create(array $input)
    {

        return   $this->model->create($input);
    }
    public function all()
    {
        return  $this->model->all();
    }


    public function update(string $id, array $update_data)
    {
        $model = $this->find($id);
        if (empty($model)) {
            throw new ValidationException("Post not found", 1);
        }
        $model->update($update_data);
        return $model;
    }

    public function delete($id)
    {
        $query = $this->find($id)->delete();
        return $query;
    }

    public function search(array $search_inputs)
    {
        $query = $this->model;

        if (!empty($search_inputs['relation'])) {

            $query = $query->with($search_inputs['relation']);
        }

        if (!empty($search_inputs['where'])) {

            foreach ($search_inputs['where'] as $key => $value) {
                $query = $query->where($key, $value);
            }
        }

        if (!empty($search_inputs['like'])) {

            foreach ($search_inputs['like'] as $key => $value) {

                $query->where($key, 'like', '%' . $value . '%');
            }
        }

        $total = $query->count();

        $dump =  $search_inputs['dump'] ?? false;
        $offset =  $search_inputs['offset'] ?? 0;
        $limit =  $search_inputs['limit'] ?? 10;

        $result = $dump ? $query->get()->toArray() :  $query->skip($offset)->take($limit)->get()->toArray() ;

        $result = [
            'total' => $total,
            'returned' => count($result),
            'result' => $result,
        ];

        return $result;
    }
}
