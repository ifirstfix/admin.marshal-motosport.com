$(function() {

    datatable_gallery();

    $("#frm_add_gallery").validate({
        rules: {
            add_gallery_name: {
              required: true
            },
            add_gallery_alt : {
              required: true
            },
            add_gallery_img : {
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
            data.append("cmd", "add_gallery");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/gallery.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add image', res.msg, "success")
                        datatable_gallery.ajax.reload();
                    } else {
                        alert_center('Update add image', res.msg, "error")
                    }
                }
            });

        } 
    });

    $("#from_edit_gallery").validate({
        rules: {
            edit_gallery_name: {
                required: true
            },
            edit_gallery_alt: {
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
            data.append("cmd", "edit_gallery");
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/gallery.php",
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
                      alert_center('Process edit image', msg, "success")
                      datatable_gallery.ajax.reload();
                      $('#modal_edit').modal('hide');
                  }else{
                      alert_center('Process edit image', msg, "error")
                  }
                }
            });

        } 
    });

    $("#add_gallery_img").on('change', function(){
        var file = this.files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            $('img#show_gallery_img').attr('src', reader.result);
        }
        if (file) {
            reader.readAsDataURL(file);
        } else {
            return false;
        }
    });

    $("#modal_add").on("hidden.bs.modal", function () {
        $('#frm_add_gallery')[0].reset();
        $('#frm_add_gallery').find('.is-invalid').removeClass("is-invalid");
        $('#frm_add_gallery').find('.is-valid').removeClass("is-valid");
    });

});

function datatable_gallery(){
    datatable_gallery = $("#dtb_gallery").DataTable({
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/gallery.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "gallery";
            }
        },
        type: "JSON",
        columns: [
            // { "data": "cus_id"},
            { "data": "GALLERY_IMAGE", render: image},
            { "data": "GALLERY_NAME"},
            { "data": "GALLERY_ALT" },
            { "data": "GALLERY_STATUS", render : status},
            { "data": "CREATEDATETIME", render: datetime},
            { "data": "GALLERY_ID", render: tools}
        ],
        columnDefs: [
          { targets: [0], className: "text-center", width: "7%" },
          { targets: [3], className: "text-center", width: "10%" },
          { targets: [4], className: "text-center", width: "20%" },
          { targets: [1, 2], width: "30%" }
        ]
    });


    $('#dtb_gallery tbody').on( 'click', '[name="gallery_img"]', function (e) {
        var row = $(this).closest("tr"); 
        var image_url = row.find('[name="gallery_img"]').attr('data-img');
        var gallery_name = row.find('[name="gallery_img"]').attr('data-name');
        var gallery_alt  = row.find('[name="gallery_img"]').attr('data-alt');

        var modal_imgHTML = '';
        modal_imgHTML += '<div class="modal modal-blur fade" id="modal_gallery_imageGEN">';
        modal_imgHTML += '<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">';
        modal_imgHTML += '<div class="modal-content">';
        modal_imgHTML += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        modal_imgHTML += '<div class="modal-status bg-yellow"></div>';
        modal_imgHTML += '<div class="modal-body text-center py-4">';
        modal_imgHTML += '<h3>' + gallery_name + '</h3>';
        modal_imgHTML += '<div class="text-muted mb-3">' + gallery_alt + ' </div>';
        modal_imgHTML += '<img src="' + image_url + '" style="width: 100%;">';
        modal_imgHTML += '</div>';
        modal_imgHTML += '<div class="modal-footer">';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        $('#modal_gallery_image').html(modal_imgHTML);
        $('#modal_gallery_imageGEN').modal('show');
    });

    $('#dtb_gallery tbody').on( 'click', '[name="remove_gallery"]', function (e) {
        var row = $(this).closest("tr"); 
        var gallery_id   = row.find('[name="remove_gallery"]').attr('data-rm-id');
        var gallery_name = row.find('[name="remove_gallery"]').attr('data-rm-name');

        // MODAL REMOVE COURSE
        var remove_modalText  = 'Do you really want to remove gallery name <br><b>' + gallery_name + '</b> ?';
        var modalID           = 'modal_removeGalleryGEN';
        var btn_remove_id     = 'submit_remove_gallery';
        modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_removeGallery');

        $('#' + btn_remove_id).on('click', function(){
          $.ajax({
              type: "post",
              url: BASE_LANG + "service/gallery.php",
              data: {
                  "cmd": "remove_gallery",
                  "gallery_id": gallery_id
              },
              dataType: "json",
              beforeSend: function(){
                $(':button[name="remove_course"]').prop('disabled', true);
              },
              complete: function(){
                $(':button[name="remove_course"]').prop('disabled', false);
              },
              success: function(res) {
                  var status = res['status'];
                  var msg = res['msg'];
                  if (status == true) {
                      alert_center('Process remove gallery', msg, "success")
                      datatable_gallery.ajax.reload();
                      $('#' + modalID).modal('hide');
                  }else{
                      alert_center('Process remove gallery', msg, "error")
                  }
              }
          });
        });
    });

    $('#dtb_gallery tbody').on( 'click', '[name="active_gallery"]', function (e) {
        var row = $(this).closest("tr"); 
        var gallery_ac_id   = row.find('[name="active_gallery"]').attr('data-ac-id');
        var gallery_active  = (this.checked == true) ? 'true' : 'false';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/gallery.php",
            data: {
                "cmd": "active_gallery",
                "gallery_ac_id": gallery_ac_id,
                "gallery_active": gallery_active
            },
            dataType: "json",
            beforeSend: function(){
              $(':button[name="active_gallery"]').prop('disabled', true);
            },
            complete: function(){
              $(':button[name="active_gallery"]').prop('disabled', false);
            },
            success: function(res) {
                var status = res['status'];
                var msg = res['msg'];
                if (status == true) {
                    alert_center('Process update gallery', msg, "success")
                    datatable_gallery.ajax.reload();
                    $('#' + modalID).modal('hide');
                }else{
                    alert_center('Process update gallery', msg, "error")
                }
            }
        });
    });

    $('#dtb_gallery tbody').on( 'click', '[name="edit_gallery"]', function (e) { 
        $('#modal_edit').modal('show');
        var data = $(e.currentTarget).data();
        $('#edit_gallery_name').val(data.name);
        $('#edit_gallery_alt').val(data.alt);
        $('#show_edit_gallery_img').attr("src", BASE_URL + 'images/gallery/' + data.image);
        $('#edit_g_id').val(data.id);
        $("#edit_gallery_img").on('change', function(){
            var file = this.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                $('img#show_edit_gallery_img').attr('src', reader.result);
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                return false;
            }
          });
        
    });
}

function status(data, type, row, meta){
    var checked = (data == 'true') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-ac-id="' + row['GALLERY_ID'] + '" name="active_gallery" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
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
        tools += ' data-id = "'     + data + '"';
        tools += ' data-image = "'  + row['GALLERY_IMAGE'] + '"';
        tools += ' data-name = "'   + row['GALLERY_NAME'] + '"';
        tools += ' data-alt = "'    + row['GALLERY_ALT'] + '"';
        tools += ' name="edit_gallery" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button name="remove_gallery" data-rm-name = "' + row['GALLERY_NAME'] ;
        tools += '" data-rm-id="' + data + '" class="btn btn-danger mx-1">'
        tools += '<i class="far fa-trash-alt"></i></button>';
    return tools;
}