$(function() {
    var edit_toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'align': [] }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'color': [] }, { 'background': [] }],   
        ['link'],
        ['clean']
    ];
    
    var edit_quill_th = new Quill('#edit_news_detail_th', {
        theme: 'snow',
        placeholder: 'Detail...',
        modules: {
            toolbar: edit_toolbarOptions
        }
    });

    var edit_quill_en = new Quill('#edit_news_detail_en', {
        theme: 'snow',
        placeholder: 'Detail...',
        modules: {
            toolbar: edit_toolbarOptions
        }
    });

    datatable_news(edit_quill_th, edit_quill_en);
    
    $('#news_public, #edit_news_public').daterangepicker({
        timePicker: true,
        startDate: moment(),
        singleDatePicker: true,
        showDropdowns: true,
        timePicker24Hour: true,
        applyButtonClasses: "btn-yellow",
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        },
        drops: "auto",
    });

    $("#frm_add_news").validate({
        ignore: ".quill *",
        rules: {
            add_title_th: {
              required: true
            },
            add_title_en : {
              required: true
            },
            add_news_img : {
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
            data.append("cmd", "add_news");
            data.append("add_news_detail_th", quill_th.root.innerHTML);
            data.append("add_news_detail_en", quill_en.root.innerHTML);
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/news.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add news', res.msg, "success")
                        datatable_news.ajax.reload();
                    } else {
                        alert_center('Update add news', res.msg, "error")
                    }
                }
            });

        } 
    });

    $("#from_edit_news").validate({
        ignore: ".quill *",
        rules: {
            edit_title_th: {
                required: true
              },
            edit_title_en : {
                required: true
            },
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
            data.append("cmd", "edit_news");
            data.append("edit_news_detail_th", edit_quill_th.root.innerHTML);
            data.append("edit_news_detail_en", edit_quill_en.root.innerHTML);
            $.ajax({
                type: "post",
                url: BASE_LANG + "service/news.php",
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
                      alert_center('Process edit news', msg, "success")
                      datatable_news.ajax.reload();
                      $('#modal_edit').modal('hide');
                  }else{
                      alert_center('Process edit news', msg, "error")
                  }
                }
            });

        } 
    });

    var toolbarOptions = [
		[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
		['bold', 'italic', 'underline', 'strike'],
		[{ 'align': [] }],
		[{ 'list': 'ordered'}, { 'list': 'bullet' }],
		[{ 'color': [] }, { 'background': [] }],   
		['link'],
		['clean']
	];

	var quill_th = new Quill('#add_news_detail_th', {
		theme: 'snow',
		placeholder: 'Detail...',
		modules: {
			toolbar: toolbarOptions
		}
	});

	var quill_en = new Quill('#add_news_detail_en', {
		theme: 'snow',
		placeholder: 'Detail...',
		modules: {
			toolbar: toolbarOptions
		}
	});

    $("#add_news_img").on('change', function(){
        var file = this.files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            $('img#show_news_img').attr('src', reader.result);
        }
        if (file) {
            reader.readAsDataURL(file);
        } else {
            return false;
        }
    });

    $('#new_youtube_url').on('change', function(){
        $('#news_iframe_src').attr('src', 'https://www.youtube.com/embed/' + this.value)
    });

    $("#modal_add").on("hidden.bs.modal", function () {
        $('#frm_add_news')[0].reset();
        $('#frm_add_news').find('.is-invalid').removeClass("is-invalid");
        $('#frm_add_news').find('.is-valid').removeClass("is-valid");
        $('#news_public').val(moment().format("YYYY-MM-DD HH:mm"));
    });

});

function datatable_news(edit_quill_th, edit_quill_en){

    datatable_news = $("#dtb_news").DataTable({
        responsive: true,
        pageLength: 10,
        ordering: false,
        ajax: {
            "url" : BASE_LANG + "service/news.php",
            "type": "POST",
            "data": function( d ){ 
                d.cmd = "news";
            }
        },
        type: "JSON",
        columns: [
            // { "data": "cus_id"},
            { "data": "NEWS_IMG", render: image},
            { "data": "NEWS_NAME_TH"},
            { "data": "NEWS_NAME_EN"},
            { "data": "NEWS_VDO_ID" , render : video},
            { "data": "NEWS_STATUS", render : status},
            { "data": "NEWS_PUBLICDATETIME", render: datetime},
            { "data": "NEWS_ID", render: tools}
        ],
        columnDefs: [
          { targets: [0, 3, 4], className: "text-center", width: "7%" },
          { targets: [5, 6], className: "text-center", width: "10%" },
          { targets: [1, 2], className: "truncate" }
        ]
    });

    $('#dtb_news tbody').on( 'click', '[name="news_img"]', function (e) {
        var row = $(this).closest("tr"); 
        var image_url = row.find('[name="news_img"]').attr('data-img');

        var modal_imgHTML = '';
        modal_imgHTML += '<div class="modal modal-blur fade" id="modal_gallery_imageGEN">';
        modal_imgHTML += '<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">';
        modal_imgHTML += '<div class="modal-content">';
        modal_imgHTML += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        modal_imgHTML += '<div class="modal-status bg-yellow"></div>';
        modal_imgHTML += '<div class="modal-body text-center py-4">';
        // modal_imgHTML += '<h3>' + gallery_name + '</h3>';
        // modal_imgHTML += '<div class="text-muted mb-3">' + gallery_alt + ' </div>';
        modal_imgHTML += '<img src="' + image_url + '" style="width: 100%;" class="mt-3">';
        modal_imgHTML += '</div>';
        modal_imgHTML += '<div class="modal-footer">';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        modal_imgHTML += '</div>';
        $('#modal_gallery_image').html(modal_imgHTML);
        $('#modal_gallery_imageGEN').modal('show');
    });

    $('#dtb_news tbody').on( 'click', '[name="remove"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="remove"]').attr('data-id');

        // MODAL REMOVE COURSE
        var remove_modalText  = 'Do you really want to remove this news?';
        var modalID           = 'modal_removeGen';
        var btn_remove_id     = 'submit_remove_gallery';
        modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_remove');

        $('#' + btn_remove_id).on('click', function(){
          $.ajax({
              type: "post",
              url: BASE_LANG + "service/news.php",
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
                      datatable_news.ajax.reload();
                      $('#' + modalID).modal('hide');
                  }else{
                      alert_center('Process remove', msg, "error")
                  }
              }
          });
        });
    });

    $('#dtb_news tbody').on( 'click', '[name="active"]', function (e) {
        var row = $(this).closest("tr"); 
        var id   = row.find('[name="active"]').attr('data-id');
        var active  = (this.checked == true) ? 'true' : 'false';

        $.ajax({
            type: "post",
            url: BASE_LANG + "service/news.php",
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
                    datatable_news.ajax.reload();
                }else{
                    alert_center('Process update', msg, "error")
                }
            }
        });
    });

    $('#dtb_news tbody').on( 'click', '[name="edit_news"]', function (e) { 
        $('#modal_edit').modal('show');
        var data = $(e.currentTarget).data();
        $('#news_id').val(data.id);
        $('#edit_show_news_img').attr("src", BASE_URL + 'images/news/' + data.image);
        $('#edit_title_th').val(data.titleTh);
        $('#edit_title_en').val(data.titleEn);
        $('#edit_new_youtube_url').val(data.video);
        $('#edit_news_iframe_src').attr('src', 'https://www.youtube.com/embed/' + data.video);
        $('#edit_news_public').val(data.public);

        $("#edit_news_img").on('change', function(){
            var file = this.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                $('img#edit_show_news_img').attr('src', reader.result);
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                return false;
            }
        });

        edit_quill_th.root.innerHTML = decode_quote(data.detailTh);
		edit_quill_en.root.innerHTML = decode_quote(data.detailEn);
        
        $('#edit_new_youtube_url').on('change', function(){
            $('#edit_news_iframe_src').attr('src', 'https://www.youtube.com/embed/' + this.value)
        });
    });
}

function status(data, type, row, meta){
    var checked = (data == 'true') ? 'checked' : '';
    var active_gHTML = '';
    active_gHTML += '<div class="ms-auto">';
    active_gHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
    active_gHTML += '<input data-id="' + row['NEWS_ID'] + '" name="active" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
    active_gHTML += '</label>';
    active_gHTML += '</div>';
    return active_gHTML;
}

function image(data, type, row, meta){
    var imagesUrl = BASE_URL + 'images/news/' + data;
    return '<a href="' + imagesUrl + '" target="_blank"><img src="' + imagesUrl + '" class="rounded w-100"></a>';
}

function video(data, type, row, meta){
    var videoUrl = 'https://img.youtube.com/vi/' + data + '/hqdefault.jpg';
    return '<a href="' + videoUrl + '" target="_blank"><img src="' + videoUrl + '" class="rounded w-100"></a>';
}

function datetime(data, type, row, meta){
    return moment(data).format('YYYY-MM-DD HH:mm:ss');
}

function tools(data, type, row) {
    var tools = '<button ';
        tools += ' data-id = "'         + data + '"';
        tools += ' data-image = "'      + row['NEWS_IMG'] + '"';
        tools += ' data-title-th = "'   + row['NEWS_NAME_TH'] + '"';
        tools += ' data-title-en = "'   + row['NEWS_NAME_EN'] + '"';
        tools += ' data-detail-th = "'  + encode_quote(row['NEWS_DETAIL_TH']) + '"';
        tools += ' data-detail-en = "'  + encode_quote(row['NEWS_DETAIL_EN']) + '"';
        tools += ' data-video = "'      + row['NEWS_VDO_ID'] + '"';
        tools += ' data-public = "'     + row['NEWS_PUBLICDATETIME'] + '"';
        tools += ' name="edit_news" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></button>';
        tools += '<button name="remove" data-id="' + data + '" class="btn btn-danger mx-1"><i class="far fa-trash-alt"></i></button>';
    return tools;
}