
	function readURLplay(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('.imagePreview').attr('style', 'width:100px;height:100px;');
				$('#previewphoto').attr('src', e.target.result);
				$('#previewphoto').attr('width', '100px');
				$('#previewphoto').attr('height', '100px');
			}
			 reader.readAsDataURL(input.files[0]);
		}
	}
	
	function readURLChallenge(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('.imagePreviewPopup').attr('style', 'width:100px;height:100px;margin:0 auto;');
				$('#previewphotoPopup').attr('src', e.target.result);
				$('#previewphotoPopup').attr('width', '100px');
				$('#previewphotoPopup').attr('height', '100px');
			}
			 reader.readAsDataURL(input.files[0]);
		}
	}
	
	$("#imgPost").change(function(){
		readURLplay(this);
	});
	
	$("#vidPost").change(function(){
		$('.imagePreview').attr('style', 'width:100px;height:100px;');
		$('#previewphoto').attr('src', basedomain+'assets/images/Video-Clip-icon.png');
		$('#previewphoto').attr('width', '100px');
		$('#previewphoto').attr('height', '100px');
	});
	
	
	$(document).on('click', '.commentstatus', function(){
		
		var id = $(this).attr('prop');
		// console.log(id);
		$('.commentbox_'+id).css('display','block');
	})
	
	$(document).on('click', '.replycomment', function(){
		// alert('ada');
		var id = $(this).attr('prop');
		$('.replycommentbox_'+id).css('display','block');
	})
	
	$(document).on('click', '.postComment', function(){
			
		var postid = $(this).attr('prop');
		var contentid = $('.hiddencontentid').val();
		var content = $('.mystatuscomment_'+postid).val();
		
		$.post(basedomain+'movefwd/commentAjax', {comment:true, postid:postid, content:content,contentid:contentid}, function(data){
			var htmlThanks = "";
			if (data.status==true){
				/*
				$.each(data.rec, function(i,e){
					
					
					html += "<div class='row comment-child '>";
					html += "<div class='thumb-user'>";
					html += "                <a href='#'><img src='"+basedomain+"public_assets/user/photo/"+e.image_profile+"' width='50px' /></a>";
					html += "            </div>";
					html += "            <div class='entry-right'>";
					html += "                <div class='entry-header'>";
					html += "                    <h3 class='username'><a href='#'>"+e.name+"</a></h3>";
					html += "                </div>";
					html += "                <div class='entry-body'>";
					html += "                    <p>"+e.content+"</p>";
					html += "                    <span class='comment-date'>Posted on "+e.newDate+" - "+e.newTime+"</span>";
					html += "<a class='child-reply replycomment' href='javascript:void(0)' prop='"+e.id+"'> Reply</a>";
					html += "                </div>";
					html += "            </div>";
					
					// subcomment
					html += "<div class='framereplycommentbox_"+e.id+"'>";
					if (e.reply){
					
					$.each(e.reply, function(a,value){
					
					if (value.content!=""){
						
						html += "						<div class='row comment-child '>";
						html += "							<div class='thumb-user'>";
						html += "								<a href='#'><img src='"+basedomain+"public_assets/user/photo/"+value.image_profile+"' width='50px' /></a>";
						html += "							</div>";
						html += "							<div class='entry-right'>";
						html += "								<div class='entry-header'>";
						html += "									<h3 class='username'><a href='#'>"+value.name+"</a></h3>";
						html += "								</div>";
						html += "								<div class='entry-body'>";
						html += "									<p>"+value.content+"</p>";
						html += "									<span class='comment-date'>Posted on "+value.newDate+" - "+value.newTime+"</span>";
						html += "								</div>";
						html += "							</div>";
						html += "						</div>";
					}
					
					})
								
					}
					
					html += "				</div>";
					// end sub comment
					
					// hidden comment
					html += "<div class='row reply-comment replycommentbox_"+e.id+"' style='display:none'>";
					html += "								<div class='thumb-user-small'>";
					html += "									<a href='#'><img src='"+basedomain+"public_assets/user/photo/"+e.image_profile+"' width='50px' /></a>";
					html += "								</div>";
					html += "								<div class='entry-right'>";
					html += "									<form class='replycomment'>";
					html += "										<textarea class='mystatuscomment_"+e.id+"' placeholder='Type your comment here'></textarea>";
					html += "										<input type='button' value='&nbsp;' class='post replyCommentbutton postComment' prop='"+e.id+"'/>";
					html += "										<input type='hidden' value='"+e.content_id+"' class='hiddencontentcommentid'/>";
					html += "									</form>";
					html += "								</div>";
					html += "							</div>";
					html += "							</div>";
					html += "							</div>";
					html += "							</div>";
					// end hidden comment
					
					html += "</div>";
					
				})
				
				
				$('.commentFrame_'+data.cid).html(html);
				$('.mystatuscomment_'+data.cid).val('');
				*/
				
				htmlThanks = locale.postcomment;
				
			}else{
				if(data.msg){
					htmlThanks = data.msg;
				}else{
					htmlThanks = locale.failed;
				}
				
			}
			
			
			$(".wakeboarding-thanks").trigger("click");
			$(".content").html(htmlThanks);
			
			$(document).on('click', '#fancybox-close, #fancybox-overlay', function(){
				location.reload();
			})
		}, "JSON")
		
	})
	
	
	$(document).on('click', '.replyCommentbutton', function(){
			
		var postid = $(this).attr('prop');
		var contentid = $('.hiddencontentcommentid').val();
		var content = $('.mystatuscommentreply_'+postid).val();
		
		$.post(basedomain+'movefwd/commentAjax', {comment:true, postid:postid, content:content,contentid:contentid}, function(datareply){
			// $('.replycommentbox_'+datareply.cid).css('display','none');
			var htmlreply = "";
			if (datareply.status==true){
				
				/*
				$.each(datareply.rec, function(i,e){
					
					htmlreply += "<div class='row comment-child '>";
					htmlreply += "<div class='thumb-user'>";
					htmlreply += "                <a href='#'><img src='"+basedomain+"public_assets/user/photo/"+e.image_profile+"' width='50px' /></a>";
					htmlreply += "            </div>";
					htmlreply += "            <div class='entry-right'>";
					htmlreply += "                <div class='entry-header'>";
					htmlreply += "                    <h3 class='username'><a href='#'>"+e.name+"</a></h3>";
					htmlreply += "                </div>";
					htmlreply += "                <div class='entry-body'>";
					htmlreply += "                    <p>"+e.content+"</p>";
					htmlreply += "                    <span class='comment-date'>Posted on "+e.newDate+" - "+e.newTime+"</span>";
					htmlreply += "                </div>";
					htmlreply += "            </div>";
					// htmlreply += "<div class='row reply-comment replycommentbox_"+e.id+"' style='display:none'>";
					// htmlreply += "								<div class='thumb-user-small'>";
					// htmlreply += "									<a href='#'><img src='"+basedomain+"public_assets/user/photo/"+e.image_profile+"' width='50px' /></a>";
					// htmlreply += "								</div>";
					// htmlreply += "								<div class='entry-right'>";
					// htmlreply += "									<form class='replycomment'>";
					// htmlreply += "										<textarea class='mystatuscommentreply_"+e.id+"' placeholder='Type your comment here'></textarea>";
					// htmlreply += "										<input type='button' value='&nbsp;' class='post replyCommentbutton' prop='"+e.id+"'/>";
					// htmlreply += "										<input type='hidden' value='"+e.content_id+"' class='hiddencontentcommentid'/>";
					// htmlreply += "									</form>";
					// htmlreply += "								</div>";
					// htmlreply += "							</div>";
					// htmlreply += "							</div>";
					// htmlreply += "							</div>";
					// htmlreply += "							</div>";
					htmlreply += "</div>";
					
					// $('replycommentbox_'+e.id).css('display','none');
				})
				
				
				$('.framereplycommentbox_'+postid).html(htmlreply);
				
				// $('.mystatuscommentreply_'+data.cid).val('');
				*/
				
				htmlThanks = locale.postcomment;
				
			}else{
				if (data.msg){
					htmlThanks = data.msg;
				}else{
					htmlThanks = locale.failed;
				}
				
			}
			
			$(".wakeboarding-thanks").trigger("click");
			$(".content").html(htmlThanks);
			
			$(document).on('click', '#fancybox-close, #fancybox-overlay', function(){
				location.reload();
			})
			
		}, "JSON")
		
	})
	var postStatus = {
				dataType : "JSON",
				beforeSubmit: function(data) { 
								
								$(".wakeboarding-thanks").trigger("click");		
								$(".content").html(locale.pleasewait);
					},
				success : function(data) {	
								// var email_token =$('.tokensubmition').val();
								// var html = "success to activate tracking code";
								if(data.status==true){
									
									
									setTimeout(function(){
									
										$(".wakeboarding-thanks").trigger("click");
										$(".content").html(locale.postchallenge);
									},1000);
									
									
									// location.reload();
								}
								
								$(document).on('click', '#fancybox-close, #fancybox-overlay', function(){
					
									location.reload();
									
								})
				}
			};					
				
	$("#createstatus").ajaxForm(postStatus);
	
	
	$(document).on('click', '.challengePopup', function(){
		
		var postid = $(this).attr('prop');
		
		$.post(basedomain+'movefwd/ajaxChallenge', {challenge:true, postid:postid}, function(data){
			
			var html ="";
			if (data.status==true){
				
				html +="<div class='row title-wakeboarding'>";
            	html +="<h1>"+data.rec.title+"</h1>";
                html +="<h5>"+data.c_left+" Slot Left</h5>";
                // html +="<p>How do you wan to pay for this? Choose below.</p>";
                html +="<p>Accomplish all 3 tasks for a chance to win this offer</p>";
				html +="</div>";
				html +="<div class='row button-choose'>";
            	html +="<a class='landbtn landbtn2 challengeChoose' href='javascript:void(0)' prop='"+data.rec.id+"' taskid='"+data.rec.taskid+"'>Play</a><span class='red'>or</span>";
                html +="<a class='landbtn landbtn2 doWithPoint' href='javascript:void(0)' prop='"+data.rec.id+"'>Pledge</a>";
				html +="</div>";
				html +="<div class='row ruleWakeboard'>";
            	html +="<ul class='columns-2'>";
                html +="	<li class='col2'>";
                html +="    <p>Accomplish the task below to unlock the next task:</p>";
                html +="    <ol>";
				$.each(data.rec.task, function(i,e){
					html +=" <li>"+e.question+"</li>";
				})
               
                html +="    </ol>";

				html +="    <p>Read full mechanics <a class='openpopupfullmekanincredeem' href='javascript:void(0)'>here</a></p>";

                html +="    </li>";
                    
                html +="    <li class='col2'>";
                html +="    <p>Pledge "+data.rec.point+" points right now</p>";
                html +="    </li>";
                html +="</ul>";
				html +="</div>";
				
				
			}else{
			
				if (data.msg){
					html += data.msg;
				}else{
					html += locale.failed;
				}
			}
			
			$('.wakeboarding').trigger('click');
			$('.detailChallenge').html(html);
		},"JSON")
		
	})	
	
	
	$(document).on('click', '.doWithPoint', function(){
		
		var postid = $(this).attr('prop');
		
		$.post(basedomain+'movefwd/setByPoint', {point:true, postid:postid}, function(data){
			
			var htmlThanks = "";
			if (data.status==true){
				htmlThanks += "Success";
			}else{
				htmlThanks += locale.failed;
			}
			$(".wakeboarding-thanks").trigger("click");										
			$('.content').html(htmlThanks);
			
			$(document).on('click', '#fancybox-close, #fancybox-overlay', function(){
					
				location.reload();
				
			})
			
		},"JSON");
		
	})
	
	
	
	$(document).on('click', '.challengeChoose', function(){
		
		var postid = $(this).attr('prop');
		
		$.post(basedomain+'movefwd/ajaxChallenge', {choose:true, postid:postid}, function(data){
			
			var html ="";
			if (data.status==true){
				
				html +="<div class='row title-wakeboarding'>";
            	html +="<h1>"+data.rec.title+"</h1>";
                html +="<h5>10 Slot Left</h5>";
                html +="<p>Accomplish all 3 tasks for a chance to win this offer</p>";
				html +="</div>";
				html +="<div class='row'>";
				
				// html +="<div id='wake1' class='paper-button task-done'></div>";
				// html +="<div id='wake1' class='paper-button'><p>quetion2</p></div>";
				// html +="<div id='wake1' class='paper-button task-lock'></div>";
            	
				$.each(data.rec.task, function(i,e){
					if (e.donetask){
						html +="<div id='wake1' class='paper-button task-done'></div>";
					}else{
						if (e.opentask){
							html +="<div id='wake1' class='paper-button'><p>"+e.question+"</p></div>";
						}else{
							html +="<div id='wake1' class='paper-button task-lock'></div>";
						}
					}
					
					
					
				})
				
				
				
				html +="</div>";
				html +="<div class='row'>";
           		html +="<a class='landbtn landbtn2 challengeUpload' href='javascript:void(0)' prop='"+data.rec.id+"' taskid='"+data.rec.taskid+"'>Continue</a>";
                html +="<a class='landbtn landbtn2 close' href='javascript:void(0)'>Do it Later</a>";
				html +="</div>";
				
				$('.wakeboarding').trigger('click');
				$('.detailChallenge').html(html);
				
				$(document).on('click', '.close', function(){
					
					location.reload();
					
				})
			}
		},"JSON")
		
	})	
	
	
	$(document).on('click', '#fileupload', function(){
		$('#upload-file1').trigger('click');
	})
	
	
	$(document).on('click', '.challengeUpload', function(){
		
		var postid = $(this).attr('prop');
		
		$.post(basedomain+'movefwd/ajaxChallenge', {preupload:true, postid:postid}, function(data){
			
			var html ="";
			if (data.status==true){
				
				html +="<div class='row title-wakeboarding'>";
            	html +="<h1>"+data.rec.title+" </h1>";
                html +="<h1>Upload a photo/video of you doing water sports</h1>";
				html +="</div>";
				html +="<form method='post' action='"+basedomain+"movefwd/uploadDataChallenge' enctype='multipart/form-data' id='uploadchallenge'>";
				html +="<div class='row'>";
				
            	html +="<input id='upload-file1' type='file' name='dataChallenge'/>";
            	html +="<input type='hidden' name='token' value='1'/>";
            	html +="<input type='hidden' name='bucketid' value='"+data.rec.id+"'/>";
            	html +="<input type='hidden' name='taskid' value='"+data.rec.taskid+"'/>";
            	html +="<a id='fileupload'></a>";
				
				html +="</div>";
				html +="<div style='display:none' class='imagePreviewPopup'>";
				html +="<img src='' id='previewphotoPopup'/>";
				html +="</div>";
				html +="<div class='row'>";
            	html +="<input type='submit' name='submit' value='Upload'/>";
				// html +="<a class='landbtn landbtn2 uploadData' href='javascript:void(0)' prop='"+data.rec.id+"'>Upload</a>";
				html +="</div>";
				html +="</form>";
				html +="<div class='termConditionUpload'>";
				html +="<p>Please be reminded that as per the Terms and Conditions, all photos, images or designs submitted will become the property of PM. No photos of minors, lit cigarettes or any other photos depicting the act of smoking are not allowed. The photo you upload will be subject to moderation.</p>";
				html +="</div>";
				
									
				
				
				
				
				$('.detailChallenge').html(html);
				
				var updateoptions = {
						dataType:  'json', 	
						beforeSubmit: function(data) { 
							// $(".detailChallenge").html('');
								// $(".wakeboarding-thanks").trigger("click");
								// $(".content").html(locale.pleasewait);		
							
						},
						success : function(data) {		
								var notif = locale.faileduploadphoto;
								
								if(data){
									if(data.status==true){
										var htmlThanks = "";
										htmlThanks +="<div class='row title-wakeboarding'>";
										htmlThanks +="<h1>Thank you for your entry.</h1>";
										htmlThanks +="<p>Please give us time to process and verify your submission.<br />We'll send you an e-mail within 24 hours.</p>";
										htmlThanks +="</div>";
										htmlThanks +="<div class='row'>";
										htmlThanks +="<a class='landbtn landbtn2 close' href='javascript:void(0)' prop='"+data.cid+"'>Continue</a>";
										htmlThanks +="</div>";
										
										
										$(".wakeboarding-thanks").trigger("click");										
										$('.content').html(htmlThanks);
										
										$(document).on('click', '.close', function(){
					
											location.reload();
											
										})
									}									
								}
									
						}
					};	
					
				$("#uploadchallenge").ajaxForm(updateoptions);
				
				$('.wakeboarding').trigger('click');
			}else{
				
				var failed = "already submit";
				$('.content').html(failed);
				$(".wakeboarding-thanks").trigger("click");
			}
		},"JSON")
		
	})

	
	$(document).on('change', '#upload-file1', function(){
	// $("#upload-file-task").change(function(){
		readURLChallenge(this);
		
	});
	/*
	$(document).on('click', '.uploadThanks', function(){
		
		// var postid = $(this).attr('prop');
		
	
			html +="<div class='row title-wakeboarding'>";
			html +="<h1>Thank you for your entry.</h1>";
			html +="<p>Please give us time to process and verify your submission.<br />We'll send you an e-mail within 24 hours.</p>";
			html +="</div>";
			html +="<div class='row'>";
			html +="<a class='landbtn landbtn2 fancybox-close' href='javascript:void(0)'>Continue</a>";
			html +="</div>";
				
			$('.wakeboarding').trigger('click');
			$('.detailChallenge').html(html);
				
	
		
	})*/
	
	