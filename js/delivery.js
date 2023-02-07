$(function() {
    datatable();
    
    $("#frm_add_delivery").validate({
        rules: {
            add_delivery_name_th: {
              required: true
            },
            add_delivery_name_en : {
              required: true
            },
            add_delivery_type : {
              required: true
            },
            add_delivery_price : {
                required: true,
                numberOnly: true
            }
        },
        errorPlacement: function(error, element) {
        },
        errorClass: "help-inline text-danger",
        highlight: function(element) {
             $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
             $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
         },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');//.addClass('has-success');
            $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
         },
        submitHandler: function(form, e) {
            e.preventDefault();
            var data = new FormData($(form)[0]);
            data.append("cmd", "add_delivery");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/delivery.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add', res.msg, "success")
                        dtb_delivery.ajax.reload();
                    } else {
                        alert_center('Process update', res.msg, "error")
                    }
                }
            });

        } 
    });

    $("#from_edit_delivery").validate({
        rules: {
            edit_delivery_name_th: {
                required: true
            },
            edit_delivery_name_en : {
                required: true
            },
            edit_delivery_type : {
                required: true
            },
            edit_delivery_price : {
                required: true,
                numberOnly: true
            }
        },
        errorPlacement: function(error, element) {
        },
        errorClass: "help-inline text-danger",
        highlight: function(element) {
             $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
             $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
         },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');//.addClass('has-success');
            $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
  
         },
        submitHandler: function(form, e) {
            e.preventDefault();
            var data = new FormData($(form)[0]);
            data.append("cmd", "edit_delivery");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/delivery.php",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                dataType: "json",
                beforeSend: function(){
                  $(':button[type="submit"]').prop('disabled', true);
                },
                complete: function(){
                  $(':button[type="submit"]').prop('disabled', false);
                },
                success: function(res) {
                  var status = res['status'];
                  var msg = res['msg'];
                  if (status == true) {
                      alert_center('Process update', msg, "success")
                      dtb_delivery.ajax.reload();
                      $('#modal_edit').modal('hide');
                  }else{
                      alert_center('Process update', msg, "error")
                  }
                }
            });

        } 
    });

    $("#frm_delivery_type").validate({
        rules: {
            delivery_type_th: {
            required: true
            },
            delivery_type_en : {
            required: true
            }
        },
        errorPlacement: function(error, element) {
        },
        errorClass: "help-inline text-danger",
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error').removeClass('has-success');
            $(element).closest('.form-group').prevObject.addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');//.addClass('has-success');
            $(element).closest('.form-group').prevObject.removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            var data = new FormData($(form)[0]);
            data.append("cmd", "add_delivery_type");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/delivery.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add', res.msg, "success")
                        dtb_delivery_type.ajax.reload();
                    } else {
                        alert_center('Process add', res.msg, "error")
                    }
                }
            });

        } 
    });

    $("#modal_add").on("hidden.bs.modal", function () {
        $('#frm_add_delivery')[0].reset();
        $('#frm_add_delivery').find('.is-invalid').removeClass("is-invalid");
        $('#frm_add_delivery').find('.is-valid').removeClass("is-valid");
    });

    $("#modal_add_type").on("hidden.bs.modal", function () {
        $('#frm_delivery_type')[0].reset();
        $('#frm_delivery_type').find('.is-invalid').removeClass("is-invalid");
        $('#frm_delivery_type').find('.is-valid').removeClass("is-valid");
    });

    $('#btn_delivery_type').on('click', function(){
        $('#modal_add_type').modal('show');
        datatable_type();
    });

});

function datatable(){
    dtb_delivery = $("#dtb_delivery").DataTable({
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/delivery.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "delivery";
            }
        },
        type: "JSON",
        columns: [
            // { "data": "cus_id"},
            // { "data": "GALLERY_IMAGE", render: image},
            { "data": "DELIVERY_NAME_TH"},
            { "data": "DELIVERY_TYPE_ID", render: delivery_type },
            { "data": "DELIVERY_PRICE" },
            { "data": "DELIVERY_STATUS", render : status},
            { "data": "CREATEDATETIME", render: datetime},
            { "data": "DELIVERY_ID", render: tools}
        ],
        columnDefs: [
          { targets: [0, 1], className: "truncate", width: "30%" },
          { targets: [2,3,5], className: "text-center", width: "10%" },
          { targets: [4], className: "text-center", width: "20%" },
        //   { targets: [1, 2], width: "30%" }
        ]
    });


    $('#dtb_delivery tbody').on( 'click', '[name="remove"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="remove"]').attr('data-id');

        // MODAL REMOVE COURSE
        var remove_modalText  = 'Do you really want to remove this delivery?';
        var modalID           = 'modal_removeGEN';
        var btn_remove_id     = 'submit_delivery';
        modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_remove');

        $('#' + btn_remove_id).on('click', function(){
          $.ajax({
              type: "post",
              url: BASE_LANG + "service/delivery.php",
              data: {
                  "cmd": "remove",
                  "id": id
              },
              dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
              success: function(res) {
                  var status = res['status'];
                  var msg = res['msg'];
                  if (status == true) {
                      alert_center('Process remove', msg, "success")
                      dtb_delivery.ajax.reload();
                      $('#' + modalID).modal('hide');
                  }else{
                      alert_center('Process remove', msg, "error")
                  }
              }
          });
        });
    });

    $('#dtb_delivery tbody').on( 'click', '[name="active"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="active"]').attr('data-id');
        var active  = (this.checked == true) ? 'on' : 'off';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/delivery.php",
            data: {
                "cmd": "active",
                "id": id,
                "active": active
            },
            dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                var msg = res['msg'];
                if (status == true) {
                    alert_center('Process update', msg, "success")
                    dtb_delivery.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#dtb_delivery tbody').on( 'click', '[name="update"]', function (e) { 
        $('#modal_edit').modal('show');
        var data = $(e.currentTarget).data();
        $('#edit_delivery_name_th').val(data.nameTh);
        $('#edit_delivery_name_en').val(data.nameEn);
        $('#edit_delivery_price').val(data.price);
        $('#edit_delivery_id').val(data.id);
        $('#edit_delivery_type option[value="' + data.type + '"]').attr('selected', true);
    });
}

function datatable_type(){
    if ( $.fn.DataTable.isDataTable('#tb-delivery-type') ) {
        $('#tb-delivery-type').DataTable().destroy();
    }
    dtb_delivery_type = $("#tb-delivery-type").DataTable({
        dom: '<"ms-3"B>rt<"d-flex justify-content-between"ip>',
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/delivery.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "delivery_type";
            }
        },
        type: "JSON",
        columns: [
            { "data": "DELIVERY_TYPE_NAME_TH"},
            { "data": "DELIVERY_TYPE_NAME_EN"},
            { "data": "DELIVERY_TYPE_STATUS", render : type_status },
            { "data": "DELIVERY_TYPE_ID", render: type_tools}
        ],
        columnDefs: [
            { targets: [0, 1], className: "truncate"},
            { targets: 2, className: "text-center", width: "10%"},
            { targets: 3, className: "text-center", width: "10%"},
        //   { targets: [1, 2], width: "30%" }
        ]
    });

    $('#tb-delivery-type tbody').on( 'click', '[name="active_type"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="active_type"]').attr('data-id');
        var active  = (this.checked == true) ? 'on' : 'off';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/delivery.php",
            data: {
                "cmd": "active_type",
                "id": id,
                "active": active
            },
            dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                var msg = res['msg'];
                if (status == true) {
                    alert_center('Process update', msg, "success")
                    dtb_delivery_type.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#tb-delivery-type tbody').on( 'click', '[name="remove_type"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="remove_type"]').attr('data-id');

        // MODAL REMOVE COURSE
        // var remove_modalText  = 'Do you really want to remove this delivery?';
        // var modalID           = 'modal_remove_typeGEN';
        // var btn_remove_id     = 'submit-delivery-type';
        // modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_remove_type');

        // $('#' + btn_remove_id).on('click', function(){
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/delivery.php",
                data: {
                    "cmd": "remove_type",
                    "id": id
                },
                dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
                success: function(res) {
                    var status = res['status'];
                    var msg = res['msg'];
                    if (status == true) {
                        alert_center('Process remove', msg, "success")
                        dtb_delivery_type.ajax.reload();
                        // $('#' + modalID).modal('hide');
                    }else{
                        alert_center('Process remove', msg, "error")
                    }
                }
            });
        // });
    });

    $('#tb-delivery-type tbody').on( 'click', '[name="edit_type"]', function (e) {
        $(this).children('.fa-save, .fa-edit').toggleClass("fa-save fa-edit");
        $(this).attr('name','edit_save');
        var row = $(this).closest("tr");
        var tds = row.find("td").not(':last');
        
        $.each(tds, function(i, el) {
            var txt = $(this).text();
            if(i != 2){
                $(this).html("").append("<input class='form-control-tb form-control-tb-sm' id=\""+i+"\" style='width: 100%;' type='text' value=\""+txt+"\">");
            } 
        });

    });

    $('#tb-delivery-type tbody').on( 'click', '[name="edit_save"]', function (e) {
        $(this).attr('name','edit_type');
        var cars = new Array();
        var row_save = $(this).closest("tr");
        var id   = row_save.find('[name="edit_type"]').attr('data-id');
        var tds_save  = row_save.find('td').not(':last');
        $.each(tds_save, function(i, el) {
            if(i != 2){
                var type_val = $(this).find("input").val()
            }
            cars.push(type_val); 
        });

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/delivery.php",
            data: {
                "cmd": "edit_type",
                "type_id" : id,
                "type_th": cars[0],
                "type_en": cars[1]
            },
            dataType: "json",
            beforeSend: function(){
                $(':button[type="submit"]').prop('disabled', true);
            },
            complete: function(){
                $(':button[type="submit"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                var msg = res['msg'];
                if (status == true) {
                    alert_center('Process update', msg, "success")
                    dtb_delivery_type.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });
    
}

function status(data, type, row, meta){
    var checked = (data == 'on') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-id="' + row['DELIVERY_ID'] + '" name="active" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
}

function delivery_type(data, type, row, meta){
    return row['DELIVERY_TYPE_NAME_TH'] + ' (' + row['DELIVERY_TYPE_NAME_EN'] + ')';
}

function image(data, type, row, meta){
    var imagesUrl = BASE_URL + 'images/gallery/' + data;
    var images = '';
    images += '<div class="col-auto">';
    images += ' <img name="gallery_img" src="' + imagesUrl + '" ';
    images += ' data-img="'  + imagesUrl + '"';
    images += ' data-name="' + row['GALLERY_NAME'] + '"';
    images += ' data-alt="'  + row['GALLERY_ALT'] + '"';
    images += ' class="rounded cursor-pointer" width="100%" >'
    images += '</div>';

    return images;
}

function datetime(data, type, row, meta){
    return moment(data).format('YYYY-MM-DD HH:mm:ss');
}

function tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-id = "'       + data + '"';
        tools += ' data-name-th = "'  + row['DELIVERY_NAME_TH'] + '"';
        tools += ' data-name-en = "'  + row['DELIVERY_NAME_EN'] + '"';
        tools += ' data-type = "'     + row['DELIVERY_TYPE_ID'] + '"';
        tools += ' data-price = "'    + row['DELIVERY_PRICE'] + '"';
        tools += ' name="update" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button name="remove" data-id="' + data + '" class="btn btn-danger mx-1"><i class="far fa-trash-alt"></i></button>';
    return tools;
}

function type_status(data, type, row, meta){
    var checked = (data == 'on') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-id="' + row['DELIVERY_TYPE_ID'] + '" name="active_type" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
}

function type_tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-id = "'     + data + '"';
        tools += ' name="edit_type" type="button" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button type="button" name="remove_type"  data-id="' + data + '" class="btn btn-danger mx-1">'
        tools += '<i class="far fa-trash-alt"></i></button>';
    return tools;
}