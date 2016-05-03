@section('vue_scripts')
<script>
	var Ajax = function() {};

	Ajax.saveForm = function(records, model, url) {
		$.ajax({
			dataType: "JSON",
			method: "POST",
			url: url,
			data: {records: JSON.stringify(records)},
		}).done(function(data) {
			model.storedRecords = data;
		 	var recordKeys = Object.keys(records);
		 	for(var i = 0; i < recordKeys.length; i++) {
		 		if(records[recordKeys[i]].type == 'object') {
		 			if(records[recordKeys[i]].data.vue_created == 1) {
		 				records[recordKeys[i]].data.id = model.storedRecords[recordKeys[i]].data.id;
		 			}
		 			records[recordKeys[i]].data.vue_created = false;
		 			records[recordKeys[i]].data.vue_updated = false;
		 			records[recordKeys[i]].data.vue_deleted = false;
		 			model.storedRecords[recordKeys[i]].data.vue_created = false;
		 			model.storedRecords[recordKeys[i]].data.vue_updated = false;
		 			model.storedRecords[recordKeys[i]].data.vue_deleted = false;
		 		} else if(records[recordKeys[i]].type == 'array') {
		 			if(typeof(model.storedRecords[recordKeys[i]].data) == 'undefined') {
		 				model.storedRecords[recordKeys[i]].data = [];
		 			}
		 			for(var k = 0; k < records[recordKeys[i]].data.length; k++) {
		 				if(records[recordKeys[i]].data[k].vue_created == 1) {
			 				records[recordKeys[i]].data[k].id = model.storedRecords[recordKeys[i]].data[k].id;
			 			}
			 			records[recordKeys[i]].data[k].vue_created = false;
			 			records[recordKeys[i]].data[k].vue_updated = false;
			 			model.storedRecords[recordKeys[i]].data[k].vue_created = false;
			 			model.storedRecords[recordKeys[i]].data[k].vue_updated = false;

			 			if(records[recordKeys[i]].data[k].vue_deleted == 1) {
			 				records[recordKeys[i]].data.splice(k, 1);
			 				k -= 1;
			 			}
		 			}
		 		}
		 	}
		}).fail(function() {
			alert('There was an error when trying to reach the server');
			model.resetForm();
		});
	};

	Ajax.saveNewForm = function(records, model, url) {
		$.ajax({
			dataType: "JSON",
			method: "POST",
			url: url,
			data: {records: JSON.stringify(records)},
		}).done(function(data) {
			model.storedRecords = data;
		 	var recordKeys = Object.keys(records);
		 	for(var i = 0; i < recordKeys.length; i++) {
		 		if(records[recordKeys[i]].type == 'object') {
		 			if(records[recordKeys[i]].data.vue_created == 1) {
		 				records[recordKeys[i]].data = clone(model.storedRecords[recordKeys[i]].data);
		 			}
		 			records[recordKeys[i]].data.vue_created = false;
		 			records[recordKeys[i]].data.vue_updated = false;
		 			records[recordKeys[i]].data.vue_deleted = false;
		 			model.storedRecords[recordKeys[i]].data.vue_created = false;
		 			model.storedRecords[recordKeys[i]].data.vue_updated = false;
		 			model.storedRecords[recordKeys[i]].data.vue_deleted = false;
		 		} else if(records[recordKeys[i]].type == 'array') {
		 			if(typeof(model.storedRecords[recordKeys[i]].data) == 'undefined') {
		 				model.storedRecords[recordKeys[i]].data = [];
		 			}
		 			for(var k = 0; k < records[recordKeys[i]].data.length; k++) {
		 				if(records[recordKeys[i]].data[k].vue_created == 1) {
		 					records[recordKeys[i]].data[k] = clone(model.storedRecords[recordKeys[i]].data[k]);
			 			}
			 			records[recordKeys[i]].data[k].vue_created = false;
			 			records[recordKeys[i]].data[k].vue_updated = false;
			 			model.storedRecords[recordKeys[i]].data[k].vue_created = false;
			 			model.storedRecords[recordKeys[i]].data[k].vue_updated = false;

			 			if(records[recordKeys[i]].data[k].vue_deleted == 1) {
			 				records[recordKeys[i]].data.splice(k, 1);
			 				k -= 1;
			 			}
		 			}
		 		}
		 	}
		 	var keys = Object.keys(model.$root.blanks);
		 	for(var i = 0; i < keys.length; i++) {
		 		model.$root.blanks[keys[i]]['project_id'] = model.storedRecords.project.data.id;
		 	}
		}).fail(function() {
			alert('There was an error when trying to reach the server');
			model.resetForm();
		});
	};

	Ajax.saveSingle  = function(record, model, url, recordSetIndex) {
		var ajax = this;
		$.ajax({
			dataType: "JSON",
			method: "POST",
			url: url,
			data: {record: JSON.stringify(record)},
		}).done(function(data) {
			if(typeof(recordSetIndex) != 'undefined' && recordSetIndex > 0) {
				model.recordSet.data[recordSetIndex] = data;
				model.recordSet.data[recordSetIndex].vue_created = false;
				model.recordSet.data[recordSetIndex].vue_updated = false;
				model.recordSet.data[recordSetIndex].vue_deleted = false;
				var tmp = model.recordSet.data;
				model.recordSet.data = [];
				model.recordSet.data = tmp;
			}

		}).fail(function() {
			alert('There was an error when trying to reach the server');
			model.resetRecord();
		});
	};

	Ajax.delete  = function(record, url) {
		var ajax = this;
		$.ajax({
			dataType: "JSON",
			method: "POST",
			url: url,
			data: {record: JSON.stringify(record)},
		}).done(function(data) {
			//model.storedRecord = data;
		}).fail(function() {
			alert('There was an error when trying to reach the server');
			//model.resetRecord();
		});
	};
</script>
@append