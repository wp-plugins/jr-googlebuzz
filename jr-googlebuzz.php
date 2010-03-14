<?php
/*
Plugin Name: JR_GoogleBuzz
Plugin URI: http://www.jakeruston.co.uk/2010/02/wordpress-plugin-jr-googlebuzz/
Description: This plugin allows you to show your latest Google Buzz updates as a widget.
Version: 1.1.2
Author: Jake Ruston
Author URI: http://www.jakeruston.co.uk
*/

/*  Copyright 2009 Jake Ruston - the.escapist22@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Hook for adding admin menus
add_action('admin_menu', 'jr_buzz_add_pages');

// action function for above hook
function jr_buzz_add_pages() {
    add_options_page('JR Buzz', 'JR Buzz', 'administrator', 'jr_buzz', 'jr_buzz_options_page');
}

if (!defined("ch"))
{
function setupch()
{
$ch = curl_init();
$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
return($ch);
}
define("ch", setupch());
}

if (!function_exists("curl_get_contents")) {
function curl_get_contents($url)
{
$c = curl_setopt(ch, CURLOPT_URL, $url);
return(curl_exec(ch));
}
}

register_activation_hook(__FILE__,'buzz_choice');

function buzz_choice () {
if (get_option("jr_buzz_links_choice")=="") {

$content = curl_get_contents("http://www.jakeruston.co.uk/pluginslink4.php");

update_option("jr_buzz_links_choice", $content);
}
}

// jr_buzz_options_page() displays the page content for the Test Options submenu
function jr_buzz_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_buzz_header';
	$opt_name_2 = 'mt_buzz_color';    $opt_name_3 = 'mt_buzz_account';
	$opt_name_4 = 'mt_buzz_number';
	$opt_name_5 = 'mt_buzz_acolor';
    $opt_name_6 = 'mt_buzz_plugin_support';
    $hidden_field_name = 'mt_buzz_submit_hidden';
    $data_field_name = 'mt_buzz_header';
	$data_field_name_2 = 'mt_buzz_color';
    $data_field_name_3 = 'mt_buzz_account';
	$data_field_name_4 = 'mt_buzz_number';
	$data_field_name_5 = 'mt_buzz_acolor';
    $data_field_name_6 = 'mt_buzz_plugin_support';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
	$opt_val_2 = get_option( $opt_name_2 );
    $opt_val_3 = get_option( $opt_name_3 );
	$opt_val_4 = get_option( $opt_name_4 );
	$opt_val_5 = get_option( $opt_name_5 );
    $opt_val_6 = get_option($opt_name_6);
    
if (!$_POST['feedback']=='') {
$my_email1="the.escapist22@gmail.com";
$plugin_name="JR Buzz";
$blog_url_feedback=get_bloginfo('url');
$user_email=$_POST['email'];
$subject=$_POST['subject'];
$name=$_POST['name'];
$response=$_POST['response'];
$category=$_POST['category'];
if ($response=="Yes") {
$response="REQUIRED: ";
}
$feedback_feedback=$_POST['feedback'];
$feedback_feedback=stripslashes($feedback_feedback);
$headers1 = "From: feedback@jakeruston.co.uk";
$emailsubject1=$response.$plugin_name." - ".$category." - ".$subject;
$emailmessage1="Blog: $blog_url_feedback\n\nUser Name: $name\n\nUser E-Mail: $user_email\n\nMessage: $feedback_feedback";
mail($my_email1,$emailsubject1,$emailmessage1,$headers1);
?>
<div class="updated"><p><strong><?php _e('Feedback Sent!', 'mt_trans_domain' ); ?></strong></p></div>
<?php
}

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
		$opt_val_2 = $_POST[ $data_field_name_2 ];
        $opt_val_3 = $_POST[ $data_field_name_3 ];
		$opt_val_4 = $_POST[ $data_field_name_4 ];
		$opt_val_5 = $_POST[ $data_field_name_5 ];
        $opt_val_6 = $_POST[$data_field_name_6];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
		update_option( $opt_name_2, $opt_val_2 );
        update_option( $opt_name_3, $opt_val_3 );
		update_option( $opt_name_4, $opt_val_4 );
		update_option( $opt_name_5, $opt_val_5 );
        update_option( $opt_name_6, $opt_val_6 );  

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'JR Buzz Plugin Options', 'mt_trans_domain' ) . "</h2>";
	?>
	<div class="updated"><p><strong><?php _e('Please consider donating to help support the development of my plugins!', 'mt_trans_domain' ); ?></strong><br /><br /><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ULRRFEPGZ6PSJ">
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form></p></div>
<?php

    // options form
    
    $change4 = get_option("mt_buzz_plugin_support");

if ($change4=="Yes" || $change4=="") {
$change4="checked";
$change41="";
} else {
$change4="";
$change41="checked";
}
    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Buzz Widget Title", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="50">
</p><hr />

<p><?php _e("Google Buzz Username", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_3; ?>" value="<?php echo $opt_val_3; ?>" size="30">
</p><hr />

<p><?php _e("Number of Buzz items", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_4; ?>" value="<?php echo $opt_val_4; ?>" size="3">
</p><hr />

<p><?php _e("Text Hex Colour Code:", 'mt_trans_domain' ); ?> 
#<input size="7" name="<?php echo $data_field_name_2; ?>" value="<?php echo $opt_val_2; ?>">
(For help, go to <a href="http://html-color-codes.com/">HTML Color Codes</a>).
</p><hr />

<p><?php _e("Anchor Text Hex Colour Code:", 'mt_trans_domain' ); ?> 
#<input size="7" name="<?php echo $data_field_name_5; ?>" value="<?php echo $opt_val_5; ?>">
(For help, go to <a href="http://html-color-codes.com/">HTML Color Codes</a>).
</p><hr />

<p><?php _e("Show Plugin Support?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="Yes" <?php echo $change4; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="No" <?php echo $change41; ?> id="Please do not disable plugin support - This is the only thing I get from creating this free plugin!" onClick="alert(id)">No
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>
<script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt);return false;
    }
  else
    {
    return true;
    }
  }
}

function validate_form(thisform)
{
with (thisform)
  {
  if (validate_required(subject,"Subject must be filled out!")==false)
  {email.focus();return false;}
  if (validate_required(feedback,"Feedback must be filled out!")==false)
  {email.focus();return false;}
  }
}
</script><h3>Submit Feedback about my Plugin!</h3>
<p><b>Note: Only send feedback in english, I cannot understand other languages!</b></p>
<form name="form2" method="post" action="" onsubmit="return validate_form(this)">
<p><?php _e("Name:", 'mt_trans_domain' ); ?> 
<input type="text" name="name" /></p>
<p><?php _e("E-Mail:", 'mt_trans_domain' ); ?> 
<input type="text" name="email" /></p>
<p><?php _e("Category:", 'mt_trans_domain'); ?>
<select name="category">
<option value="Bug Report">Bug Report</option>
<option value="Feature Request">Feature Request</option>
<option value="Other">Other</option>
</select>
<p><?php _e("Subject (Required):", 'mt_trans_domain' ); ?>
<input type="text" name="subject" /></p>
<input type="checkbox" name="response" value="Yes" /> I want e-mailing back about this feedback</p>
<p><?php _e("Comment (Required):", 'mt_trans_domain' ); ?> 
<textarea name="feedback"></textarea>
</p>
<p class="submit">
<input type="submit" name="Send" value="<?php _e('Send', 'mt_trans_domain' ); ?>" />
</p><hr /></form>
</div>
<?php
}

if (get_option("jr_buzz_links_choice")=="") {
buzz_choice();
}

function show_buzz($args) {

extract($args);

  $buzz_header = get_option("mt_buzz_header"); 
  $plugin_support2 = get_option("mt_buzz_plugin_support");
  $buzz_type = get_option("mt_buzz_account");
  $buzz_number = get_option("mt_buzz_number");
  $buzzcolor = get_option("mt_buzz_color");
  $buzzacolor = get_option("mt_buzz_acolor");


if ($buzz_header=="") {
$buzz_header="Latest Buzz";
}

if ($buzz_number=="") {
$buzz_number=5;
}

if ($buzz_type=="") {
$buzz_type="the.escapist22";
}

$i=1;
$doc2='http://buzz.googleapis.com/feeds/'.$buzz_type.'/public/posted';
echo $before_title.$buzz_header." - ";
echo "<a style='color: #".$buzzacolor."' href='".$doc2."'><img src='http://www.jakeruston.co.uk/icons3/feed.png' alt='RSS' title='RSS' /></a>";
echo $after_title.$before_widget; 

echo "<ul>";
$doc=curl_get_contents($doc2) or die("Error!");
$xml=new SimpleXMLElement($doc);
$ding="<a style='color: #".$buzzacolor."' href=";
$find="<a href=";
foreach ($xml->entry as $node) {
$buzz = $node->content;

if ($buzz != "") {
$buzz=str_replace($find, $ding, $buzz);
echo "<li style='color:#".$buzzcolor."'>".$buzz."</li>";
}
if($i++ >= $buzz_number) break;

}
echo "</ul>";

if ($plugin_support2=="Yes" || $plugin_support2=="") {
echo "<p style='color: #".$buzzcolor."; font-size:x-small'>Google Buzz Plugin created by <a href='http://www.jakeruston.co.uk'>Jake</a> Ruston - ".get_option('jr_buzz_links_choice')."</p>";
}

echo $after_widget;

}

function init_buzz_widget() {
register_sidebar_widget("JR Buzz", "show_buzz");
}

add_action("plugins_loaded", "init_buzz_widget");

?>
