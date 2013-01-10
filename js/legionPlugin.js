function displayForm()
{
	var id = document.getElementById('catId').selectedIndex;
	var opt = document.getElementById('catId');
	var catId = opt.value;

	if(catId != 0)
	{
	document.getElementById('catValue').value = catId;
	document.getElementById('myTitle').innerHTML = "<h4>Assign Image to: "+opt.options[id].innerHTML+"</h4>";
	document.getElementById('imageForm').style.display = "block";
	}
	else
	{
		document.getElementById('myTitle').innerHTML = "";
		document.getElementById('catValue').value = "0";
		document.getElementById('imageForm').style.display = "none";
	}
}

function validate()
{
	if($("#myFile").val().length == 0)
	{
		alert("Please choose a file to upload");
		return false;
	}
	else
	{
		return true;
	}
}

function deleteRow(id)
{
	var conf = confirm("Do you want to delete this row ?");
	if(conf)
	{
		$.ajax({
			beforeSend: function()
			{
				$("#resultMsg").html("<h3>Processing...</h3>");
			},
			url: ajaxurl,
			data : { action : "delete_row", myId : id },
			success : function(response)
			{
				$("#resultMsg").html("<h3>Row Deleted Sucessfully!</h3>");
				$("#tableTarget").html(response);
				$(".colorbox").colorbox();
			}
		});
	}
}

function refreshTable()
{
	$.ajax({
		url: ajaxurl,
		async: false,
		data : { action : "refresh_table" },
		success : function(response)
			{
				$("#tableTarget").html(response);
			}
	});
	$(".colorbox").colorbox();
}
