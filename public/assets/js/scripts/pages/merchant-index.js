$(document).ready(function(){
	var merchantList = $('#merchantList').DataTable({
		processing: true,
		responsive: true,
		bSort: false,
		serverSide: true,
		columns:[
			{ "data": "image" },
			{ "data": "name" },
			{ "data": "type" },
			{ "data": "address" },
			{ "data": "phone" },
			{ "data": "mobile" },
			{ "data": "delivery" },
			{ "data": "action" }
		],
		bDestroy: true,
		sDom: "<'dt-toolbar'<'col-xs-6'fr><'col-xs-6'l>>"+
		"t"+
		"<'dt-toolbar-footer'<'col-xs-6'i><'col-xs-6'p>>",
		deferLoading: 100,
		ajax: {
			url: "/merchant/get-merchants",
			data: function (d) {}
		}
	}).draw();
});