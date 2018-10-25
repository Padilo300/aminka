<?php
class ControllerCommonHeader extends Controller {

        public function oct_minify_css() {
          $oct_data = $this->config->get('oct_techstore_data');
          $files = array(
            'view/javascript/bootstrap/css/bootstrap.min.css',
            //'view/theme/oct_techstore/stylesheet/font-awesome/css/font-awesome.min.css',
            'view/theme/oct_techstore/stylesheet/flipclock.css',
            'view/theme/oct_techstore/stylesheet/sumoselect.min.css',
            'view/theme/oct_techstore/stylesheet/stylesheet.css',
            'view/theme/oct_techstore/stylesheet/fonts.css',
            'view/theme/oct_techstore/stylesheet/autosearch.css',
            'view/theme/oct_techstore/stylesheet/popup.css',
            'view/theme/oct_techstore/stylesheet/responsive.css',
            'view/theme/oct_techstore/js/cloud-zoom/cloud-zoom.css',
            'view/javascript/jquery/magnific/magnific-popup.css',
            'view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css',
            'view/theme/oct_techstore/stylesheet/magnify.css',
            'view/javascript/jquery/owl-carousel/owl.carousel.css',
            'view/javascript/jquery/magnific/magnific-popup.css',
            'view/theme/oct_techstore/js/fancy-box/jquery.fancybox.min.css',
            'view/javascript/octemplates/oct_product_filter/nouislider.css',
            'view/theme/oct_techstore/stylesheet/jquery-ui.min.css',
            'view/theme/oct_techstore/stylesheet/dynamic_stylesheet.css',
          );
          $file_compress = DIR_APPLICATION . 'view/theme/oct_techstore/stylesheet/stylesheet_minify.css';
          $cache_life = 3600;
          if ($files) {
            if (!file_exists($file_compress) or (time() - filemtime($file_compress) >= $cache_life)) {
              $buffer = "";
              foreach ($files as $file) {
                $buffer .= file_get_contents(DIR_APPLICATION . $file);
              }
              $buffer .= html_entity_decode($oct_data['customcss'], ENT_QUOTES, 'UTF-8');
              $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
              $buffer = str_replace(': ', ':', $buffer);
              $buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $buffer);
              $buffer = str_replace(array('  ', '    ', '    '), ' ', $buffer);
              file_put_contents($file_compress, $buffer);
            }
          }
        }
        public function oct_minify_js() {
          $oct_data = $this->config->get('oct_techstore_data');
          $files = array(
            'view/javascript/jquery/jquery-2.1.1.min.js',
            'view/theme/oct_techstore/js/jquery-ui.min.js',
            'view/javascript/bootstrap/js/bootstrap.min.js',
            'view/javascript/jquery/owl-carousel/owl.carousel.min.js',
            'view/javascript/jquery/magnific/jquery.magnific-popup.min.js',
            'view/theme/oct_techstore/js/main.js',
            'view/theme/oct_techstore/js/common.js',
            'view/theme/oct_techstore/js/flexmenu.min.js',
            'view/theme/oct_techstore/js/flipclock.js',
            'view/theme/oct_techstore/js/barrating.js',
            'view/javascript/jquery/owl-carousel/owl.carousel.min.js',
            'view/theme/oct_techstore/js/input-mask.js',
            'view/theme/oct_techstore/js/fancy-box/jquery.fancybox.min.js',
            'view/theme/oct_techstore/js/jquery.sumoselect.min.js',
            'view/theme/oct_techstore/js/cloud-zoom/cloud-zoom.1.0.2.js',
            'view/javascript/jquery/magnific/jquery.magnific-popup.min.js',
            'view/javascript/jquery/datetimepicker/moment.js',
            'view/javascript/jquery/datetimepicker/locale/ru-ru.js',
            'view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js',
            'view/theme/oct_techstore/js/jquery.magnify.js',
            'view/javascript/octemplates/oct_product_filter/nouislider.js',
            'view/javascript/octemplates/oct_product_filter/wNumb.js',
            'view/theme/oct_techstore/js/lazyload/jquery.lazyload.min.js',
          );
          $file_compress = DIR_APPLICATION . 'view/theme/oct_techstore/js/javascript_minify.js';
          $cache_life = 3600;
          if ($files) {
            if (!file_exists($file_compress) or (time() - filemtime($file_compress) >= $cache_life)) {
              $buffer = "";
              foreach ($files as $file) {
                $buffer .= file_get_contents(DIR_APPLICATION . $file);
                $buffer .= "\r\n\r\n";
              }
             // $buffer .= html_entity_decode($oct_data['customjavascrip'], ENT_QUOTES, 'UTF-8');
              $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
              $buffer = str_replace(array("\r\n", "\r"), "\n", $buffer);
              $buffer = preg_replace('/[^\S\n]+/', ' ', $buffer);
              $buffer = str_replace(array(" \n", "\n "), "\n", $buffer);
              $buffer = preg_replace('/\n+/', "\n", $buffer);
              $buffer = str_replace(': ', ':', $buffer);
              $buffer = preg_replace(array('(( )+{)','({( )+)'), '{', $buffer);
              $buffer = preg_replace(array('(( )+})','(}( )+)','(;( )*})'), '}', $buffer);
              $buffer = preg_replace(array('(;( )+)','(( )+;)'), ';', $buffer);
              $buffer = str_replace(array(' {',' }','{ ','; '),array('{','}','{',';'), $buffer);
              file_put_contents($file_compress, $buffer);
            }
          }
        }
      
	public function index() {

        // oct_product_preorder start
        $data['oct_product_preorder_data'] = $this->config->get('oct_product_preorder_data');
        // oct_product_preorder end
      

        // oct_popup_call_phone start
        $data['oct_popup_call_phone_data'] = $this->config->get('oct_popup_call_phone_data');
        $data['popup_call_phone_text'] = $this->language->load('extension/module/oct_popup_call_phone');
        // oct_popup_call_phone end
      
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');
		$data['og_url'] = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
		$data['og_image'] = $this->document->getOgImage();


        // oct_blog start
        if (isset($this->request->get['oct_blog_article_id'])) {
          $oct_blog_article_id = (int)$this->request->get['oct_blog_article_id'];
        } else {
          $oct_blog_article_id = 0;
        }

        $this->load->model('octemplates/blog_article');
        $article_info = $this->model_octemplates_blog_article->getArticle($oct_blog_article_id);

        $data['og_meta_description'] = "";

        if ($article_info) {
          $this->load->model('tool/image');
          $data['og_image'] = $this->model_tool_image->resize($article_info['image'], 500, 500);
          $data['og_meta_description'] = utf8_substr(strip_tags(html_entity_decode($article_info['meta_description'], ENT_QUOTES, 'UTF-8')), 0, 250);
        }
        // oct_blog end
        
		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_page'] = $this->language->get('text_page');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

      $this->load->language('octemplates/oct_techstore');
      $data['oct_techstore_news'] = $this->language->get('oct_techstore_news');
      $data['oct_techstore_contact'] = $this->language->get('oct_techstore_contact');
      $data['oct_techstore_clock'] = $this->language->get('oct_techstore_clock');
      $data['oct_techstore_client_center'] = $this->language->get('oct_techstore_client_center');
      $data['oct_techstore_see_more'] = $this->language->get('oct_techstore_see_more');
      $data['oct_techstore_mmenu'] = $this->language->get('oct_techstore_mmenu');
      $data['oct_techstore_minfo'] = $this->language->get('oct_techstore_minfo');
      $data['oct_techstore_msearch'] = $this->language->get('oct_techstore_msearch');
      $data['oct_techstore_msearchb'] = $this->language->get('oct_techstore_msearchb');
      $data['oct_techstore_data'] = $oct_data = $this->config->get('oct_techstore_data');
      $data['oct_techstore_status'] = $this->config->get('oct_techstore_status');
      $data['link_cart'] = $this->url->link('checkout/cart');
      $data['link_wishlist'] = $this->url->link('account/wishlist', '', true);
      $data['link_compare'] = $this->url->link('product/compare');
      $data['link_login'] = $this->url->link('account/login', '', true);
      if ($oct_data['enable_minify'] == 'on') {
        $this->oct_minify_css();
        $this->oct_minify_js();
      }
      $data['text_news'] = $this->language->get('oct_techstore_news');
      $data['text_contact'] = $this->language->get('oct_techstore_contact');
      $data['text_clock'] = $this->language->get('oct_techstore_clock');
      $data['text_client_center'] = $this->language->get('oct_techstore_client_center');
      $data['text_see_more'] = $this->language->get('oct_techstore_see_more');
      $data['oct_techstore_news'] = $this->url->link('octemplates/blog_articles');
      // Вывод ссылок на статьи
      $data['oct_techstore_header_information_links'] = array();
      $this->load->model('catalog/information');
      if (isset($oct_data['header_information_links'])) {
        foreach ($this->model_catalog_information->getInformations() as $result) {
          if (in_array($result['information_id'], $oct_data['header_information_links'])) {
            $data['oct_techstore_header_information_links'][] = array(
              'title' => $result['title'],
              'href' => $this->url->link('information/information', 'information_id=' . $result['information_id'])
            );
          }
        }
      }
      // Свой CSS и Javascript код
      $data['oct_techstore_customcss'] = html_entity_decode($oct_data['customcss'], ENT_QUOTES, 'UTF-8');
      $data['oct_techstore_customjavascrip'] = html_entity_decode($oct_data['customjavascrip'], ENT_QUOTES, 'UTF-8');
      $oct_techstore_cont_clock = $oct_data['cont_clock'];
      if (isset($oct_techstore_cont_clock[$this->session->data['language']]) && !empty($oct_techstore_cont_clock[$this->session->data['language']])) {
        $data['oct_techstore_cont_clock'] = array_values(array_filter(explode(PHP_EOL, $oct_techstore_cont_clock[$this->session->data['language']])));
      } else {
        $data['oct_techstore_cont_clock'] = false;
      }
      if (isset($oct_data['cont_phones']) && !empty($oct_data['cont_phones'])) {
        $data['oct_techstore_cont_phones'] = array_values(array_filter(explode(PHP_EOL, $oct_data['cont_phones'])));
      } else {
        $data['oct_techstore_cont_phones'] = false;
      }
      

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}


        // start: oct_megamenu
				$data['categories'] = array();

				foreach ($categories as $category) {
					if ($category['top']) {
						// Level 2
						$children_data = array();

						$children = $this->model_catalog_category->getCategories($category['category_id']);

						foreach ($children as $child) {
							$filter_data = array(
								'filter_category_id'  => $child['category_id'],
								'filter_sub_category' => true
							);

							// Level 3
							$children_data_2 = array();

							$children_2 = $this->model_catalog_category->getCategories($category['category_id']);

							foreach ($children_2 as $child_2) {
								$filter_data = array(
									'filter_category_id'  => $child_2['category_id'],
									'filter_sub_category' => true
								);

								$children_data_2[] = array(
									'children' => $children_data_2,
									'name'  => $child_2['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
									'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $child_2['category_id'])
								);
							}

							$children_data[] = array(
								'children' => $children_data_2,
								'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
								'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
							);
						}

						// Level 1
						$data['categories'][] = array(
							'name'     => $category['name'],
							'children' => $children_data,
							'column'   => $category['column'] ? $category['column'] : 1,
							'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
						);
					}
				}
		
        $data['oct_megamenu_data'] = $this->config->get('oct_megamenu_data');
        $oct_megamenu_data = $this->config->get('oct_megamenu_data');
        $data['oct_megamenu'] = (isset($oct_megamenu_data['status']) && $oct_megamenu_data['status'] == 1) ? $this->load->controller('extension/module/oct_megamenu') : '';
        // end: oct_megamenu
      
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		return $this->load->view('common/header', $data);
	}
}
