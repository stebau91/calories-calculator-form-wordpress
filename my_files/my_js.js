jQuery(document).ready(function(e){
	var html = '<p ><div><label class="plate_label">Dish</label><input type="text" name="dish_name[]" class="dish" placeholder="Enter plate name" /><label class="quantity_label">Quantity:</label><input type="text" name="dish_quantity[]"  class="quantity" placeholder="Enter gram or pieces/slices" /><a href = "#" id = "remove" ><font color="red"> X</font></a></p> </div>';
	var max_rows = 6;
	var x = 1;
	jQuery("#add_more").click(function(e){
		if (x <= max_rows){
			jQuery("#container-form").append(html);
			x++;
		}
	});
	jQuery("#container-form").on('click','#remove',function(e){
		jQuery(this).parent('div').remove();
		x--;
	});
});