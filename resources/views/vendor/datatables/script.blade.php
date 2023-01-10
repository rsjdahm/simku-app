$(function(){window.{{ config('datatables-html.namespace', 'LaravelDataTables') }}=window.{{ config('datatables-html.namespace', 'LaravelDataTables') }}||{};window.{{ config('datatables-html.namespace', 'LaravelDataTables') }}["%1$s"]=$("#%1$s").DataTable(%2$s);});

$.extend(true, $.fn.dataTable.defaults, {
{{-- "scrollY": "60vh",
"scrollX": true,
"scrollCollapse": true, --}}
"language": {
"processing": "Sedang memproses...",
"lengthMenu": "Tampilkan _MENU_ entri",
"zeroRecords": "Tidak ada data.",
"info": "Menampilkan _START_-_END_ dari _TOTAL_ entri",
"infoEmpty": "",
"emptyTable": "Tidak ada data.",
"infoFiltered": "Difilter dari total _MAX_ data.",
"search": "Cari:",
"paginate": {
"previous": "<i class='fas fa-arrow-left'></i>",
"next": "<i class='fas fa-arrow-right'></i>"
}
}
});


$(document).on("init.dt", function(e, settings) {
const api = new $.fn.dataTable.Api(settings);
const inputs = $(settings.nTable).closest(".dataTables_wrapper").find(".dataTables_filter input");
inputs.unbind();
inputs.each(function(e) {
const input = this;
$(input).closest("form").on("keyup keypress", function(e) {
const keyCode = e.keyCode || e.which;
if (keyCode == 13) {
e.preventDefault();
return false;
}
});
$(input).bind("keyup", function(e) {
if (e.keyCode == 13) {
api.search(this.value).draw();
}
});
$(input).bind("input", function(e) {
if (this.value == "") {
api.search(this.value).draw();
}
});
});
});

{{-- $("#%1$s").addClass('bg-white'); --}}
$("#%1$s thead").addClass('bg-primary text-white');
$("#%1$s thead th").addClass('align-middle text-center');

$("[data-filter-datatable='#%1$s']").change(function() {
$("#%1$s").DataTable().ajax.reload(null, false);
});
$("[name$='_filter_datatable_%1$s']").change(function() {
$("#%1$s").DataTable().ajax.reload(null, false);
});
