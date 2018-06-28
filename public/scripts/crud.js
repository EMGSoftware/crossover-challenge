$("body").on("submit", ".form", function(evt)
{
	var all_the_items = true;
	$('[id^="items"]').each (function (a, b) { all_the_items &= collect_items (b.id); });
	if (!all_the_items && ($("form").attr ("required_items").length > 0))
	{
		alert ("Por favor, cadastre " + $("form").attr ("required_items"));
		return false;
	}
});

var row_template = 
    "<tr ref=\"[.id.]\">" +
    "\t<td id=\"[.id.]\">[.test.]</td>" + 
    "\t<td>[.result.]</td>" +
    "\t<td class=\"col-md-1\"><a class=\"btn btn-sm btn-danger btn_remove_row\"><i class=\"glyphicon glyphicon-trash\"></i> Remove</a></td>" + 
    "</tr>";

function add_item (combo, list, result = "")
{
	if (!$(combo).val()) return;
	var new_row =
		row_template
			.replace(/\[\.id\.\]/g, $(combo).val())
			.replace(/\[\.test\.\]/g, $('#' + $(combo)[0].id + ' option:selected').text())
			.replace("[.result.]", result)
			;
	$('#' + $(list)[0].id).append(new_row);
	$(".btn_remove_row").on('click', function () { remove_item (combo, $(this)); });
}

function add_manual_item (combo, list, item_id, item_description, result = "")
{
	var new_row =
		row_template
			.replace(/\[\.id\.\]/g, item_id)
			.replace(/\[\.test\.\]/g, item_description)
			.replace(/\[\.result\.\]/g, result)
			;
	$('#' + $(list)[0].id).append(new_row);
	$(".btn_remove_row").on('click', function () { remove_item (combo, $(this)); });
}

function remove_item (combo, item)
{
	var ref = $(item).parent().parent().attr("ref");
	$(item).parent().parent().remove();
}

function collect_items ($container)
{
	var items = "";
	var num_rows = document.getElementById($container).rows.length;
	for (var i=0; i < num_rows; i++)
	{
		var item = document.getElementById($container).rows [i].cells [0].id;
		
		if (item != "")
		{
			items += item;
			if (document.getElementById($container).rows [i].cells [1].style.display != "none")
			{
				items += "@" + document.getElementById($container).rows [i].cells [1].innerText;
			}
			items += "|";
		}
	}
	$("#hdn_" + $container).val (items);
	return (items != "");
}
