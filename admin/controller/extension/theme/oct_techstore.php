<?php 

class ControllerExtensionThemeOctTechstore extends Controller
{
    private $error = array(  );

    public function index()
    {
        $data = array(  );
        $install = true;
        $this->load->model("extension/extension");
        $this->load->model("setting/setting");
        if( !in_array("oct_techstore", $this->model_extension_extension->getInstalled("theme")) ) 
        {
            $this->response->redirect($this->url->link("extension/extension", "token=" . $this->session->data["token"] . "&type=theme", true));
        }

        $data = array_merge($data, $this->load->language("extension/theme/oct_techstore"));
        $this->document->setTitle($this->language->get("heading_title_sub"));
        if( isset($this->request->get["store_id"]) ) 
        {
            $store_id = $this->request->get["store_id"];
        }
        else
        {
            $store_id = 0;
        }

        if( $this->request->server["REQUEST_METHOD"] == "POST" && $this->validate_verification() ) 
        {
            $curl_data = $this->sendCurlDefault($this->request->post["oct_techstore_verification"]);
            if( $curl_data["status"] == 200 && !empty($curl_data["response"]) ) 
            {
                $this->model_setting_setting->editSetting("oct_techstore", $curl_data["response"], $store_id);
            }

            $this->model_setting_setting->editSettingValue("oct_techstore", "oct_techstore_verification", $this->request->post["oct_techstore_verification"], $store_id);
            $install = false;
        }

        if( isset($this->session->data["success"]) ) 
        {
            $data["success"] = $this->session->data["success"];
            unset($this->session->data["success"]);
        }
        else
        {
            $data["success"] = "";
        }

        if( isset($this->session->data["warning"]) ) 
        {
            $data["warning"] = $this->session->data["warning"];
            unset($this->session->data["warning"]);
        }
        else
        {
            $data["warning"] = "";
        }

        $data["error_warning"] = (isset($this->error["warning"]) ? $this->error["warning"] : "");
        $data["error_verification"] = (isset($this->error["verification"]) ? $this->error["verification"] : "");
        $this->document->addStyle("view/stylesheet/oct_techstore.css");
        $data["breadcrumbs"] = array(  );
        $data["breadcrumbs"][] = array( "text" => $this->language->get("text_home"), "href" => $this->url->link("common/dashboard", "token=" . $this->session->data["token"], true) );
        $data["breadcrumbs"][] = array( "text" => $this->language->get("text_module"), "href" => $this->url->link("extension/extension", "token=" . $this->session->data["token"] . "&type=theme", true) );
        $data["breadcrumbs"][] = array( "text" => $this->language->get("heading_title"), "href" => $this->url->link("extension/theme/oct_techstore", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true) );
        $data["action"] = $this->url->link("extension/theme/oct_techstore", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true);
        $data["cancel"] = $this->url->link("extension/extension", "token=" . $this->session->data["token"] . "&type=theme", true);
        if( isset($this->request->post["oct_techstore_verification"]) ) 
        {
            $data["oct_techstore_verification"] = $oct_techstore_verification = $this->request->post["oct_techstore_verification"];
        }
        else
        {
            $data["oct_techstore_verification"] = $oct_techstore_verification = $this->config->get("oct_techstore_verification");
        }
        
        if ($oct_techstore_verification === 'nulled') {
            $install = false;
        }

        $curl_data = $this->sendCurlVerification($data["oct_techstore_verification"], $install);
        if( $curl_data["status"] == 200 && !empty($curl_data["response"]) ) 
        {
            $this->response->redirect($this->url->link("extension/theme/oct_techstore/main", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true));
        }

        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        $this->response->setOutput($this->load->view("extension/theme/oct_techstore_verification", $data));
    }

    public function sendCurlDefault($verification)
	{
		
		$response = '{"oct_techstore_verification":"","oct_techstore_status":"1","oct_techstore_product_limit":"18","oct_techstore_product_description_length":"100","oct_techstore_image_category_width":"150","oct_techstore_image_category_height":"150","oct_techstore_image_thumb_width":"720","oct_techstore_image_thumb_height":"720","oct_techstore_image_popup_width":"1000","oct_techstore_image_popup_height":"1000","oct_techstore_image_product_width":"300","oct_techstore_image_product_height":"350","oct_techstore_image_additional_width":"90","oct_techstore_image_additional_height":"90","oct_techstore_image_related_width":"80","oct_techstore_image_related_height":"80","oct_techstore_image_compare_width":"180","oct_techstore_image_compare_height":"280","oct_techstore_image_wishlist_width":"47","oct_techstore_image_wishlist_height":"47","oct_techstore_image_cart_width":"47","oct_techstore_image_cart_height":"47","oct_techstore_image_location_width":"210","oct_techstore_image_location_height":"44","oct_techstore_data":{"showmanlogos":"on","terms":"","maincolor1":"4F5F6F","maincolor2":"59C2E6","enable_minify":"off","showcontacts":"on","shownews":"on","header_information_links":[],"head_1line_bg_1line":"4F5F6F","head_1line_bg_main":"FFFFFF","head_1line_color_1line_link":"FFFFFF","head_1line_color_1line_link_hover":"C9E7F1","head_1line_bg_1line_link_hover":"57697A","head_1line_bg_tine_and_account":"57697A","head_1line_bg_underscores_hover":"00D4FB","head_dropdown_el_bg":"FFFFFF","head_dropdown_el_color_link":"000000","head_dropdown_el_color_link_hover":"00D4FB","head_2ndline_color_tel_text":"566072","head_2ndline_color_tel_icon":"CECECE","head_2ndline_bg_cart":"F7F9FA","head_2ndline_color_cart_text":"CECECE","head_2ndline_color_cart_total":"59C2E6","head_2ndline_color_cart_text_hover":"00D4FB","head_megamenu_bg_link":"59C2E6","head_megamenu_bg_link_underscores_hover":"647382","head_megamenu_color_link_text":"4F5F6F","head_megamenu_color_link_text_hover":"FFFFFF","head_megamenu_el_bg":"FFFFFF","head_megamenu_el_color_link":"333333","head_megamenu_el_color_link_hover":"FFFFFF","head_megamenu_el_color_link_2_hover":"FFFFFF","head_megamenu_el_bg_link_hover":"59C2E6","head_megamenu_el_color_price_in_specials":"34BBE3","head_megamenu_el_color_price_old_in_specials":"9E9E9E","foot_show_soclinks":"on","foot_show_contact_link":"on","foot_show_copy_and_payment":"on","foot_show_block_contact_link":"on","foot_show_block_return_link":"on","foot_show_block_sitemap_link":"on","foot_show_block_manufacturer_link":"on","foot_show_block_voucher_link":"on","foot_show_block_affiliate_link":"on","foot_show_block_special_link":"on","foot_info_links":[],"foot_cat_links":[],"foot_garantedtext_show":"on","foot_garantedtext":[{"icon":"fa fa-phone","popup":"on","description":{"ru-ru":{"name":"\u041a\u0440\u0443\u0433\u043b\u043e\u0441\u0443\u0442\u043e\u0447\u043d\u044b\u0439 call-\u0446\u0435\u043d\u0442\u0440","link":"#","text":"\u0411\u0435\u0441\u043f\u043b\u0430\u0442\u043d\u044b\u0435 \u043a\u043e\u043d\u0441\u0443\u043b\u044c\u0442\u0430\u0446\u0438\u0438 \u043f\u043e \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0443"},"en-gb":{"name":"24-hour call center","link":"#","text":"Free telephone consultations"}}},{"icon":"fa fa-star-o","popup":"on","description":{"ru-ru":{"name":"100% \u0433\u0430\u0440\u0430\u043d\u0442\u0438\u044f \u043d\u0430 \u0442\u043e\u0432\u0430\u0440","link":"#","text":"\u041f\u043e\u0436\u0438\u0437\u043d\u0435\u043d\u043d\u0430\u044f \u0433\u0430\u0440\u0430\u043d\u0442\u0438\u044f \u043d\u0430 \u0442\u043e\u0432\u0430\u0440\u044b \u043c\u0430\u0433\u0430\u0437\u0438\u043d\u0430"},"en-gb":{"name":"Perpetual guarantee","link":"#","text":"Lifetime warranty on goods store"}}},{"icon":"fa fa-truck","popup":"on","description":{"ru-ru":{"name":"\u0411\u0435\u0441\u043f\u043b\u0430\u0442\u043d\u0430\u044f \u0434\u043e\u0441\u0442\u0430\u0432\u043a\u0430","link":"#","text":"\u041d\u0430 \u0441\u0443\u043c\u043c\u0443 \u0437\u0430\u043a\u0430\u0437\u0430 \u043e\u0442 10000 \u0440\u0443\u0431\u043b\u0435\u0439"},"en-gb":{"name":"Free shipping","link":"#","text":"For the order amount from 10,000 rub"}}},{"icon":"fa fa-group","popup":"on","description":{"ru-ru":{"name":"\u0412\u044b\u0433\u043e\u0434\u043d\u044b\u0435 \u0443\u0441\u043b\u043e\u0432\u0438\u044f","link":"#","text":"\u041f\u0440\u0435\u0434\u043b\u0430\u0433\u0430\u0435\u043c \u0441\u043e\u0442\u0440\u0443\u0434\u043d\u0438\u0447\u0435\u0441\u0442\u0432\u043e"},"en-gb":{"name":"Free shipping","link":"#","text":"For the order amount from 10,000 rub"}}}],"foot_bg_foot":"4F5F6F","foot_color_guarantee_icon":"F5F5F6","foot_color_guarantee_icon_hover":"85D0EB","foot_color_guarantee_text":"76828F","foot_color_heading_text":"85D0EB","foot_color_links":"F5F5F6","foot_color_links_hover":"86D0EB","foot_color_contact_icon":"86D1EB","foot_bg_bar":"70879E","foot_bg_bar_el_hover":"57697A","foot_color_bar_el_text":"FFFFFF","foot_color_bar_el_text_hover":"C9E7F1","cat_show_subcat":"on","cat_sorttype":"on","cat_discountbg":"E91E63","cat_discountcolor":"FFFFFF","cat_color_price":"59C2E6","cat_color_price_old":"CECECE","cat_boxtext":"4F5F6F","cat_boxbg":"F1F5F5","cat_modulebg":"FBFCFC","cat_itembg":"F1F5F5","cat_plusminus":"4F5F6F","cat_checkbox":"59C2E6","cat_checkboxactive":"4F5F6F","cat_1levelbg":"4F5F6F","cat_1levelcolor":"59C2E6","cat_2levelbg":"59C2E6","cat_2levelcolor":"FFFFFF","cat_3levelbg":"59C2E6","cat_3levelcolor":"4F5F6F","cat_3levelbgactive":"59C2E6","cat_3leveltextactive":"FFFFFF","pr_micro":"on","pr_additional_tab_show":"on","pr_additional_tab_heading":[],"pr_additional_tab_text":[],"pr_social_button_script":"","pr_garantedtext_show":"on","pr_garantedtext":[{"icon":"fa fa-thumbs-o-up","popup":"on","description":{"ru-ru":{"name":"\u041a\u0430\u0447\u0435\u0441\u0442\u0432\u043e","link":"#"},"en-gb":{"name":"Quality","link":"#"}}},{"icon":"fa fa-plane","popup":"on","description":{"ru-ru":{"name":"\u0414\u043e\u0441\u0442\u0430\u0432\u043a\u0430","link":"#"},"en-gb":{"name":"Delivery","link":"#"}}},{"icon":"fa fa-money","popup":"on","description":{"ru-ru":{"name":"\u041e\u043f\u043b\u0430\u0442\u0430","link":"#"},"en-gb":{"name":"Payment","link":"#"}}},{"icon":"fa fa-refresh","popup":"on","description":{"ru-ru":{"name":"\u041e\u0431\u043c\u0435\u043d","link":"#"},"en-gb":{"name":"Refund","link":"#"}}}],"pr_color_button_add_ro_cart":"59C2E6","pr_color_button_add_ro_cart_hover":"4F5F6F","pr_color_button_other":"4F5F6F","pr_color_button_other_hover":"59C2E6","pr_bg_block":"F4F6F8","pr_bg_tab":"59C2E6","pr_bg_tab_active":"4F5F6F","pr_color_tab_text":"FFFFFF","pr_color_price":"59C2E6","pr_color_price_old":"4F5F6F","pr_color_image_border":"59C2E6","pr_color_guarantee_icon":"59C2E6","pr_color_guarantee_text":"4F5F6F","pr_color_block_under_heading_text":"59C2E6","pr_color_block_under_heading_icon":"59C2E6","mob_mainlinebg":"4F5F6F","mod_mainline_iconcolor":"FFFFFF","mod_dropdown_headingbg":"4F5F6F","mod_dropdown_heading_and_buttoncolor":"59C2E6","mod_dropdown_linktextcolor":"4F5F6F","mod_header_iconrcolor":"4F5F6F","mod_header_iconrbg":"59C2E6","cont_phones":"8 (050) 753-10-20\n\t8 (063) 100-12-10\n\t8 (911) 753-10-20","cont_skype":"tech-store@octemplates","cont_email":"test@mail.ru","cont_adress":{"ru-ru":"\u0420\u043e\u0441\u0441\u0438\u044f, \u0433. \u041c\u043e\u0441\u043a\u0432\u0430. \u0411\u043e\u043b\u044c\u0448\u0430\u044f \u041f\u0438\u0440\u043e\u0433\u043e\u0432\u0441\u043a\u0430\u044f \u0443\u043b. 17, 3 \u044d\u0442\u0430\u0436, \u043e\u0444\u0438\u0441 315","en-gb":"Russia, Moscow. Big Pirogovskaya. 17, third floor, office 315"},"cont_clock":{"ru-ru":"\u041f\u041d-\u041f\u0422: 09:00 - 18:00\n\t\u0421\u0411: 10:00 - 16:00\n\t\u0412\u0421: 10:00 - 14:00","en-gb":"MON-FR: 09:00 - 18:00\n\tST: 10:00 - 16:00\n\tSUN: 10:00 - 14:00"},"cont_contacthtml":[],"cont_contactmap":"","ps_facebook_id":"https:\/\/facebook.com","ps_vk_id":"https:\/\/vk.com","ps_gplus_id":"","ps_odnoklass_id":"https:\/\/ok.ru","ps_twitter_username":"","ps_vimeo_id":"","ps_pinterest_id":"","ps_flick_id":"","ps_instagram":"https:\/\/instagram.com","ps_youtube_id":"","ps_sberbank":"on","ps_privat":"on","ps_yamoney":"on","ps_webmoney":"on","ps_visa":"on","ps_qiwi":"off","ps_skrill":"off","ps_interkassa":"off","ps_liqpay":"off","ps_paypal":"off","ps_robokassa":"off","customcss":"","customjavascrip":"","template_version":"1.0"}}';
		
		$results = array(
			'response' => json_decode( $response, true ),
			'status' => 200
		);

		return $results;
	}

    public function sendCurlVerification($verification, $install = false)
	{
	    if ($install) return array(
			'response' => array(
			    'status' => 1,
				'date_end' => '0000-00-00'
			),
			'status' => 404
		);;
	    
		return array(
			'response' => array(
			    'status' => 1,
				'date_end' => '0000-00-00'
			),
			'status' => 200
		);
	}

    public function main()
    {
        $data = array(  );
        $this->load->model("extension/extension");
        $this->load->model("setting/setting");
        $this->load->model("tool/image");
        if( !in_array("oct_techstore", $this->model_extension_extension->getInstalled("theme")) ) 
        {
            $this->response->redirect($this->url->link("extension/extension", "token=" . $this->session->data["token"] . "&type=theme", true));
        }

        $data = array_merge($data, $this->load->language("extension/theme/oct_techstore"));
        $this->document->setTitle($this->language->get("heading_title_sub"));
        if( $this->config->get("config_editor_default") ) 
        {
            $this->document->addScript("view/javascript/ckeditor/ckeditor.js");
            $this->document->addScript("view/javascript/ckeditor/ckeditor_init.js");
        }
        else
        {
            $this->document->addScript("view/javascript/summernote/summernote.js");
            $this->document->addScript("view/javascript/summernote/lang/summernote-" . $this->language->get("lang") . ".js");
            $this->document->addScript("view/javascript/summernote/opencart.js");
            $this->document->addStyle("view/javascript/summernote/summernote.css");
        }

        $data["ckeditor"] = $this->config->get("config_editor_default");
        if( isset($this->request->get["store_id"]) ) 
        {
            $store_id = $this->request->get["store_id"];
        }
        else
        {
            $store_id = 0;
        }

        if( $this->request->server["REQUEST_METHOD"] == "POST" && $this->validate() ) 
        {
            $curl_data = $this->sendCurl($this->request->post);
            if( $curl_data["status"] == 200 && !empty($curl_data["response"]) ) 
            {
                $this->model_setting_setting->editSetting("oct_techstore", $curl_data["response"], $store_id);
            }

            $this->session->data["success"] = $this->language->get("text_success");
            if( isset($this->request->post["actionstay"]) && $this->request->post["actionstay"] == 1 ) 
            {
                $this->response->redirect($this->url->link("extension/theme/oct_techstore/main", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true));
            }
            else
            {
                $this->response->redirect($this->url->link("extension/extension", "token=" . $this->session->data["token"] . "&type=theme", true));
            }

        }

        if( isset($this->session->data["success"]) ) 
        {
            $data["success"] = $this->session->data["success"];
            unset($this->session->data["success"]);
        }
        else
        {
            $data["success"] = "";
        }

        if( isset($this->session->data["warning"]) ) 
        {
            $data["warning"] = $this->session->data["warning"];
            unset($this->session->data["warning"]);
        }
        else
        {
            $data["warning"] = "";
        }

        $data["token"] = $this->session->data["token"];
        $data["error_warning"] = (isset($this->error["warning"]) ? $this->error["warning"] : "");
        $data["error_product_limit"] = (isset($this->error["oct_techstore_product_limit"]) ? $this->error["oct_techstore_product_limit"] : "");
        $data["error_product_description_length"] = (isset($this->error["oct_techstore_product_description_length"]) ? $this->error["oct_techstore_product_description_length"] : "");
        $data["error_image_category"] = (isset($this->error["oct_techstore_image_category"]) ? $this->error["oct_techstore_image_category"] : "");
        $data["error_image_thumb"] = (isset($this->error["oct_techstore_image_thumb"]) ? $this->error["oct_techstore_image_thumb"] : "");
        $data["error_image_popup"] = (isset($this->error["oct_techstore_image_popup"]) ? $this->error["oct_techstore_image_popup"] : "");
        $data["error_image_product"] = (isset($this->error["oct_techstore_image_product"]) ? $this->error["oct_techstore_image_product"] : "");
        $data["error_image_additional"] = (isset($this->error["oct_techstore_image_additional"]) ? $this->error["oct_techstore_image_additional"] : "");
        $data["error_image_related"] = (isset($this->error["oct_techstore_image_related"]) ? $this->error["oct_techstore_image_related"] : "");
        $data["error_image_compare"] = (isset($this->error["oct_techstore_image_compare"]) ? $this->error["oct_techstore_image_compare"] : "");
        $data["error_image_wishlist"] = (isset($this->error["oct_techstore_image_wishlist"]) ? $this->error["oct_techstore_image_wishlist"] : "");
        $data["error_image_cart"] = (isset($this->error["oct_techstore_image_cart"]) ? $this->error["oct_techstore_image_cart"] : "");
        $data["error_image_location"] = (isset($this->error["oct_techstore_image_location"]) ? $this->error["oct_techstore_image_location"] : "");
        $this->document->addStyle("view/stylesheet/oct_techstore.css");
        $data["breadcrumbs"] = array(  );
        $data["breadcrumbs"][] = array( "text" => $this->language->get("text_home"), "href" => $this->url->link("common/dashboard", "token=" . $this->session->data["token"], true) );
        $data["breadcrumbs"][] = array( "text" => $this->language->get("text_module"), "href" => $this->url->link("extension/extension", "token=" . $this->session->data["token"] . "&type=theme", true) );
        $data["breadcrumbs"][] = array( "text" => $this->language->get("heading_title"), "href" => $this->url->link("extension/theme/oct_techstore/main", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true) );
        $data["action"] = $this->url->link("extension/theme/oct_techstore/main", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true);
        $data["cache"] = $this->url->link("extension/theme/oct_techstore/cache", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true);
        $data["cancel"] = $this->url->link("extension/extension", "token=" . $this->session->data["token"] . "&type=theme", true);
        if( $this->request->server["REQUEST_METHOD"] != "POST" ) 
        {
            $setting_info = $this->model_setting_setting->getSetting("oct_techstore", $store_id);
        }

        if( isset($this->request->post["oct_techstore_verification"]) ) 
        {
            $data["oct_techstore_verification"] = $oct_techstore_verification = $this->request->post["oct_techstore_verification"];
        }
        else
        {
            if( isset($setting_info["oct_techstore_verification"]) ) 
            {
                $data["oct_techstore_verification"] = $oct_techstore_verification = $setting_info["oct_techstore_verification"];
            }
            else
            {
                $data["oct_techstore_verification"] = $oct_techstore_verification = "";
            }

        }

        $curl_data = $this->sendCurlVerification($oct_techstore_verification);
        if( $curl_data["status"] != 200 || empty($curl_data["response"]) ) 
        {
            $this->response->redirect($this->url->link("extension/theme/oct_techstore", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true));
        }

        $data["license_expire"] = "";
        if( $curl_data["status"] == 200 || !empty($curl_data["response"]) ) 
        {
            if( $curl_data["response"]["date_end"] == "0000-00-00" ) 
            {
                $data["license_expire"] = $this->language->get("text_license_expire_forever");
                $data["license_expire_forever_status"] = 1;
            }
            else
            {
                $license_expire_days1 = strtotime(date("Y-m-d"));
                $license_expire_days2 = strtotime($curl_data["response"]["date_end"]);
                $license_expire_diff = $license_expire_days2 - $license_expire_days1;
                if( floor($license_expire_diff / 3600 / 24) < 0 ) 
                {
                    $data["license_expire"] = $this->language->get("text_license_end");
                    $data["license_expire_forever_status"] = 0;
                }
                else
                {
                    $data["license_expire"] = floor($license_expire_diff / 3600 / 24) . " " . $this->day_format(floor($license_expire_diff / 3600 / 24), $this->language->get("text_license_expire_day_1"), $this->language->get("text_license_expire_day_2"), $this->language->get("text_license_expire_day_3"));
                    $data["license_expire_forever_status"] = 2;
                }

            }

        }

        if (isset( $this->request->post['status'] )) {
			$data['value_001'] = $this->request->post['status'];
		}
		else if (isset( $setting_info[$this->sendCurlDecode( 'status', $oct_techstore_verification )] )) {
			$data['value_001'] = $setting_info[$this->sendCurlDecode( 'status', $oct_techstore_verification )];
		}
		else {
			$data['value_001'] = '';
		}

        if( isset($this->request->post["techstore_settings"]) ) 
        {
            $data["value_002"] = $this->request->post["techstore_settings"];
        }
        else
        {
            $data["value_002"] = $this->config->get($this->sendCurlDecode("techstore_settings", $oct_techstore_verification));
        }

        if( isset($data["value_002"]["oct_lazyload"]) && empty($data["value_002"]["oct_lazyload"]) ) 
        {
            $data["value_002"]["oct_lazyload"] = 0;
        }

        if( isset($data["value_002"]["oct_lazyload_module"]) && empty($data["value_002"]["oct_lazyload_module"]) ) 
        {
            $data["value_002"]["oct_lazyload_module"] = 0;
        }

        $config_data = array( "oct_techstore_verification", "oct_techstore_product_limit", "oct_techstore_product_description_length", "oct_techstore_image_category_width", "oct_techstore_image_category_height", "oct_techstore_image_thumb_width", "oct_techstore_image_thumb_height", "oct_techstore_image_popup_width", "oct_techstore_image_popup_height", "oct_techstore_image_product_width", "oct_techstore_image_product_height", "oct_techstore_image_additional_width", "oct_techstore_image_additional_height", "oct_techstore_image_related_width", "oct_techstore_image_related_height", "oct_techstore_image_compare_width", "oct_techstore_image_compare_height", "oct_techstore_image_wishlist_width", "oct_techstore_image_wishlist_height", "oct_techstore_image_cart_width", "oct_techstore_image_cart_height", "oct_techstore_image_location_width", "oct_techstore_image_location_height" );
        foreach( $config_data as $conf ) 
        {
            if( isset($this->request->post[$conf]) ) 
            {
                $data[$conf] = $this->request->post[$conf];
            }
            else
            {
                $data[$conf] = $this->config->get($conf);
            }

        }
        $this->load->model("catalog/information");
        $data["informations"] = array(  );
        foreach( $this->model_catalog_information->getInformations() as $information ) 
        {
            $data["informations"][] = array( "information_id" => $information["information_id"], "title" => $information["title"], "href" => "index.php?route=information/information&information_id=" . $information["information_id"] );
        }
        $this->load->model("catalog/category");
        $data["categories"] = array(  );
        foreach( $this->model_catalog_category->getCategories(array( "sort" => "name", "order" => "ASC" )) as $category ) 
        {
            $data["categories"][] = array( "category_id" => $category["category_id"], "name" => $category["name"] );
        }
        $this->load->model("localisation/language");
        $data["languages"] = $this->model_localisation_language->getLanguages();
        $data["placeholder"] = $this->model_tool_image->resize("no_image.png", 50, 50);
        if( isset($this->request->post["ps_additional_icons"]) ) 
        {
            $ps_additional_icons = $this->request->post["ps_additional_icons"];
        }
        else
        {
            if( isset($data["value_002"]["ps_additional_icons"]) ) 
            {
                $ps_additional_icons = $data["value_002"]["ps_additional_icons"];
            }
            else
            {
                $ps_additional_icons = array(  );
            }

        }

        $data["ps_additional_icons"] = array(  );
        foreach( $ps_additional_icons as $ps_additional_icon ) 
        {
            if( is_file(DIR_IMAGE . $ps_additional_icon["image"]) ) 
            {
                $image = $ps_additional_icon["image"];
                $thumb = $ps_additional_icon["image"];
            }
            else
            {
                $image = "";
                $thumb = "no_image.png";
            }

            $data["ps_additional_icons"][] = array( "image" => $image, "thumb" => $this->model_tool_image->resize($thumb, 50, 50), "sort_order" => ($ps_additional_icon["sort_order"] ? $ps_additional_icon["sort_order"] : 0) );
        }
        $this->load->model("tool/image");
        if( isset($this->request->post["k4a4s474x55444b4o4x5m4k4m5h5b4a4m434"]["oct_lazyload_image"]) && is_file(DIR_IMAGE . $this->request->post["k4a4s474x55444b4o4x5m4k4m5h5b4a4m434"]["oct_lazyload_image"]) ) 
        {
            $data["thumb"] = $this->model_tool_image->resize($this->request->post["k4a4s474x55444b4o4x5m4k4m5h5b4a4m434"]["oct_lazyload_image"], 100, 100);
        }
        else
        {
            if( isset($data["value_002"]["oct_lazyload_image"]) && is_file(DIR_IMAGE . $data["value_002"]["oct_lazyload_image"]) ) 
            {
                $data["thumb"] = $this->model_tool_image->resize($data["value_002"]["oct_lazyload_image"], 100, 100);
            }
            else
            {
                $data["thumb"] = $this->model_tool_image->resize("catalog/1lazy/oct_loader_product.gif", 100, 100);
            }

        }

        $data["placeholder"] = $this->model_tool_image->resize("no_image.png", 100, 100);
        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        $this->response->setOutput($this->load->view("extension/theme/oct_techstore", $data));
    }

    public function sendCurl($data)
	{
	    foreach ($data['techstore_settings'] as $key => $value) {
	        $test['oct_techstore_' . $key] = $value;
	    }

        $results = array(
			'response' => array_merge([
			    "oct_techstore_verification" => 'nulled',
			    "oct_techstore_status"=> $data['status'] ?: 1,
			    "oct_techstore_product_limit" => $data['oct_techstore_product_limit'] ?: 28,
			    "oct_techstore_product_description_length" => $data['oct_techstore_product_description_length'] ?: 100,
			    "oct_techstore_image_category_width" => $data['oct_techstore_image_category_width'] ?: 150,
			    "oct_techstore_image_category_height" => $data['oct_techstore_image_category_height'] ?: 150,
			    "oct_techstore_image_thumb_width" => $data['oct_techstore_image_thumb_width'] ?: 720,
			    "oct_techstore_image_thumb_height" => $data['oct_techstore_image_thumb_height'] ?: 720,
			    "oct_techstore_image_popup_width" => $data['oct_techstore_image_popup_width'] ?: 1000,
			    "oct_techstore_image_popup_height" => $data['oct_techstore_image_popup_height'] ?: 1000,
			    "oct_techstore_image_product_width" => $data['oct_techstore_image_product_width'] ?: 300,
			    "oct_techstore_image_product_height" => $data['oct_techstore_image_product_height'] ?: 350,
			    "oct_techstore_image_additional_width" => $data['oct_techstore_image_additional_width'] ?: 90,
			    "oct_techstore_image_additional_height" => $data['oct_techstore_image_additional_height'] ?: 90,
			    "oct_techstore_image_related_width" => $data['oct_techstore_image_related_width'] ?: 80,
			    "oct_techstore_image_related_height" => $data['oct_techstore_image_related_height'] ?: 80,
			    "oct_techstore_image_compare_width" => $data['oct_techstore_image_compare_width'] ?: 180,
			    "oct_techstore_image_compare_height" => $data['oct_techstore_image_compare_height'] ?: 280,
			    "oct_techstore_image_wishlist_width" => $data['oct_techstore_image_wishlist_width'] ?: 47,
			    "oct_techstore_image_wishlist_height" => $data['oct_techstore_image_wishlist_height'] ?: 47,
			    "oct_techstore_image_cart_width" => $data['oct_techstore_image_cart_width'] ?: 47,
			    "oct_techstore_image_cart_height" => $data['oct_techstore_image_cart_height'] ?: 47,
			    "oct_techstore_image_location_width" => $data['oct_techstore_image_location_width'] ?: 210,
			    "oct_techstore_image_location_height" => $data['oct_techstore_image_location_height'] ?: 44,
			    "oct_techstore_data" => array_merge($this->sendCurlDefault(true)['response']['oct_techstore_data'], $data['techstore_settings']),
			    "oct_techstore_status" => true,
			], $test),
			'status' => 200
		);

		return $results;
	}

    public function day_format($n, $form1, $form2, $form3)
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if( 10 < $n && $n < 20 ) 
        {
            return $form3;
        }

        if( 1 < $n1 && $n1 < 5 ) 
        {
            return $form2;
        }

        if( $n1 == 1 ) 
        {
            return $form1;
        }

        return $form3;
    }

    public function sendCurlDecode($string = '', $verification = '')
	{
		
		if ($string === 'status') {
			return 'oct_techstore_status';
		}
			
		if ($string === 'techstore_settings') {
			return 'oct_techstore_data';
		}		

		return $verification;
	}

    public function cache()
    {
        $this->load->language("extension/theme/oct_techstore");
        $this->cache->delete("octemplates");
        $this->style_generate();
        if( file_exists(DIR_CATALOG . "view/theme/oct_techstore/stylesheet/stylesheet_minify.css") ) 
        {
            unlink(DIR_CATALOG . "view/theme/oct_techstore/stylesheet/stylesheet_minify.css");
        }

        if( file_exists(DIR_CATALOG . "view/theme/oct_techstore/js/javascript_minify.js") ) 
        {
            unlink(DIR_CATALOG . "view/theme/oct_techstore/js/javascript_minify.js");
        }

        $this->session->data["success"] = $this->language->get("text_success_cache");
        if( isset($this->request->get["store_id"]) ) 
        {
            $store_id = $this->request->get["store_id"];
        }
        else
        {
            $store_id = 0;
        }

        $this->response->redirect($this->url->link("extension/theme/oct_techstore/main", "token=" . $this->session->data["token"] . "&store_id=" . $store_id, true));
    }

    public function style_generate()
    {
        $this->load->model("setting/setting");
        if( isset($this->request->get["store_id"]) ) 
        {
            $store_id = $this->request->get["store_id"];
        }
        else
        {
            $store_id = 0;
        }

        $setting_info = $this->model_setting_setting->getSetting("oct_techstore", $store_id);
        if( isset($setting_info["oct_techstore_verification"]) ) 
        {
            $form_data = $this->config->get( 'oct_techstore_data' );
        }
        else
        {
            $form_data = array(  );
        }

        $styles = "";
        if( $form_data ) 
        {
            if( $form_data["maincolor1"] ) 
            {
                $styles .= "#top, .oct-product-tab .owl-carousel .owl-item .cart .oct-button.wishlist, .oct-product-tab .owl-carousel .owl-item .cart .oct-button.compare, .oct-carousel-row .owl-carousel .owl-item .cart .oct-button.wishlist, .oct-carousel-row .owl-carousel .owl-item .cart .oct-button.compare, .product-thumb .cart .oct-button.wishlist, .product-thumb .cart .oct-button.compare, .oct-day-goods-box .owl-carousel .owl-item .things-to-buy, .oct-product-tab ul.nav-tabs > li.active, .oct-product-tab ul.nav-tabs > li:hover, #back-top:hover, #uptocall-mini:hover .uptocall-mini-phone, .field-tip .tip-content, footer, .filtered input[type=checkbox]:checked+label::before, .filtered input[type=radio]:checked+label::before, #sstore-3-level>ul>li>a, .product-buttons-row .button-one-click, .product-buttons-row .button-wishlist, .product-buttons-row .button-compare, .product-tabs-row .nav-tabs>li.active>a, .product-tabs-row .nav-tabs>li.active>a:focus, .product-tabs-row .nav-tabs>li.active>a:hover, footer .actions button:hover, .popup-button:hover, #column-left .list-group, #column-right .list-group, .oct-news-panel .list-group {\n";
                $styles .= "\tbackground-color: #" . $form_data["maincolor1"] . ";\n";
                $styles .= "}\n";
                $styles .= ".oct-button:hover, .oct-button-inv {\n";
                $styles .= "\tbackground-color: #" . $form_data["maincolor1"] . " !important;\n";
                $styles .= "}\n";
                $styles .= "a, #search .btn-lg, .phones-dropdown a, #menu .nav > li > a, .oct-carousel-header, .oct-category-item-text ul li a, .oct-category-item-text ul li a:visited, .oct-category-item-text ul li.oct-category-see-more a:hover, .oct-product-tab .owl-carousel .owl-item .name a, .oct-carousel-row .owl-carousel .owl-item .name a, .oct-day-goods-box .owl-carousel .owl-wrapper-outer .item .oct-day-goods-item .name a, .news-carousel-box .owl-carousel .owl-wrapper-outer .item .oct-news-item .name a, .oct-product-tab .owl-carousel .owl-buttons div, .oct-carousel-row .owl-carousel .owl-buttons div, .oct-day-goods-box .owl-carousel .owl-buttons div, .news-carousel-box .owl-carousel .owl-buttons div, .brands-carousel-box .owl-carousel .owl-buttons div, .news-carousel-box .owl-carousel .owl-wrapper-outer .item .oct-news-item .news-date, .news-carousel-box .owl-carousel .owl-wrapper-outer .item .oct-news-item .news-date span, .breadcrumb > li a, h1.cat-header, .sort-row .input-group-addon, .appearance .btn-group button, .box-heading, a.list-group-item, button.list-group-item, input[type='text'].form-control, select.form-control, input[type='password'].form-control, .filtered .link i, .filtered .checkbox input[type=checkbox]+label, .filtered .checkbox-inline input[type=checkbox]+label, .filtered .radio input[type=radio]+label, .filtered .radio-inline input[type=radio]+label, #sstore-3-level ul ul ul li a, .product-thumb h4 a, .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover, .pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover, .product-header, .after-header-item, .found-cheaper a, .found-cheaper a:visited, .product-price h3, .number .btn-minus button i, .number .btn-plus button i, .product-info-li span, .product-info-li a, .product-info-li a:visited, .product-advantages-box a span, h2.popup-header, .popup-form-box input[type='text'], .popup-form-box input[type='tel'], .popup-form-box input[type='email'], #auth-popup .auth-popup-links a.reg-popup-link, .popup-text, .popup-text a, #product .control-label, .popup-form-box textarea, .oct-bottom-cart-in-cart p, .account-content .buttons div .button-back, .account-content .table-div table .button-back, .popup-text a:hover, .oct-carousel-header a:hover, #column-left .panel-default>.panel-heading, .oct-news-panel>.panel-heading, #column-right .panel-default>.panel-heading, #oneclick-popup #main-price {\n";
                $styles .= " color: #" . $form_data["maincolor1"] . ";\n";
                $styles .= "}\n";
                $styles .= "#menu .nav > li:hover, .oct-slideshow-box .owl-controls .owl-page span {\n";
                $styles .= "\tborder-color: #" . $form_data["maincolor1"] . ";\n";
                $styles .= "}\n";
                $styles .= "#filter-products-form .expanded .item-content .filter-results:hover .filter-tooltip-corner {\n";
                $styles .= "\tborder-right-color: #" . $form_data["maincolor1"] . ";\n";
                $styles .= "}\n";
                $styles .= ".product-tabs-row .nav-tabs>li.active>a:before {\n";
                $styles .= "\tborder-top-color: #" . $form_data["maincolor1"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["maincolor2"] ) 
            {
                $styles .= "#menu .nav > li:hover, #menu ul.flexMenu-popup > li:hover, .oct-button, .oct-button:visited, .oct-button:focus, #back-top, #uptocall-mini .uptocall-mini-phone, .oct-day-goods-box .owl-carousel .owl-wrapper-outer .item .oct-day-goods-item:hover .things-to-buy, .oct-day-goods-box .owl-carousel .owl-wrapper-outer .item .oct-day-goods-item:hover .things-to-buy .flip-clock-wrapper ul li a div div.inn, footer .actions button, #sstore-3-level ul>li.has-sub>a.toggle-a:before, #sstore-3-level ul>li.has-sub>a.toggle-a:after, .product-tabs-row .nav-tabs>li>a, ul.account-ul li a:hover, .popup-button, .oct-fastorder-header span, #column-left .panel-default>.panel-heading, #column-right .panel-default>.panel-heading, .oct-news-panel>.panel-heading, #column-left .list-group a.active, #column-left .list-group a.active:hover, #column-left .list-group a:hover, #column-right .list-group a.active, #column-right .list-group a.active:hover, #column-right .list-group a:hover, .oct-news-panel .list-group a.active, .oct-news-panel .list-group a.active:hover, .oct-news-panel .list-group a:hover{\n";
                $styles .= "\tbackground-color: #" . $form_data["maincolor2"] . ";\n";
                $styles .= "}\n";
                $styles .= ".product-thumb .cart .oct-button.wishlist:hover, .product-thumb .cart .oct-button.compare:hover, .product-buttons-row .button-wishlist:hover, .product-buttons-row .button-compare:hover, .button-one-click:hover, .wishlist-tr, .oct-product-tab .owl-carousel .owl-item .cart .oct-button.wishlist:hover, .oct-product-tab .owl-carousel .owl-item .cart .oct-button.compare:hover, .oct-carousel-row .owl-carousel .owl-item .cart .oct-button.wishlist:hover, .oct-carousel-row .owl-carousel .owl-item .cart .oct-button.compare:hover, .product-thumb .cart .oct-button.wishlist:hover, .product-thumb .cart .oct-button.compare:hover, .oct-button-inv:hover  {\n";
                $styles .= "\tbackground-color: #" . $form_data["maincolor2"] . "!important;\n";
                $styles .= "}\n";
                $styles .= "#top .btn-link.btn-language:hover, #top .btn-link.btn-currency:hover, #top #top-right-links .dropdown-menu li a:hover, header .dropdown-menu li a:hover, #cart .cart-total-price, .buttons-top-box div a:hover, #menu .sale-ul > div .megamenu-sale-item .dropprice, .oct-slideshow-box .owl-controls .owl-buttons div:hover, .oct-category-item-text ul li.oct-category-see-more a, .oct-product-tab .owl-carousel .owl-item .price .price-new, .oct-carousel-row .owl-carousel .owl-item .price .price-new, .oct-day-goods-box .owl-carousel .owl-item .price .price-new, .oct-product-tab .owl-carousel .owl-buttons div:hover, .oct-carousel-row .owl-carousel .owl-buttons div:hover, .oct-day-goods-box .owl-carousel .owl-buttons div:hover, .news-carousel-box .owl-carousel .owl-buttons div:hover, .brands-carousel-box .owl-carousel .owl-buttons div:hover, footer h5, footer .h5, footer .first-row .socials-box a:hover, footer a:hover, footer .footer-contacts ul li i, .breadcrumb > li span, .appearance .btn-group button.active, .appearance .btn-group button:hover, .product-list .product-thumb h4 a:hover, .rating .fa-star, .rating .fa-star + .fa-star-o, .oct-product-stock span, .pagination>li:first-child>a, .pagination>li:first-child>span, .pagination>li>a, .pagination>li>span, .after-header-item .blue, .product-price h2, .number .btn-minus button:hover i, .number .btn-plus button:hover i, .product-advantages-box i, ul.account-ul li a, .account-content form legend, .account-content h2, .account-content .buttons div .button-back:hover, .account-content .table-div table .button-back:hover, .popup-text .item-link, .popup-text .blue, #product-options-popup .blue, #auth-popup .auth-popup-links a.forget-popup-link, #main-price, #cheaper-popup .main-price, .popup-text a, .oct-product-tab ul.nav-tabs > li a, .oct-fastorder-header, #checkout-fastorder-page .table .oct-bottom-cart-table-text, .fastorder-panel-group .oct-bottom-cart-total-cart .total-text span, .oct-carousel-header a, .oct-carousel-header a:visited, .oct-category-item-box .oct-category-item-text .oct-category-item-header, .main-advantage-item .main-advantage-item-icon i, #oneclick-popup #main-price.oneclick-main-price, .oct-category-item-text ul li a:hover, .breadcrumb > li a:hover, #subcats .subcat-box:hover a, #cart-popup .popup-text span {\n";
                $styles .= "\tcolor: #" . $form_data["maincolor2"] . ";\n";
                $styles .= "}\n";
                $styles .= "#top #top-right-links .dropdown-menu li a:hover, header .dropdown-menu li a:hover, #menu .megamenu-full-width a:hover, #menu .megamenu-full-width a.megamenu-parent-img:hover + a, .oct-product-tab .owl-carousel .owl-item .name a:hover, .oct-product-tab .owl-carousel .owl-item .image:hover + .name a, .oct-carousel-row .owl-carousel .owl-item .name a:hover, .oct-carousel-row .owl-carousel .owl-item .image:hover + .name a, .oct-day-goods-box .owl-carousel .owl-item .name a:hover, .oct-day-goods-box .owl-carousel .owl-item .image:hover + .name a, .news-carousel-box .owl-carousel .owl-item .name a:hover, .news-carousel-box .owl-carousel .owl-item .image:hover + .name a, #top .btn-link.language-select:hover, #top .btn-link.currency-select:hover, #menu .megamenu-full-width .see-all, footer .oct-text-terms a:hover, .popup-cart-box .oct-popup-cart-link {\n";
                $styles .= "\tcolor: #" . $form_data["maincolor2"] . "!important;\n";
                $styles .= "}\n";
                $styles .= "@media only screen and (min-width: 1024px) {\n";
                $styles .= "\t.product-grid .product-thumb:hover h4 a {\n";
                $styles .= "\t\tcolor: #" . $form_data["maincolor2"] . ";\n";
                $styles .= "\t}\n";
                $styles .= "}\n";
                $styles .= ".oct-slideshow-box .owl-controls .owl-page.active span, .oct-slideshow-box .owl-controls .owl-page span:hover, .filtered input[type=checkbox]+label::before, .filtered input[type=radio]+label::before {\n";
                $styles .= "\tborder-color: #" . $form_data["maincolor2"] . ";\n";
                $styles .= "}\n";
                $styles .= ".selected-thumb {\n";
                $styles .= "\tborder-color: #" . $form_data["maincolor2"] . "!important;\n";
                $styles .= "}\n";
                $styles .= "#top #top-left-links ul li a:hover, #top #top-right-links > ul > li:hover {\n";
                $styles .= "\tborder-bottom-color: #" . $form_data["maincolor2"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_1line_bg_1line"] ) 
            {
                $styles .= "#top {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_1line_bg_1line"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_1line_bg_main"] ) 
            {
                $styles .= "header, .menu-row {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_1line_bg_main"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_1line_color_1line_link"] ) 
            {
                $styles .= "#top #top-left-links ul li a, #top #top-left-links ul li a:visited, #top .btn-link.btn-language, #top .btn-link.btn-currency, #top #top-right-links > ul > li a, #top #top-right-links > ul > li a:visited, #top #top-right-links > ul > li a:hover {\n";
                $styles .= "\tcolor: #" . $form_data["head_1line_color_1line_link"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_1line_color_1line_link_hover"] ) 
            {
                $styles .= "#top #top-left-links ul li a:hover, #top .btn-link.btn-language:hover, #top .btn-link.btn-currency:hover, #top #top-right-links > ul > li a:hover {\n";
                $styles .= "\tcolor: #" . $form_data["head_1line_color_1line_link_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_1line_bg_1line_link_hover"] ) 
            {
                $styles .= "#top #top-left-links ul li a:hover {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_1line_bg_1line_link_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_1line_bg_tine_and_account"] ) 
            {
                $styles .= "#top #top-right-links > ul > li {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_1line_bg_tine_and_account"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_1line_bg_underscores_hover"] ) 
            {
                $styles .= "#top #top-left-links ul li a:hover, #top #top-right-links > ul > li:hover {\n";
                $styles .= "\tborder-bottom-color: #" . $form_data["head_1line_bg_underscores_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_dropdown_el_bg"] ) 
            {
                $styles .= "#top .dropdown-menu, header .dropdown-menu {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_dropdown_el_bg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_dropdown_el_color_link"] ) 
            {
                $styles .= "#top .btn-link.language-select, #top .btn-link.currency-select, #top-links li, #top-links a, #top #top-right-links .dropdown-menu li span, #top #top-right-links .dropdown-menu li a, header .dropdown-menu li a {\n";
                $styles .= "\tcolor: #" . $form_data["head_dropdown_el_color_link"] . "!important;\n";
                $styles .= "}\n";
            }

            if( $form_data["head_dropdown_el_color_link_hover"] ) 
            {
                $styles .= "#top #form-currency .currency-select:hover, #top #form-language .language-select:hover, #top #top-right-links .dropdown-menu li a:hover, header .dropdown-menu li a:hover {\n";
                $styles .= "\tcolor: #" . $form_data["head_dropdown_el_color_link_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_2ndline_color_tel_text"] ) 
            {
                $styles .= ".phones-dropdown a {\n";
                $styles .= "\tcolor: #" . $form_data["head_2ndline_color_tel_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_2ndline_color_tel_icon"] ) 
            {
                $styles .= ".phones-dropdown a i.fa-phone, .phones-dropdown a.show-phones {\n";
                $styles .= "\tcolor: #" . $form_data["head_2ndline_color_tel_icon"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_2ndline_bg_cart"] ) 
            {
                $styles .= "#cart {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_2ndline_bg_cart"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_2ndline_color_cart_text"] ) 
            {
                $styles .= ".buttons-top-box div a {\n";
                $styles .= "\tcolor: #" . $form_data["head_2ndline_color_cart_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_2ndline_color_cart_total"] ) 
            {
                $styles .= "#cart .cart-total-price {\n";
                $styles .= "\tcolor: #" . $form_data["head_2ndline_color_cart_total"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_2ndline_color_cart_text_hover"] ) 
            {
                $styles .= ".buttons-top-box div a:hover {\n";
                $styles .= "\tcolor: #" . $form_data["head_2ndline_color_cart_text_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_bg_link"] ) 
            {
                $styles .= "#menu .nav > li:hover {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_megamenu_bg_link"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_bg_link_underscores_hover"] ) 
            {
                $styles .= "#menu .nav > li:hover {\n";
                $styles .= "\tborder-color: #" . $form_data["head_megamenu_bg_link_underscores_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_color_link_text"] ) 
            {
                $styles .= "#menu .nav > li > a {\n";
                $styles .= "\tcolor: #" . $form_data["head_megamenu_color_link_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_color_link_text_hover"] ) 
            {
                $styles .= "#menu .nav > li:hover > a {\n";
                $styles .= "\tcolor: #" . $form_data["head_megamenu_color_link_text_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_el_bg"] ) 
            {
                $styles .= "#menu .dropdown-menu {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_megamenu_el_bg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_el_color_link"] ) 
            {
                $styles .= "#menu .dropdown-inner a {\n";
                $styles .= "\tcolor: #" . $form_data["head_megamenu_el_color_link"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_el_color_link_hover"] ) 
            {
                $styles .= "#menu .dropdown-menu .has-child:hover i, #menu .dropdown-menu .has-child:hover a, #menu .dropdown-menu .has-child a:hover, #menu .oct-mm-info .dropdown-menu .has-child a:hover {\n";
                $styles .= "\tcolor: #" . $form_data["head_megamenu_el_color_link_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_el_color_link_2_hover"] ) 
            {
                $styles .= "@media only screen and (min-width: 992px) {#menu .second-level-li.has-child:hover > a, #menu .second-level-li.has-child:hover > a:visited, #menu .oct-mm-info .dropdown-menu ul li.second-level-li:hover a, #menu .oct-mm-simplecat .dropdown-menu ul li.second-level-li:hover > a {\n";
                $styles .= "\tcolor: #" . $form_data["head_megamenu_el_color_link_2_hover"] . " !important;\n";
                $styles .= "}}\n";
            }

            if( $form_data["head_megamenu_el_bg_link_hover"] ) 
            {
                $styles .= "#menu .dropdown-menu li.second-level-li:hover {\n";
                $styles .= "\tbackground-color: #" . $form_data["head_megamenu_el_bg_link_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_el_color_price_in_specials"] ) 
            {
                $styles .= "#menu .sale-ul > div .megamenu-sale-item .dropprice {\n";
                $styles .= "\tcolor: #" . $form_data["head_megamenu_el_color_price_in_specials"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["head_megamenu_el_color_price_old_in_specials"] ) 
            {
                $styles .= "#menu .sale-ul > div .megamenu-sale-item .dropprice span {\n";
                $styles .= "\tcolor: #" . $form_data["head_megamenu_el_color_price_old_in_specials"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_bg_foot"] ) 
            {
                $styles .= "footer {\n";
                $styles .= "\tbackground-color: #" . $form_data["foot_bg_foot"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_links"] ) 
            {
                $styles .= "footer a, footer a:visited, footer .third-row ul li {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_links"] . " !important;\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_links_hover"] ) 
            {
                $styles .= "footer a:hover {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_links_hover"] . " !important;\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_guarantee_icon"] ) 
            {
                $styles .= "footer .footer-advantages-box .footer-advantages a, footer .footer-advantages-box .footer-advantages a:visited {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_guarantee_icon"] . " !important;\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_guarantee_icon_hover"] ) 
            {
                $styles .= "footer .footer-advantages-box .footer-advantages:hover a {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_guarantee_icon_hover"] . " !important;\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_guarantee_text"] ) 
            {
                $styles .= "footer .footer-advantages span {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_guarantee_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_heading_text"] ) 
            {
                $styles .= "footer h5, footer .h5 {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_heading_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_contact_icon"] ) 
            {
                $styles .= "footer .footer-contacts ul li i {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_contact_icon"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_bg_bar"] ) 
            {
                $styles .= "#oct-slide-panel .oct-slide-panel-heading {\n";
                $styles .= "\tbackground-color: #" . $form_data["foot_bg_bar"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_bg_bar_el_hover"] ) 
            {
                $styles .= "#oct-last-seen-link:hover, #oct-favorite-link:hover, #oct-compare-link:hover, #oct-bottom-cart-link:hover, .oct-panel-link-active, #hide-slide-panel {\n";
                $styles .= "\tbackground-color: #" . $form_data["foot_bg_bar_el_hover"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_bar_el_text"] ) 
            {
                $styles .= ".oct-panel-link, .oct-panel-link:focus, .oct-panel-link:visited {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_bar_el_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["foot_color_bar_el_text_hover"] ) 
            {
                $styles .= ".oct-panel-link:hover, .oct-panel-link-active a {\n";
                $styles .= "\tcolor: #" . $form_data["foot_color_bar_el_text_hover"] . "!important;\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_discountbg"] ) 
            {
                $styles .= ".oct-discount-item {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_discountbg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_discountcolor"] ) 
            {
                $styles .= ".oct-discount-item {\n";
                $styles .= "\tcolor: #" . $form_data["cat_discountcolor"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_color_price"] ) 
            {
                $styles .= ".product-thumb .price, .oct-price-normal  {\n";
                $styles .= "\tcolor: #" . $form_data["cat_color_price"] . " !important;\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_color_price_old"] ) 
            {
                $styles .= ".product-thumb .price-old, .oct-price-old  {\n";
                $styles .= "\tcolor: #" . $form_data["cat_color_price_old"] . " !important;\n";
                $styles .= "}\n";
            }

            if( isset($form_data["cat_color_price_new"]) && $form_data["cat_color_price_new"] ) 
            {
                $styles .= ".product-thumb .price-new, .oct-price-new {\n";
                $styles .= "\tcolor: #" . $form_data["cat_color_price_new"] . " !important;\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_boxtext"] ) 
            {
                $styles .= ".box-heading {\n";
                $styles .= "\tcolor: #" . $form_data["cat_boxtext"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_boxbg"] ) 
            {
                $styles .= ".box-heading {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_boxbg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_modulebg"] ) 
            {
                $styles .= ".box-content, .box-content.filtered {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_modulebg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_itembg"] ) 
            {
                $styles .= ".filtered .list-group-item.item-name, .filtered .list-group-item.item-name:hover {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_itembg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_plusminus"] ) 
            {
                $styles .= ".filtered .link i {\n";
                $styles .= "\tcolor: #" . $form_data["cat_plusminus"] . "!important;\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_checkbox"] ) 
            {
                $styles .= ".filtered input[type=checkbox]+label::before, .filtered input[type=radio]+label::before {\n";
                $styles .= "\tborder-color: #" . $form_data["cat_checkbox"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_checkboxactive"] ) 
            {
                $styles .= ".filtered input[type=checkbox]:checked+label::before, .filtered input[type=radio]:checked+label::before {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_checkboxactive"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_1levelbg"] ) 
            {
                $styles .= "#sstore-3-level>ul>li>a {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_1levelbg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_1levelcolor"] ) 
            {
                $styles .= "#sstore-3-level>ul>li>a {\n";
                $styles .= "\tcolor: #" . $form_data["cat_1levelcolor"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_2levelbg"] ) 
            {
                $styles .= "#sstore-3-level ul ul li a {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_2levelbg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_2levelcolor"] ) 
            {
                $styles .= "#sstore-3-level ul ul li a {\n";
                $styles .= "\tcolor: #" . $form_data["cat_2levelcolor"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_3levelbg"] ) 
            {
                $styles .= "#sstore-3-level ul ul ul li a {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_3levelbg"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_3levelcolor"] ) 
            {
                $styles .= "#sstore-3-level ul ul ul li a {\n";
                $styles .= "\tcolor: #" . $form_data["cat_3levelcolor"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_3levelbgactive"] ) 
            {
                $styles .= "#sstore-3-level ul ul ul li a.current-link {\n";
                $styles .= "\tbackground-color: #" . $form_data["cat_3levelbgactive"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["cat_3leveltextactive"] ) 
            {
                $styles .= "#sstore-3-level ul ul ul li a.current-link {\n";
                $styles .= "\tcolor: #" . $form_data["cat_3leveltextactive"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_button_add_ro_cart"] ) 
            {
                $styles .= ".product-buttons-box #button-cart {\n";
                $styles .= "\tbackground-color: #" . $form_data["pr_color_button_add_ro_cart"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_button_add_ro_cart_hover"] ) 
            {
                $styles .= ".product-buttons-box #button-cart:hover {\n";
                $styles .= "\tbackground-color: #" . $form_data["pr_color_button_add_ro_cart_hover"] . "!important;\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_button_other"] ) 
            {
                $styles .= ".product-buttons-row .button-one-click, .product-buttons-row .button-wishlist, .product-buttons-row .button-compare {\n";
                $styles .= "\tbackground-color: #" . $form_data["pr_color_button_other"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_button_other_hover"] ) 
            {
                $styles .= ".product-buttons-row .button-one-click:hover, .product-buttons-row .button-wishlist:hover, .product-buttons-row .button-compare:hover {\n";
                $styles .= "\tbackground-color: #" . $form_data["pr_color_button_other_hover"] . "!important;\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_bg_block"] ) 
            {
                $styles .= ".number, .found-cheaper, .after-header-item {\n";
                $styles .= "\tbackground-color: #" . $form_data["pr_bg_block"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_bg_tab"] ) 
            {
                $styles .= ".product-tabs-row .nav-tabs>li>a {\n";
                $styles .= "\tbackground-color: #" . $form_data["pr_bg_tab"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_bg_tab_active"] ) 
            {
                $styles .= ".product-tabs-row .nav-tabs>li.active>a, .product-tabs-row .nav-tabs>li.active>a:focus, .product-tabs-row .nav-tabs>li.active>a:hover {\n";
                $styles .= "\tbackground-color: #" . $form_data["pr_bg_tab_active"] . ";\n";
                $styles .= "}\n";
                $styles .= ".product-tabs-row .nav-tabs>li.active>a:before {\n";
                $styles .= "\tborder-top-color: #" . $form_data["pr_bg_tab_active"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_tab_text"] ) 
            {
                $styles .= ".product-tabs-row .nav-tabs>li>a, .product-tabs-row .nav-tabs>li.active>a, .product-tabs-row .nav-tabs>li.active>a:focus, .product-tabs-row .nav-tabs>li.active>a:hover {\n";
                $styles .= "\tcolor: #" . $form_data["pr_color_tab_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_image_border"] ) 
            {
                $styles .= ".selected-thumb {\n";
                $styles .= "\tborder-color: #" . $form_data["pr_color_image_border"] . "!important;\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_guarantee_icon"] ) 
            {
                $styles .= ".product-advantages-box i {\n";
                $styles .= "\tcolor: #" . $form_data["pr_color_guarantee_icon"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_guarantee_text"] ) 
            {
                $styles .= ".product-advantages-box a span {\n";
                $styles .= "\tcolor: #" . $form_data["pr_color_guarantee_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_guarantee_text"] ) 
            {
                $styles .= ".product-advantages-box a span {\n";
                $styles .= "\tcolor: #" . $form_data["pr_color_guarantee_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_block_under_heading_text"] ) 
            {
                $styles .= ".after-header-item {\n";
                $styles .= "\tcolor: #" . $form_data["pr_color_block_under_heading_text"] . ";\n";
                $styles .= "}\n";
            }

            if( $form_data["pr_color_block_under_heading_text"] ) 
            {
                $styles .= ".after-header-item .blue {\n";
                $styles .= "\tcolor: #" . $form_data["pr_color_block_under_heading_text"] . ";\n";
                $styles .= "}\n";
            }

            $styles .= "@media only screen and (max-width: 992px) {\n";
            if( $form_data["mob_mainlinebg"] ) 
            {
                $styles .= " #top {\n";
                $styles .= "\t background-color: #" . $form_data["mob_mainlinebg"] . " !important;\n";
                $styles .= " }\n";
            }

            if( $form_data["mod_mainline_iconcolor"] ) 
            {
                $styles .= " .top-mobile-item a {\n";
                $styles .= "\t color: #" . $form_data["mod_mainline_iconcolor"] . ";\n";
                $styles .= " }\n";
            }

            if( $form_data["mod_dropdown_headingbg"] ) 
            {
                $styles .= " .menu-mobile-header {\n";
                $styles .= "\t background-color: #" . $form_data["mod_dropdown_headingbg"] . ";\n";
                $styles .= " }\n";
            }

            if( $form_data["mod_dropdown_heading_and_buttoncolor"] ) 
            {
                $styles .= " .menu-mobile-header, .close-m-search a {\n";
                $styles .= "\t color: #" . $form_data["mod_dropdown_heading_and_buttoncolor"] . " !important;\n";
                $styles .= " }\n";
            }

            if( $form_data["mod_dropdown_linktextcolor"] ) 
            {
                $styles .= " #info-mobile-box ul li a, #info-mobile-box > ul > li, #info-mobile ul div .btn-link.btn-language, #info-mobile ul div .btn-link.btn-currency {\n";
                $styles .= "\t color: #" . $form_data["mod_dropdown_linktextcolor"] . " !important;\n";
                $styles .= " }\n";
            }

            if( $form_data["mod_header_iconrcolor"] ) 
            {
                $styles .= " .mobile-icons-box a {\n";
                $styles .= "\t color: #" . $form_data["mod_header_iconrcolor"] . " !important;\n";
                $styles .= " }\n";
            }

            if( $form_data["mod_header_iconrbg"] ) 
            {
                $styles .= " .mobile-icons-box a span {\n";
                $styles .= " \t background-color: #" . $form_data["mod_header_iconrbg"] . " !important;\n";
                $styles .= " }\n";
            }

            $styles .= "}\n";
        }

        file_put_contents(DIR_CATALOG . "view/theme/oct_techstore/stylesheet/dynamic_stylesheet.css", $styles);
    }

    public function install()
    {
        $this->load->language("extension/theme/oct_techstore");
        $this->load->model("extension/extension");
        $this->load->model("setting/setting");
        $this->load->model("user/user_group");
        $this->model_user_user_group->addPermission($this->user->getId(), "access", "extension/theme/oct_techstore");
        $this->model_user_user_group->addPermission($this->user->getId(), "modify", "extension/theme/oct_techstore");
        if( !in_array("oct_techstore", $this->model_extension_extension->getInstalled("theme")) ) 
        {
            $this->model_extension_extension->install("theme", "oct_techstore");
        }

        $this->style_generate();
        $this->session->data["success"] = $this->language->get("text_success_install");
    }

    public function uninstall()
    {
        $this->load->model("extension/extension");
        $this->model_extension_extension->uninstall("theme", "oct_techstore");
    }

    public function get_icons()
    {
        $data = array(  );
        if( isset($this->request->get["block_id"]) && isset($this->request->get["type"]) ) 
        {
            $data["block_id"] = $this->request->get["block_id"];
            $data["type"] = $this->request->get["type"];
            $this->response->setOutput($this->load->view("extension/theme/oct_techstore_icons", $data));
        }

    }

    private function validate()
    {
        if( !$this->user->hasPermission("modify", "extension/theme/oct_techstore") ) 
        {
            $this->error["warning"] = $this->language->get("error_permission");
        }

        if( !$this->checkRemoteFile() ) 
        {
            $this->error["warning"] = $this->language->get("error_license_server");
        }

        if( empty($this->request->post["oct_techstore_product_limit"]) ) 
        {
            $this->error["product_limit"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_product_description_length"]) ) 
        {
            $this->error["product_description_length"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_category_width"]) || empty($this->request->post["oct_techstore_image_category_height"]) ) 
        {
            $this->error["image_category"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_thumb_width"]) || empty($this->request->post["oct_techstore_image_thumb_height"]) ) 
        {
            $this->error["image_thumb_width"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_popup_width"]) || empty($this->request->post["oct_techstore_image_popup_height"]) ) 
        {
            $this->error["image_popup_width"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_product_width"]) || empty($this->request->post["oct_techstore_image_product_height"]) ) 
        {
            $this->error["image_product_width"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_additional_width"]) || empty($this->request->post["oct_techstore_image_additional_height"]) ) 
        {
            $this->error["image_additional"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_related_width"]) || empty($this->request->post["oct_techstore_image_related_height"]) ) 
        {
            $this->error["image_related_width"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_compare_width"]) || empty($this->request->post["oct_techstore_image_compare_height"]) ) 
        {
            $this->error["image_compare_width"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_wishlist_width"]) || empty($this->request->post["oct_techstore_image_wishlist_height"]) ) 
        {
            $this->error["image_wishlist_width"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_cart_width"]) || empty($this->request->post["oct_techstore_image_cart_height"]) ) 
        {
            $this->error["image_cart_width"] = $this->language->get("error_warning");
        }

        if( empty($this->request->post["oct_techstore_image_location_width"]) || empty($this->request->post["oct_techstore_image_location_height"]) ) 
        {
            $this->error["image_location_width"] = $this->language->get("error_warning");
        }

        return (!$this->error ? true : false);
    }

    private function validate_verification()
    {
        if( !$this->user->hasPermission("modify", "extension/theme/oct_techstore") ) 
        {
            $this->error["warning"] = $this->language->get("error_permission");
        }

        if( !$this->checkRemoteFile() ) 
        {
            $this->error["warning"] = $this->language->get("error_license_server");
        }

        if( empty($this->request->post["oct_techstore_verification"]) ) 
        {
            $this->error["verification"] = $this->language->get("error_verification");
        }

        return (!$this->error ? true : false);
    }

    private function checkRemoteFile()
    {
        return true;
    }
}