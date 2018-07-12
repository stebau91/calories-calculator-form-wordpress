jQuery(document).ready(function($) {
  var dishes_list = ["lasagna","pasta","cocunut rice","chicken with mushroom","katsu chicken","steamed rice","fried rice","mix vegetable noodles","roasted potatoes","baby carrots with musturd seed","chicken butterfly with herbs","chicken butterfly spicy","potatoes salad","chickpeas salad","spanish omlette","mush potatoes","dauphinoies potatoes", "yakitory chicken","mix stir fried vegetable","spring roll","beef burger","lamb burger","vegatable burger","portion of fries","portion of onion rings","saute cabage", "mix broccoli and peas","mint peas","mushy peas","baked beans","baked potatoes", "baked pumpkin","baked sweet potatoes","chicken soup","mix vegetable soup", "coleslow","sweet potatoes fries","BBQ chicken wings","chicken skewers","slow cook salmon","slice of turkey","slice of roasted ham", "half chicken","chicken legs", "paella","lamb curry ","buttered fish","fish curry"];
  var max_rows = 6;
  var x = 1;

  // Function that will set up the autocomplete to the fisrt and the rest of dynamic form
  function dishAutocomplete(element) {
    if (!$(element).is('.auto')) {
      $(element).addClass('auto').autocomplete({
        source: dishes_list
      });
    }
  }

  // premade HTML form that will be added dynamically in the calculator form
  function premadeForm(n) {
    return '<div class="dynamic-add"><div><label class="plate_label">Dish</label><input type="text" id="dish-' + n + '" name="dish_name[]" class="dish" placeholder="Enter plate name" /></div><div><label class="quantity_label">Quantity:</label><input type="text" name="dish_quantity[]"  class="quantity" placeholder="Enter gram or pieces/slices" /><a href="#" class="remove" title="Remove" style="color: red;">&times;</a></div></div>';
  }

  // code that will add the premade form when the add button is clicked
  $("#add_more").click(function(e) {
    e.preventDefault();

    if (x <= max_rows) {
      $("#container-form").append(premadeForm(x));
      dishAutocomplete('#dish-' + x);
      x++;
    }
  });

  // code that will remove the selected rows from the form
  $("#container-form").on('click', '.remove', function(e) {
    e.preventDefault();

    $(this).parents('.dynamic-add').remove();
    x--;
  });

  // set up the autocomplete for the first dish field of the form
  dishAutocomplete('.dish');
});