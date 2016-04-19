<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class VueController extends Controller
{

    public function saveRecords($records)
    {       
        foreach($records as $record) {
            $modelName = $record->model;
            if($record->type == 'object') {
                $record->data->vue_updated = false;
                if($record->data->vue_deleted == true) {
                    if($record->data->vue_created != 1) {
                        $model = $modelName::find($record->data->id);
                        $model->deleteRecord();
                    }
                } else if($record->data->vue_created == true) {
                    $model = new $modelName();
                    $record->data->vue_created = false;
                    $model->fill(get_object_vars($record->data));
                    $model->save();
                    $record->data->id = $model->id;
                } else {
                    $model = $modelName::find($record->data->id);
                    $model->fill(get_object_vars($record->data));
                    $model->save();
                }
            } else if($record->type == 'array') {
                if(isset($record->data)) {
                    foreach($record->data as $index => $record) {
                        if($record->vue_deleted == true) {
                            if($record->vue_created != 1) {
                                $model = $modelName::find($record->id);
                                $model->deleteRecord();
                                array_splice($record->data, $index, 1);
                            }
                        } else if($record->vue_created == true) {
                            $record->vue_created = false;
                            $record->vue_updated = false;
                            $model = new $modelName();
                            $model->fill(get_object_vars($record));
                            $model->save();
                            $record->id = $model->id;
                        } else {
                            $model = $modelName::find($record->id);
                            $record->vue_updated = false;
                            $model->fill(get_object_vars($record));
                            $model->save();
                        }
                    }    
                }
            }
        }
        
        return response()->json($records);
    }
    public function saveRecord($record)
    {
        $modelName = $record->model;
        $model;
        if($record->data->vue_created == true) {
            $model = new $modelName;
            $record->data->vue_created = false;
        } else {
            $model = $modelName::find($record->data->id);    
        }
        $record->data->vue_created = false;
        $record->data->vue_updated = false;
        $model->fill(get_object_vars($record->data));
        $model->save();
        
        $record->data->id = $model->id;
        
        return response()->json($record->data);
    }

    public function deleteRecord($record)
    {
        $modelName = $record->model;
        $model = $modelName::find($record->id);
        $model->deleteRecord();
        
        return response()->json($record);
    }
}