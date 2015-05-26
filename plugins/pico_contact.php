<?php

/**
 * Example hooks for a Pico plugin
 *
 * @author Gilbert Pellegrom
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 */
//include("mail/class.phpmailer.php");
class Pico_Contact {
    private  $run_this_plugin = false;

	public function plugins_loaded()
	{
		
	}

	public function config_loaded(&$settings)
	{
	}
	
	public function request_url(&$url)
	{
        if (strlen($url) > 0) {
            // the url im looking for
            if(strpos($url,"contact") !== false && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->run_this_plugin = true;
            }
        }
	}
	
	public function before_load_content(&$file)
	{
	}
	
	public function after_load_content(&$file, &$content)
	{
	}
	
	public function before_404_load_content(&$file)
	{
		
	}
	
	public function after_404_load_content(&$file, &$content)
	{
		
	}
	
	public function before_read_file_meta(&$headers)
	{
	}
	
	public function file_meta(&$meta)
	{
	}

	public function before_parse_content(&$content)
	{
	}
	
	public function after_parse_content(&$content)
	{
	}
	
	public function get_page_data(&$data, $page_meta)
	{
	}
	
	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	{
	}
	
	public function before_twig_register()
	{
		
	}
	
	public function before_render(&$twig_vars, &$twig, &$template)
	{
        if($this->run_this_plugin){
            header($_SERVER['SERVER_PROTOCOL'].' 200 OK');

            $mail = new PHPMailer();

            $mail -> IsSMTP();

            $mail -> IsHTML(true);

            $mail -> Host     = "smtp.gmail.com";

            $mail -> Port     = 465;

            $mail -> SMTPAuth = true;

            $mail -> Username = "whitesand.3101@gmail.com";

            $mail -> Password = "librA0310";

            $mail -> CharSet = "UTF-8";

            $mail -> Body     = "<h3>Name: {$_POST["name"]} </h3>";
            $mail -> Body     .= "<p>Email: {$_POST["mail"] } </p>";
            $mail -> Body     .= "<p>Website: {$_POST["website"] } </p>";
            $mail -> Body     .= "<p>Comment: {$_POST["comment"] } </p>";

            $mail -> Subject  = "From My Porfolitio: ". $_POST["name"];


            $mail -> From = $_POST["mail"];

            $mail -> FromName = $_POST["name"];

            $mail -> AddReplyTo($_POST["mail"]);

            $mail -> AddAddress("whitesand310@gmail.com");

            $result = array();

            if ($mail -> Send())

            {

                $result["info"] = "ok";
                $result["msg"] = "Thanks for send contact to me. I will reply soon :)";

            }

            else

            {
                $result["info"] = "error";
                $result["msg"] = $mail -> ErrorInfo;
//                echo "Co loi!<br><br>";
//
//                echo "Hiba: " . $mail -> ErrorInfo;

            }
            echo json_encode($result);
            die;
        }
	}
	
	public function after_render(&$output)
	{
		
	}
	
}

?>
