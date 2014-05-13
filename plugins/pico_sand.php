<?php

/**
 * Example hooks for a Pico plugin
 *
 * @author Gilbert Pellegrom
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Sand {
    private $run_this_plugin = false;
    private $skills;

	public function plugins_loaded()
	{
		
	}

	public function config_loaded(&$settings)
	{
	}
	
	public function request_url(&$url)
	{
	}
	
	public function before_load_content(&$file)
	{
        if(strpos($file, "content/index.md") !== false || strpos($file, "content/portfolio/index.md") !== false){
            $this->run_this_plugin = true;
        }
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
            'type'          => 'Type',
            'skill'         => 'Skill',
            'durl'         => 'Durl',
            'ddate'         => 'Ddate',
            'image'         => 'Image',
            "thumbnail"     => "Thumbnail"
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
            'type' => isset($page_meta['type']) && !empty($page_meta['type']) ? $page_meta['type'] : '',
            'thumbnail' => isset($page_meta['thumbnail']) && !empty($page_meta['thumbnail']) ? $page_meta['thumbnail'] : '',
            'skill' => isset($page_meta['skill'])  && !empty($page_meta['skill']) ? explode(",", $page_meta['skill']) : '',
            'image' => isset($page_meta['image'])  && !empty($page_meta['image']) ? explode(",", $page_meta['image']) : '',
            'durl' => isset($page_meta['durl'])  && !empty($page_meta['durl']) ? $page_meta['durl'] : '',
            'ddate' => isset($page_meta['ddate'])  && !empty($page_meta['ddate']) ? $page_meta['ddate'] : '',
        ));
	}
	
	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	{
        if($this->run_this_plugin){
            $this->skills = array();
            foreach ($pages as $page) {
                if(isset($page["skill"]) && is_array($page["skill"])){
                    foreach ($page["skill"] as $skill) {
                        if(!in_array($skill, $this->skills)){
                            array_push($this->skills, $skill);
                        }
                    }
                }
            }
        }
	}
	
	public function before_twig_register()
	{
	}
	
	public function before_render(&$twig_vars, &$twig, &$template)
	{
        if($this->run_this_plugin){
            if(count($this->skills) > 0){
                $twig_vars["skills"] = $this->skills;
            }
        }
	}
	
	public function after_render(&$output)
	{
		
	}
	
}

?>
