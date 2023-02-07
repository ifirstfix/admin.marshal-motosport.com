$(function() {
	// $("#btn_banner").on('click', function(){
	// 	add_banner();
	// });
	var edit_toolbarOptions = [
		[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
		['bold', 'italic', 'underline', 'strike'],
		[{ 'align': [] }],
		[{ 'list': 'ordered'}, { 'list': 'bullet' }],
		[{ 'color': [] }, { 'background': [] }],   
		['link'],
		['clean']
	];

	var quill_edit_th = new Quill('#edit_banner_detail_th', {
		theme: 'snow',
		placeholder: 'Detail...',
		modules: {
			toolbar: edit_toolbarOptions
		}
	});

	var quill_edit_en = new Quill('#edit_banner_detail_en', {
		theme: 'snow',
		placeholder: 'Detail...',
		modules: {
			toolbar: edit_toolbarOptions
		}
	});

	show_banner(quill_edit_th, quill_edit_en);

	$("#add_banner_img").on('change', function(){
		var file = this.files[0];
		var reader = new FileReader();
		reader.onloadend = function () {
			$('img#banner_img').attr('src', reader.result);
		}
		if (file) {
			reader.readAsDataURL(file);
		} else {
			return false;
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
	var quill_th = new Quill('#add_banner_detail_th', {
		theme: 'snow',
		placeholder: 'Detail...',
		modules: {
			toolbar: toolbarOptions
		}
	});

	var quill_en = new Quill('#add_banner_detail_en', {
		theme: 'snow',
		placeholder: 'Detail...',
		modules: {
			toolbar: toolbarOptions
		}
	});

	$("#modal_add").on("hidden.bs.modal", function () {
        $('#add_banner')[0].reset();
        $('#add_banner').find('.is-invalid').removeClass("is-invalid");
        $('#add_banner').find('.is-valid').removeClass("is-valid");
    });

	$("#add_banner").validate({
		ignore: ".quill *",
		rules: {
		   add_banner_alt: {
			  required: true
			},
			add_banner_name: {
			  required: true
			},
			add_banner_img : {
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
            data.append("cmd", "add_banner");
			data.append("add_banner_detail_th", quill_th.root.innerHTML);
			data.append("add_banner_detail_en", quill_en.root.innerHTML);

            $.ajax({
                type: "post",
                url: BASE_LANG + "service/banner_cover.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    if (res.status == true) {
                        $('#modal_add').modal('hide');
                        alert_center('Process add banner', res.msg, "success")
						show_banner();
                    } else {
                        alert_center('Update add banner', res.msg, "error")
                    }
                }
            });
		} 
	});
});

function show_banner(quill_edit_th = null, quill_edit_en = null){
    $.ajax({
        type: "post",
        url: BASE_LANG + "service/banner_cover.php",
        data: {
          "cmd": "show_banner",
        },
        dataType: "json",
        beforeSend: function(){
          // $('#sign_out').prop('disabled', true);
        },
        complete: function(){
          // $('#sign_out').prop('disabled', false);
        },
        success: function(res) {
            var status 	= res['status'];
            var res_data 	= res['data'];
            
            var bannerHTML = '';
            $.each(res_data, function( index, value ) {
            	var checked = '';
            	var ribbon  = '';
            	if (value.SLIDER_STATUS == 'true'){
            		checked = 'checked';
	            	ribbon += 'bg-green';
            	}else{
					ribbon += 'bg-red';
				}

            	bannerHTML += '<div class="col-lg-6 col-12">';
            	bannerHTML += '<div class="card card-sm">';
				bannerHTML += '<div class="ribbon ribbon-top ribbon-bookmark ' + ribbon + '">';
				bannerHTML += '<i class="fas fa-check" style="font-size: large;"></i>';
				bannerHTML += '</div>';
            	bannerHTML += '<a target="_blank" href="' + BASE_URL + 'images/banner/' + value.SLIDER_IMAGE + '" class="d-block"><img src="' + BASE_URL + 'images/banner/' + value.SLIDER_IMAGE + '" class="card-img-top" style="max-height: 20em;object-fit: cover;"></a>';
            	bannerHTML += '<div class="card-body">';
            	bannerHTML += '<div class="d-flex align-items-center">';
				bannerHTML += '<select name="banner_order_new" data-banner-order-old="' + value.SLIDER_ROWS + '" data-id="' + value.SLIDER_ID + '" class="me-1 px-2 text-center">';
				for(var i = 1; i <= parseInt(value.max_order); i++) {
					if(i == value.SLIDER_ROWS) {
						bannerHTML += '<option value="' + i + '" selected>' + i + '</option>';
					} else {
						bannerHTML += '<option value="' + i + '">' + i + '</option>';
					}
				}
				bannerHTML += '</select>';
				bannerHTML += '<button ';
				bannerHTML += 		'data-id="' + value.SLIDER_ID + '" ';
				bannerHTML += 		'data-image="' + value.SLIDER_IMAGE + '" ';
				bannerHTML += 		'data-name="' + value.SLIDER_NAME + '" ';
				bannerHTML += 		'data-alt="' + value.SLIDER_ALT + '" ';
				bannerHTML += 		'data-detail-th="' + encode_quote(value.SLIDER_DETAIL_TH) + '" ';
				bannerHTML += 		'data-detail-en="' + encode_quote(value.SLIDER_DETAIL_EN) + '" ';
				bannerHTML += 		'name="update_banner" class="btn btn-warning me-1"><i class="fa fa-edit"></i>';
				bannerHTML += '</button>';
            	bannerHTML += '<button data-b-name="' + value.SLIDER_NAME + '" data-b-id="' + value.SLIDER_ID + '" name="remove_banner" class="btn btn-danger me-1"><i class="far fa-trash-alt"></i></button>';
				bannerHTML += '<div>';
            	bannerHTML += '<div>' + value.SLIDER_NAME + '</div>';
            	bannerHTML += '</div>';
            	bannerHTML += '<div class="ms-auto">';
            	bannerHTML += '<label class="form-check form-switch form-check-inline m-auto mt-1">';
            	bannerHTML += '<input data-active-id="' + value.SLIDER_ID + '" name="active_banner" class="cursor-pointer form-check-input" type="checkbox" ' + checked + '>';
            	bannerHTML += '</label>';
            	bannerHTML += '</div>';
            	bannerHTML += '</div>';
            	bannerHTML += '</div>';
            	bannerHTML += '</div>';
            	bannerHTML += '</div>';
            });

            $("#show_banner").html(bannerHTML).fadeIn(500);

            $('[name="remove_banner"]').on('click', function(){
            	var banner_id 	= $(this).attr('data-b-id');
            	var banner_name = $(this).attr('data-b-name');

		        // MODAL REMOVE BANNER
		        var remove_modalText  = 'Do you really want to remove banner name <br><b>' + banner_name + '</b> ?';
		        var modalID           = 'modal_removeBannerGEN';
		        var btn_remove_id     = 'submit_remove_banner';
		        modal_remove(btn_remove_id, modalID, remove_modalText, 'modal_removeBanner');

		        $('#' + btn_remove_id).on('click', function(){
		          $.ajax({
		              type: "post",
		              url: BASE_LANG + "service/banner_cover.php",
		              data: {
		                  "cmd": "remove_banner",
		                  "banner_id": banner_id
		              },
		              dataType: "json",
		              beforeSend: function(){
		                $('[name="remove_banner"]').prop('disabled', true);
		              },
		              complete: function(){
		                $('[name="remove_banner"]').prop('disabled', false);
		              },
		              success: function(res) {
		                  var status = res['status'];
		                  var msg = res['msg'];
		                  if (status == true) {
		                      alert_center('Process remove banner', msg, "success")
		                      show_banner();
		                      $('#' + modalID).modal('hide');
		                  }else{
		                      alert_center('Process remove banner', msg, "error")
		                  }
		              }
		          });
		        });
            });

            $('[name="active_banner"]').on('click', function(){
            	var active_banner_id 	= $(this).attr('data-active-id');
            	var active = (this.checked == true) ? '1' : '0';

		          $.ajax({
		              type: "post",
		              url: BASE_LANG + "service/banner_cover.php",
		              data: {
		                  "cmd": "active_banner",
		                  "active_banner_id": active_banner_id,
		                  "active": active
		              },
		              dataType: "json",
		              beforeSend: function(){
		                $('[name="update_banner"]').prop('disabled', true);
		              },
		              complete: function(){
		                $('[name="update_banner"]').prop('disabled', false);
		              },
		              success: function(res) {
		                  var status = res['status'];
		                  var msg = res['msg'];
		                  if (status == true) {
		                      alert_center('Process update banner', msg, "success")
		                      show_banner();
		                  }else{
		                      alert_center('Process update banner', msg, "error")
		                  }
		              }
		          });
            });

			$('[name="banner_order_new"]').on('change', function(){
				var banner_id = $(this).attr('data-id');
            	var banner_order_old = $(this).attr('data-banner-order-old');
				var banner_order_new = $(this).val();
		          $.ajax({
		              type: "post",
		              url: BASE_LANG + "service/banner_cover.php",
		              data: {
		                  "cmd": "update_order",
						  "banner_id": banner_id,
		                  "banner_order_old": banner_order_old,
		                  "banner_order_new": banner_order_new
		              },
		              dataType: "json",
		              beforeSend: function(){
		                $('[name="update_banner"]').prop('disabled', true);
		              },
		              complete: function(){
		                $('[name="update_banner"]').prop('disabled', false);
		              },
		              success: function(res) {
		                  if (res.status == true) {
							alert_center('Process update banner', res.msg, "success")
							show_banner();
							$("#show_banner").html(bannerHTML).fadeIn(500);
		                  } else {
							alert_center('Process update banner', res.msg, "error")
						}
		              }
		          });
            });

			$('[name="update_banner"]').on('click', function(e){
				$('#modal_edit').modal('show');
				var data = $(e.currentTarget).data();
				$('#edit_show_banner_img').attr("src", BASE_URL + 'images/banner/' + data.image);
				$('#edit_banner_name').val(data.name);
				$('#edit_banner_alt').val(data.alt);
				quill_edit_th.root.innerHTML = decode_quote(data.detailTh);
				quill_edit_en.root.innerHTML = decode_quote(data.detailEn);
				$('#edit_banner_id').val(data.id);

				$("#edit_banner_img").on('change', function(){
					var file = this.files[0];
					var reader = new FileReader();
					reader.onloadend = function () {
						$('img#edit_show_banner_img').attr('src', reader.result);
					}
					if (file) {
						reader.readAsDataURL(file);
					} else {
						return false;
					}
				});

				$("#edit_banner").validate({
					ignore: ".quill *",
					rules: {
						edit_banner_alt: {
						  required: true
						},
						edit_banner_name: {
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
						data.append("cmd", "edit_banner");
						data.append("edit_banner_detail_th", quill_edit_th.root.innerHTML);
						data.append("edit_banner_detail_en", quill_edit_en.root.innerHTML);
			
						$.ajax({
							type: "post",
							url: BASE_LANG + "service/banner_cover.php",
							data: data,
							cache: false,
							contentType: false,
							processData: false,
							dataType: "json",
							success: function(res){
								if (res.status == true) {
									$('#modal_edit').modal('hide');
									alert_center('Process update banner', res.msg, "success")
									show_banner(quill_edit_th, quill_edit_en);
								} else {
									alert_center('Update update banner', res.msg, "error")
								}
							}
						});
					} 
				});


            });

        }
    });


}
