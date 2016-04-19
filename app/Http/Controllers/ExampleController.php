<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Example;
use Carbon\Carbon;

use App\Http\Controllers\VueController;

class ExampleController extends VueController
{
	public function getIndex() {
		$examples = Example::with('project')
			->ordered();

		$blankExample = new Example;
		$blankExample->project_id = 5;
		$blankExample->created_at = Carbon::now();
        $blankExample->updated_at = Carbon::now();
		$blankExample = new Collection($blankExample->attributesToArray());
		
		return view('example.index')
			->with('examples', $examples)
			->with('blankExample', $blankExample);
	}
}