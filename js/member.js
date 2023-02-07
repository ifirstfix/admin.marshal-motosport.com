$(function() {
    datatable_register = $("#datatable_register").DataTable({
        "scrollX": true,
        "pageLength": 10,
        "responsive": true,
        "paging": true,
        "processing": true,
        "ordering": false,
        "ajax": {
            "url" : BASE_LANG + "service/member.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd     = "member";
            },
            "beforeSend": function(){
            },
            "complete": function(){
            }
        },
        "type":'JSON',
        "columns": [
            { "data": "MEMBER_TYPE"},
            { "data": "MEMBER_NAME" },
            { "data": "MEMBER_SURNAME" },
            { "data": "MEMBER_EMAIL" },
            { "data": "MEMBER_FACEBOOK" },
            { "data": "MEMBER_GOOGLE" },
            { "data": "CREATEDATETIME", render: datetime}
        ],
        "columnDefs": [
            { targets: [0, 6], className: "text-center" },
        ],
        "initComplete": function( settings, start, end, max, total, pre ) {
        }
    });


    function datetime(data, type, row, meta){
        return moment(data).format('YYYY-MM-DD HH:mm:ss');
    }
});



