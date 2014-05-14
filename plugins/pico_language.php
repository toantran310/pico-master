<?php

/**
 * Example hooks for a Pico plugin
 *
 * @author Gilbert Pellegrom
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Language {

    private $settings;
    private $current_language;

	public function plugins_loaded()
	{
		
	}

	public function config_loaded(&$settings)
	{
        $this->settings = $settings;
	}
	
	public function request_url(&$url)
	{
        if(strpos($url, "changelanguage") !== false) {
            $_SESSION["language"] = $_GET["language"];
            header("Location: {$this->settings["base_url"]}");
            die;
        }else{
            if(isset($_SESSION["language"])){
                $currentLanguage = $_SESSION["language"];
                if($currentLanguage != $this->settings["default_language"]){
                    if(strpos($url, $currentLanguage."/") === false && $url != $currentLanguage) {
                        header("Location: {$this->settings["base_url"]}"."/". $currentLanguage."/". $url);
                    }
                }
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
        $headers = array_merge($headers, array(
            'language'          => "Language"
        ));
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
        $data = array_merge($data, array(
            'language' => isset($page_meta['language']) && !empty($page_meta['language']) ? $page_meta['language'] : $this->settings['default_language'],
        ));
	}
	
	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	{
        $this->current_language = $this->settings["default_language"];
        if(isset($_SESSION["language"])){
            $this->current_language = $_SESSION["language"];
        }
        foreach ($pages as $key => $page) {
            if($page["language"] != $this->current_language){
                unset($pages[$key]);
            }
        }


    }
	
	public function before_twig_register()
	{
		
	}
	
	public function before_render(&$twig_vars, &$twig, &$template)
	{
        $twig_vars["current_language"] = $this->current_language;
	}
	
	public function after_render(&$output)
	{
		
	}
	
}

?>
