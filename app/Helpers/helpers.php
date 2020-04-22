<?php
if (!function_exists('get_collection_by_applying_filters')) {

    /**
     * Use this function to get your Collection records by custom sorting , filtering and you can also apply strict constraint record fetching
     * Basic Usage  Custom Build Datatable or pagination.
     * Sample data as function parameter available config file => "config('db_const.custom_datatable_filters_sample_json')"
     * @param array $filtersArray
     * @param string $modelName
     * @return mixed
     * @throws Exception
     */

    function get_collection_by_applying_filters(array $filtersArray, string $modelName)
    {
        if (empty($modelName))
            throw new \Exception('App Model Name Not Valid');

        if (!empty($filtersArray)) {

            $searchInColumn   = [];
            $searchStr = '';

            $sortColumn = !empty($filtersArray['sort']['sortColumn']) ? $filtersArray['sort']['sortColumn'] : '';
            $queryConstraints = !empty($filtersArray['constraints']) ? $filtersArray['constraints'] : [];
            $recordsPerPage = !empty($filtersArray['recordsPerPage']) ? $filtersArray['recordsPerPage'] : 10;
            $columnsToSelect = !empty($filtersArray['columns']) ? $filtersArray['columns'] : [];
            $relations = !empty($filtersArray['relations']) ? $filtersArray['relations'] : [];
            $whereHas = !empty($filtersArray['whereHas']) ? $filtersArray['whereHas'] : [];
            $page = !empty($filtersArray['page']) ? filter_var($filtersArray['page']) : 1;

            $sortOrder = (!empty($filtersArray['sort']['sortOrder']) && !empty($sortColumn)
                && in_array(strtolower($filtersArray['sort']['sortOrder']), ['asc', 'desc']))
                ? $filtersArray['sort']['sortOrder'] : 'Asc';

            if (!empty($filtersArray['search']['searchStr'])) {
                $searchStr = "%{$filtersArray['search']['searchStr']}%";
                $searchInColumn = ! empty($filtersArray['search']['searchInColumn']) ? $filtersArray['search']['searchInColumn'] : [];
            }


            $data = resolve($modelName)::with($relations)->where($queryConstraints);
            //Where In Constrains
            if(!empty($whereHas)){
                foreach ($whereHas as $in){
                    $data->whereIn($in['col'],$in['values']);
                }
            }

            // Apply Other Generic Constrains
            $data->where(
                function ($query) use ($searchStr, $searchInColumn) {
                    foreach ($searchInColumn as $column) {
                        $query->orWhere("{$column}", 'LIKE', $searchStr);
                    }
                }
            )->select($columnsToSelect);


            if (!empty($sortColumn)) // If Sort changed then apply
                $data->orderBy($sortColumn, $sortOrder);

            return $data->paginate($recordsPerPage, $columns = ['*'], 'page', $page); // Paginate
        } else {
            throw new \Exception('Filters not Valid.');
        }
    }
}
