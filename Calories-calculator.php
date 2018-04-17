<?php
/*Template Name: Calories calculator*/
?>
<?php

	function emptyElementExists($arr) {
  		return array_search("", $arr) !== false;
  	}
  	
  	function checkOnlyDigits($arr) {
  		foreach ($arr as $element) {
    			if (is_numeric($element)) {
        			return true;
    			} else {
        			return false;
    			}
		}
  	}
  	
  	function checkOnlyLetters($arr) {
  		foreach ($arr as $element) {
    			if (preg_match('#[0-9]#', $element)) {
        			return true;
    			} else {
        			return false;
    			}
		}
  	}
 
  //response generation function
  	$response = "";

    	//if($type == "success") $response = "<div class='success'>{$message}</div>";
    	//else $response = "<div class='error'>{$message}</div>";

 	//response messages
	$missing_content = "Please supply at least one dish with quantity.";
	$no_match = "Recipe not in the database.";
	$match = "The total kilocal are";
	
	if (isset($_POST['submit'])){
	
		$serverName = "localhost";
		$userName = "stechef9_stefma";
		$password = "ste25091991";
		$dbname = "stechef9_global";
		
		// Create connection
		$conn = new mysqli($serverName , $userName , $password, $dbname);
		
		//user posted variables
		$dish= $_POST['dish_name'];
		$quantity= $_POST['dish_quantity'];
		$calcu = [];
		if (((emptyElementExists($dish)) == true) || ((emptyElementExists($quantity)) == true)){
				$response = "<div class='error'>Please suply all information ad don't leave any empty field.\r\n</div>";
		}else{
			if (((checkOnlyDigits($quantity)) == false) || ((checkOnlyLetters($dish)) == true)){
				$response = "<div class='error'>Please input only letters for the dish and only numbers for the quantity.\r\n</div>";
			}else{
				foreach ($quantity as $key => $value){
				$query = "SELECT kilocal FROM global WHERE name = '$dish[$key]'";
				$row = $conn->query($query);
				$result = $row->fetch_assoc();
					if (empty($result)){
						$response = "<div class='error'>Recipe not in the database.\r\n</div>";
						break;
					}else{
						$calcu[] = $result['kilocal'] * $value;
						$response = "<div class='success'>The total kilocal are " . array_sum($calcu) . "\r\n</div>";
					}
				}
			}
		}
		$conn->close();
	}
  	
?>

<?php get_header(); ?>
<div class="wrap">
	<div id="primary" class="content-area sidebar-left">
		<main id="main" class="site-main" role="main">
 
        	<?php while ( have_posts() ) : the_post(); ?>
 
          	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
            	<header class="entry-header">
              		<h1 class="entry-title"><?php the_title(); ?></h1>
            	</header>
 
            	<div class="entry-content">
              	<?php the_content(); ?>
 
              	
		<form method = "POST">
		<div id = "container-form">
			<div><label class="plate_label">Dish:</label><input type="text" name="dish_name[]" id="dish" class="dish" placeholder="Enter plate name" autocomplete="off"/>
    			<label class="quantity_label">Quantity:</label><input type="text" name="dish_quantity[]"  class="quantity" placeholder="Enter gram or pieces/slices" /></div>
    		</div>
    		<p />
    		<p><br><input id="add_more" type="button" value="Add More"></p>
    		<input type="hidden" name="submitted" value="1">
                <p><br><input name="submit" type="submit" value="Submit"></p>
                </form>
    			
		<?php echo $response; ?>
 
            </div><!-- .entry-content -->
 
          </article><!-- #post -->
 
      <?php endwhile; // end of the loop. ?>
 
    </div><!-- #content -->
  </div><!-- #primary -->
 


