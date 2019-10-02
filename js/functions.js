function simpleAjax(pageUrl,divId,FormId,spinnerId,isFormEnabled){
//alert(pageUrl);
	var dataVar ='';
	var d = new Date();
	if(isFormEnabled){
		dataVar =  $('#'+FormId).serialize();
	}else{
		
	}
	$.ajax({
			type: "POST",
			url: pageUrl+'&d='+d.getTime(),
			cache:false,
			data:dataVar,
			success: function(msg){	
					//alert(spinnerId);
					//alert(msg);
					$('#'+divId).html(msg);
					$('#'+spinnerId).hide();
				},
			beforeSend: function(){
					//alert(spinnerId);
					$('#'+spinnerId).attr("style", {display: "inline"});
			},
			error: function(m){
				alert(m);
				},
			complete: function(){
			
					
			}
		});
}