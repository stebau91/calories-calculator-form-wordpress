<?php
/*Template Name: Calories calculator*/
?>
<?php

	function emptyElementExists($arr) {
  		return array_search("", $arr) !== false;
  	}
  	
  	function checkOnlyDigits($arr) {
     		foreach($arr as $value) {
          		if (!(is_numeric($value))) {
               			return false;
          		} 
     		}
     		return true;
  	}
  	
  	function checkOnlyLetters($arr) {
  		foreach ($arr as $element) {
    			if (ctype_alpha(str_replace(' ', '', $element)) === false) {
        			return true;
    			}
		}
		return false;
  	}
 
  //response generation function
  	$response = "";

	
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
				$response = "<div class='error'>Please supply all information and don't leave any empty field.\r\n</div>";
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
<?php do_action( 'ocean_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr">

		<?php do_action( 'ocean_before_primary' ); ?>

		<div id="primary" class="content-area clr">

			<?php do_action( 'ocean_before_content' ); ?>

			<div id="content" class="site-content clr" style=" width: 80% !important; position: static !important; margin: 30px !important;	display: block !important; margin-left: auto !important; margin-right: auto !important;">

				<?php do_action( 'ocean_before_content_inner' ); ?>

				<?php
				// Start loop
				while ( have_posts() ) : the_post();

					get_template_part( 'partials/page/layout' );

				endwhile; ?>

				<?php do_action( 'ocean_after_content_inner' ); ?>
 
              	
				<form method = "POST">
				<div id = "container-form">
					<div><label class="plate_label">Dish:</label><input type="text" name="dish_name[]" class="dish" placeholder="Enter plate name" ></div>
    					<div><label class="quantity_label">Quantity:</label><input type="text" name="dish_quantity[]" class="quantity" placeholder="Enter gram or pieces/slices" /></div>
    				</div>
    			
    				<p><br><input id="add_more" type="button" value="Add More"></p>
    				<input type="hidden" name="submitted" value="1">
                		<p><br><input name="submit" type="submit" value="Submit"></p>
                		</form>
    			
			<?php echo $response; ?>
 
            	</div><!-- .entry-content -->
 
          <?php do_action( 'ocean_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'ocean_after_primary' ); ?>

		

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>
 


