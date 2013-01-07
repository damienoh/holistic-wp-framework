<?php 
//version = 1.0;

abstract class HolisticWPFramework{
	
	public $option;
	
	public $settings_default;
	
	public $settings;
	
	public $pagehook;
	
	public $message = '';
	
	public $prefix = '';

	public $menu_param;
	
    public $submenu_param;

	public $metaboxes; 

/* 	public $metaboxes = array(
 *                          array('id'=>'',
 *                               'title'=>'',
 *                               'callback'=>'',
 *                               'post_type'=>'',
 *                           )
 *                       );
*/

    

	function __construct()
	{	if(!empty($this->option))
        {   $this->settings = get_option($this->option);
            if(empty($this->settings))
            {	$this->settings = $this->settings_default;
                add_option($this->option,$this->settings);
            }
            add_action('admin_init',array(&$this,'register_settings'));
        }
		if(!empty($this->menu_param))
			add_action('admin_menu', array(&$this,'add_menu_page'));
		if(!empty($this->submenu_param))
			add_action('admin_menu', array(&$this,'add_submenu_page'));
        if(!empty($this->metaboxes))
			add_action('add_meta_boxes', array(&$this,'add_meta_boxes'));
		$this->init();
    }
	
	function init(){}
	
	public function add_menu_page()
	{	$defaults = array('capability' => 'manage_options');
        if(!empty($this->menu_param))
        {   $menu = wp_parse_args($this->menu_param,$defaults);
            extract( $menu, EXTR_SKIP );
            add_menu_page($page_title, $menu_title, $capability, $menu_slug, array(&$this,$function), $icon_url, $position );  
        }
    }
	
	public function add_submenu_page()
	{	$defaults = array('capability' => 'manage_options');
        if(!empty($this->submenu_param))
        {   foreach($this->submenu_param as $menu)
            {   $menu = wp_parse_args($menu,$defaults);
                extract( $menu, EXTR_SKIP );
                if($type !='')
                {   switch($type){
                        case 'option':
                            add_options_page($page_title,$menu_title,$capability,$menu_slug,array(&$this,$function));
                            break;
                        case 'submenu':
                            add_submenu_page($parent_slug, $page_title, $menu_title,$capability,$menu_slug,array(&$this,$function));
                            break;
                    }
                }
            }
        }
    }

    public function add_meta_boxes()
    {   $defaults = array('id'=>'',
                           'title'=>'',
                            'callback'=>'',
                            'post_type'=>null,
                            'context'=>'normal',
                            'priority'=>'default',
                            'callback_args'=>null,
                            'capability'=>'all');
        if(!empty($this->metaboxes))
        {   foreach($this->metaboxes as $metabox)
            {   $metabox = wp_parse_args($metabox,$defaults);
                extract($metabox,EXTR_SKIP);
                add_meta_box($id, $title, array(&$this,$callback), $post_type, $context, $priority, $callback_args);
			}
        }
    }

	function register_settings()
	{	register_setting($this->option,$this->option);		
	    $this->register_extra_settings();
    }

    function register_extra_settings(){}

	function layout_columns( $columns, $screen ) 
	{	if ( $screen == $this->pagehook ) 
		{	$columns[$this->pagehook] = 2;
		}
		return $columns;
	}
	
	public function render()
	{	$this->enqueue_scripts();
		$this->render_header();
		$this->render_body();
		$this->render_footer();		
	}
	
	public function enqueue_scripts(){} 
	
	public function render_header($screen_icon = 'options-general')
	{	echo '<div class="wrap">';
		screen_icon($screen_icon);
		echo '<h2>'.esc_html( get_admin_page_title() ).'</h2>';	
		//settings_errors();
	}
	
	function render_update_notice()
	{	if($this->message != '')
			echo $this->message;
		$this->message = '';
	}
	
	public function render_body(){}
	
	function render_footer()
	{	
		echo '</div> <!-- end wrap -->';
	}
	
	function render_metabox_script()
	{	?>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function ($) {
				// close postboxes that should be closed
				jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
			});
			//]]>
		</script>
	<?php
	}
	
	public function get_settings()
	{	return $this->settings;
	}
}

?>
