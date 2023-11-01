<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://notice.studio
 * @since      1.0.0
 *
 * @package    Noticefaq
 * @subpackage Noticefaq/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Noticefaq
 * @subpackage Noticefaq/includes
 */
class Noticefaq {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Noticefaq_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'NOTICEFAQ_VERSION' ) ) {
			$this->version = NOTICEFAQ_VERSION;
		} else {
			$this->version = '1.3';
		}
		$this->plugin_name = 'noticefaq';

		$this->load_dependencies();
		require_once(plugin_dir_path( __DIR__ ). '/blocks/noticefaq-block.php');

		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		add_action('wp_head', array($this, 'enqueue_noticefaq_scripts'),100);
		add_action('admin_menu', array($this, 'add_menu_page_notice'));
		add_shortcode('noticefaq', array( $this , 'noticefaq_shortcode' ));

	}
    public function add_menu_page_notice() {
		add_menu_page( 'Notice FAQ', 'Notice FAQ', 'manage_options', 'noticefaq', array( $this , 'noticefaq_init' ),'dashicons-lightbulb', 10 );
    }
	public function enqueue_noticefaq_scripts(){
		wp_enqueue_script('noticefaq-js', 'https://bundle.notice.studio/index.js'); /*External styling support provided by notice.studio, please refer README.txt for more details.*/
		wp_enqueue_style('noticefaq-css', 'https://bundle.notice.studio/index.css'); /*External js to support project animations and render by notice.studio, please refer README.txt for more details.*/

	}
	public function noticefaq_init(){
    echo '
	<div id="noticefaq-main">
		<div class="outerCont">
			<div class="row container-border rowbottomspacing">
				<div class="col-md-4"><img  src="'.plugin_dir_url( __DIR__ ).'assets/images/Dashboard.png'.'" width="100%" alt="noticeDashboard" /></div>
				<div class="col-md-4"></div>
				<div class="col-md-4 centertxt mob-spacing">
					<div><h2 class="dashboard-get graytxt">Get your</h2></div>
					<div><button type="button" class="noticefaq-btn noticefaq-yellow-btn" onclick="window.open(\'https://app.notice.studio/signin\')">Freemium</button></div>
				</div>
			</div>
	<div class="row rowbottomspacing">
	<div class="col-md-6 left-sect mob-spacing">
		<div class="row container-border">
			<div class="col-md-12">
				<div class="row block-heading-row">
				<div class="block-heading"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/upload.png'.'" alt="i1" /><label>DEPLOYMENT INSTRUCTIONS</label></div>
				</div>
				<div class="row block-content-row">
					<div class="block-content">
						<p>👣 First step: create your own documentation, FAQ or blog at Notice.studio. When it\'s done...</p>
						<p>Time to implement: your project shortcode is available in 🚀 Deploy section - just copy it!</p>
						<p>🖱️ Ready in one click: at Wordpress add a new block on the page you want to place your content. Select the shortcode option and paste it.</p>
						<p>Now all your creations are displayed on your website!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 right-sect">
		<div class="row container-border">
			<div class="col-md-12">
				<div class="row block-heading-row">
				<div class="block-heading"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/openbook.png'.'" alt="i2" /><label>GET SUPPORT</label></div>
				</div>
				<div class="row block-content-row">
					<div class="block-content">
						<div class="row">
						<div class="col-md-6 mob-spacing"><a href="https://www.youtube.com/channel/UCjplZkfyVJKV6wkRKWUWILw" class="link-label" target="_blank"><div class="centertxt"><img class="large-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/youtubelogo.png'.'" alt="i2" /><div class="img-label">YOUTUBE<br/>TUTORIALS</div></div></a></div>
						<div class="col-md-6"><a href="https://www.notice.studio/create-user-friendly-documentations" class="link-label" target="_blank"><div class="centertxt"><img class="large-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/docs.png'.'" alt="i2" /><div class="img-label">DOCUMENTATIONS</div></div></a></div>
						</div>
						<div class="row">
							<div class="col-md-12 centertxt add-padding-20">
								<p><button type="button" class="noticefaq-btn noticefaq-yellow-btn" onclick="window.open(\'https://app.notice.studio\')">Go to Editor</button>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="row rowbottomspacing">
	<div class="col-md-6 left-sect mob-spacing">
		<div class="row container-border">
			<div class="col-md-12">
				<div class="row block-heading-row">
				<div class="block-heading"><img class="small-icon-1" src="'.plugin_dir_url( __DIR__ ).'assets/images/bulb.png'.'" alt="i2" /><label>ABOUT NOTICE</label></div>
				</div>
				<div class="row block-content-row">
					<div class="block-content">
						<p>The single place to create, maintain and translate great content.</p>
						<p>Notice is a no-code editor that allows you to create, customize and implement an FAQ, documentation or blog in any web or mobile applications.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 right-sect">
		<div class="row container-border">
			<div class="col-md-12">
				<div class="row block-heading-row">
				<div class="block-heading"><img class="small-icon-2" src="'.plugin_dir_url( __DIR__ ).'assets/images/like.png'.'" alt="i2" /><label>SUPPORT US</label></div>
				</div>
				<div class="row block-content-row">
					<div class="block-content">
						<div class="row">
						<div class="col-md-6">
						<p>RATINGS<br/>Submit us a review 🤗</p>
						</div>
						<div class="col-md-6 centertxt">
						<p><button type="button" class="noticefaq-btn noticefaq-yellow-btn" onclick="window.open(\'https://wordpress.org/plugins/notice-faq/#reviews\')">Review</button>
						</p>
						</div>

						</div>
						<div class="row">
						<div class="col-md-6">
						<p>DONATE<br/>Would you like to support the advancement of this plugin? 👉</p>
						</div>
						<div class="col-md-6 centertxt">
						<p><button type="button" class="noticefaq-btn noticefaq-yellow-btn" onclick="window.open(\'https://www.patreon.com/notice\')">Support</button>
						</p>
						</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="row rowbottomspacing">
	<div class="col-md-12 mid-sect">
		<div class="row container-border">
			<div class="col-md-12">
				<div class="row block-heading-row">
				<div class="block-heading"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/play.png'.'" alt="i1" /><label>WATCH NOW</label></div>
				</div>
				<label class="img-label tut-tips cursor-def">tutorials & tips</label>
				<div class="row block-content-row">
					<div class="block-content">
					<div class="row" id="vidcarousel">
					<div class="col-md-4">
					<iframe class="carousel__vidframe" src="https://www.youtube.com/embed/T64lCE36Coo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					 </div>
					 <div class="col-md-4">
					 <iframe class="carousel__vidframe" src="https://www.youtube.com/embed/bLYPhUtSHc4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					 </div>
					 <div class="col-md-4">
					 <iframe class="carousel__vidframe" src="https://www.youtube.com/embed/kLKvkeNT6W0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					 </div>
					 </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="row rowbottomspacing">
	<div class="col-md-12 mid-sect">
		<div class="row container-border">
			<div class="col-md-12 add-padding-20">
	<div><iframe style="min-height: 600px;" src="https://app.notice.studio/signin" name="noticeEditor" height="100%" width="100%" title="Notice Editor"></iframe></div>
	</div>
	</div>
	</div></div>
	<div class="row rowbottomspacing">
	<div class="col-md-12 mid-sect">
		<div class="row container-border">
			<div class="col-md-12 add-padding-20">

				<div class="row block-content-row">
					<div class="block-content">
						<div class="row">
							<div class="col-md-4">
							<a href="https://notice.studio" target="_blank">
							<img class="large-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/noticesmall.png'.'" alt="i1" />
							</a>
							</div>
							<div class="col-md-4">
							<div class="row block-heading-row">
							<div class="block-heading"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/mailat.png'.'" alt="i5" /><label>SOCIAL MEDIA</label></div>
							</div>
							<div class="contact-us-row"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/youtube.png'.'" alt="i6" /><label class="img-label"><a href="https://www.youtube.com/channel/UCjplZkfyVJKV6wkRKWUWILw" class="link-label" target="_blank">Youtube</a></label></div>
							<div class="contact-us-row"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/linkedin.png'.'" alt="i7" /><label class="img-label"><a href="https://www.linkedin.com/company/noticestudio/?viewAsMember=true" class="link-label" target="_blank">LinkedIn</a></label></div>
							<div class="contact-us-row"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/twitter.png'.'" alt="i8" /><label class="img-label"><a href="https://twitter.com/Did_U_Notice " class="link-label" target="_blank">Did you Notice?</a></label></div>

							</div>
							<div class="col-md-4">
							<div class="row block-heading-row">
							<div class="block-heading"><img class="small-icon" src="'.plugin_dir_url( __DIR__ ).'assets/images/email.png'.'" alt="i5" /><label>CONTACT</label></div>
							</div>
							<div class="contact-us-row"><label class="img-label"><a href="mailto:contact@notice.studio" class="link-label" target="_blank">contact@notice.studio</a></label></div>
							<div class="contact-us-row mob-spacing"><label class="img-label"><a href="https://noticegroupe.slack.com/ssb/redirect" class="link-label" target="_blank">Join us on Slack</a></label></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
	';
}
public function noticefaq_shortcode( $atts, $content = null)	{
	extract( shortcode_atts( array(
				'projectid' => ''
			), $atts
		)
	);
	// this will display our message before the content of the shortcode
	return '<div class="notice-target-container" project-id="'.$projectid.'" notice-integration="wordpress-plugin"></div>';
}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Noticefaq_Loader. Orchestrates the hooks of the plugin.
	 * - Noticefaq_i18n. Defines internationalization functionality.
	 * - Noticefaq_Admin. Defines all hooks for the admin area.
	 * - Noticefaq_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-noticefaq-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-noticefaq-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-noticefaq-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-noticefaq-public.php';

		$this->loader = new Noticefaq_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Noticefaq_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Noticefaq_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Noticefaq_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Noticefaq_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Noticefaq_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
