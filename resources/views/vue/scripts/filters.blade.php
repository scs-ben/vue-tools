@section('vue_scripts')
<script>
	vueSorts.date = function(field, a, b) {
		if(typeof(a[field]) == 'undefined'
			|| a[field] == ''
			|| a[field] == null) {
			a = moment('null');
		} else {
			a = moment(a[field]);
		}

		if(typeof(b[field]) == 'undefined'
			|| b[field] == ''
			|| b[field] == null) {
			b = moment('null');
		} else {
			b = moment(b[field]);
		}

		if(!a.isValid() && !b.isValid()) {
			return 0;
		} else if(a.isValid() && !b.isValid()) {
			return 1;
		} else if(!a.isValid() && b.isValid()) {
			return -1;
		} else if(a.isBefore(b, 'day')) {
			return -1;
		} else if(b.isBefore(a, 'day')) {
			return 1;
		} else {
			return 0;		
		}
	}

	vueSorts.dateTime = function(field, a, b) {
		if(typeof(a[field]) == 'undefined'
			|| a[field] == ''
			|| a[field] == null) {
			a = moment('null');
		} else {
			a = moment(a[field]);
		}

		if(typeof(b[field]) == 'undefined'
			|| b[field] == ''
			|| b[field] == null) {
			b = moment('null');
		} else {
			b = moment(b[field]);
		}

		if(!a.isValid() && !b.isValid()) {
			return 0;
		} else if(a.isValid() && !b.isValid()) {
			return 1;
		} else if(!a.isValid() && b.isValid()) {
			return -1;
		} else if(a.isBefore(b, 'second')) {
			return -1;
		} else if(b.isBefore(a, 'second')) {
			return 1;
		} else {
			return 0;		
		}
	}

	vueSorts.number = function(field, a, b) {
		if(a[field] > b[field]) {
			return 1;
		} else if(a[field] < b[field]) {
			return -1;
		} else {
			return 0;
		}
	}

	vueSorts.alpha = function(field, a, b) {
		return a[field].localeCompare(b[field]);
	}

	Vue.filter('date', function(date, format) {
		var filterDate
		if(date == '' || date == null) {
			filterDate = moment('null');
		} else {
			filterDate = moment(date);
		}
	    
	    if(filterDate.isValid()) {
	    	if(typeof(format) != 'undefined') {
	    		return filterDate.format(format);	
	    	} else {
	    		return filterDate.format("{{ config('vue.defaultDateFormat') }}");
	    	}
	    } else {
	        return '';
	    }
	});

	Vue.filter('length', function(array) {
	    return array.length;
	});

	Vue.filter('notIn', function(array, compareArray, compareElement) {
		if(typeof(compareElement) == 'undefined') {
			return array.filter(function(elem) {
		    	var index = compareArray.indexOf(elem);
		    	return (index == -1);
		    });	
		} else {
			return array.filter(function(elem) {
		    	var index = compareArray.findIndex(function(compareElem) {
		    		return elem[compareElement] == compareElem[compareElement];
		    	});

		    	return (index == -1);
		    });	
		}
	    
	});

	Vue.filter('orderMulti', function(array, sortColumns) {

		var tmpArray = array.filter(function() {
			return true;
		});

	    tmpArray.sort(function(a, b) {
	        for(var i = 0; i < sortColumns.length; i++) {
	            var result = vueSorts[sortColumns[i][2]](sortColumns[i][0], a, b) * sortColumns[i][1];
	            if((result) != 0) {
	                return result;
	            }
	        }
	        return 0;
	    });
	    return tmpArray;
	});
</script>
@endsection