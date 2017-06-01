<?php
/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
require_once WNCU_DIR . 'admin/includes/wncu-settings-api.php' ; 
if ( !class_exists('Wncu_Settings' ) ):
class Wncu_Settings {
    private $settings_api;
    function __construct() {
        $this->settings_api = new Wncu_Settings_API;
        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }
    function admin_init() {
        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );
        //initialize settings
        $this->settings_api->admin_init();
    }
    function admin_menu() {
        add_menu_page( 'XE Currency', 'پرشین پیمنت', 'delete_posts', 'wncu-xe', array($this, 'plugin_page'),'dashicons-chart-line',79 );
    }
    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'general_tab',
                'title' => __( 'تنظیمات عمومی', 'wncu' )
            ),            
            array(
                'id' => 'currencies',
                'title' => __( 'تابلو ارز', 'wncu' )
            ),
            array(
                'id' => 'calculation',
                'title' => __( 'فرم محاسبه', 'wncu' )
            ),
            array(
                'id' => 'emails',
                'title' => __( 'پیغام ها', 'wncu' )
            ),
            array(
                'id' => 'online_service',
                'title' => __( 'پرداخت آنلاین', 'wncu' )
            )
        );
        return $sections;
    }
    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'general_tab' => array(
                array(
                    'name'              => 'wncu_user',
                    'label'             => __( 'یوزرنیم', 'wncu' ),
                    'desc'              => __( 'یوزنیم XE را وارد نمایید', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_pass',
                    'label'             => __( 'پسورد', 'wncu' ),
                    'desc'              => __( 'پسورد XE را وارد نمایید', 'wncu' ),
                    'type'              => 'password'
                ),                
                array(
                    'name'              => 'wncu_tableone',
                    'label'             => __( 'تعداد آیتم جدول یک', 'wncu' ),
                    'desc'              => __( 'چند آیتم در جدول اول نشان داده شود؟ مثال 6', 'wncu' ),
                    'default'           => __( '6', 'wncu' ),
                    'type'              => 'number'
                ),                  
                array(
                    'name'              => 'wncu_usd_havale',
                    'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'number'
                ),
                array(
                    'name'              => 'wncu_fetchhavale',
                    'label'             => __( 'استخراج اتوماتیک', 'wncu' ),
                    'desc'              => __( 'در صورت فعال بودن, نرخ حواله ( در صورت مجود بودن ) جایگزین نرخ حواله دستی میشود.', 'wncu' ),
                    'type'              => 'checkbox'
                ),
                array(
                    'name'              => 'wncu_lastest_havale_parsi',
                    'label'             => __( 'آخرین قیمت حواله از صرافی پارسی', 'wncu' ),
                    'desc'              => __( 'در صورتی که گزینه استخراج اتوماتیک فعال باشد با فعال کردن این گزینه میتوانید حتی زمانهایی که قیمت در صرافی پارسی مجود نبود آخرین قیمت صرافی پارسی را در نظر بگیرد.(اگر صرافی پارسی قیمتی نداشته باشد و این گزینه هم فعال نباشد از فیلد نرخ حواله بازار استفاده میشود.)', 'wncu' ),
                    'type'              => 'checkbox'
                ),
                array(
                    'name'              => 'wncu_hour_validate',
                    'label'             => __( 'زمان ولید بودن آخرین استخراج', 'wncu' ),
                    'desc'              => __( 'تا چه زمانی آخرین انتخا از سایت صرافی پارسی ولید میباشد بدیهی است بعد از این ساعت اگر باز هم سایت صرافی پارسی قیمتی اعلام نکرد نرخ حواله از نرخ حواله دستی خوانده خواهد شد اما به محض قرار گیری نرخ حواله در صرافی پارسی دوباره از این سایت استخراج خواهد شد.', 'wncu' ),
                    'type'              => 'select',
                    'options'           => array(
                        '1'        =>  '1 ساعت',   
                        '2'        =>  '2 ساعت',   
                        '3'        =>  '3 ساعت',   
                        '4'        =>  '4 ساعت',   
                        '5'        =>  '5 ساعت',   
                        '6'        =>  '6 ساعت',   
                        '7'        =>  '7 ساعت',   
                        '8'        =>  '8 ساعت',   
                        '9'        =>  '9 ساعت',   
                        '10'        => '10 ساعت',  
                        '11'        => '11 ساعت',  
                        '12'        => '12 ساعت',  
                        '13'        => '13 ساعت',  
                        '14'        => '14 ساعت',  
                        '15'        => '15 ساعت',  
                        '16'        => '16 ساعت',  
                        '17'        => '17 ساعت',  
                        '18'        => '18 ساعت',  
                        '19'        => '19 ساعت',  
                        '20'        => '20 ساعت',  
                        '21'        => '21 ساعت',  
                        '22'        => '22 ساعت',  
                        '23'        => '23 ساعت',  
                        '24'        => '24 ساعت',  
                        '2day'      =>   '2 روز',
                        '3day'      =>   '3 روز',
                    )
                ),               
                array(
                    'name'              => 'wncu_warning',
                    'label'             => __( 'شرایط اضطرار', 'wncu' ),
                    'desc'              => __( 'حذف تمامی قیمتهای جدول و نمایش پیغام اضطری "تماس بگیرید".', 'wncu' ),
                    'type'              => 'checkbox'
                ),                     
                array(
                    'name'              => 'wncu_msg',
                    'label'             => __( 'پیغام بالای تابلو', 'wncu' ),
                    'desc'              => __( 'اگر شرایط اضطرار فعال باشد در مقابل نرخ های جدول " لطفا تماس بگیرید " نمایش داده خواهد شد همینطور با این کادر امکان نشان دادن پیغامی بالای جدول امکانپذیر است ( این پیغام در صورتی که گزینه ی بالا فعال باشد نشان داده میشود ).', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_nightmode',
                    'label'             => __( 'فعال کردن حال شب', 'wncu' ),
                    'desc'              => __( 'در صورت فعال بودن این گزینه سیستم به صورت هوشمند به XE هیت خواهد زد اگر این گزینه غیر فعال باشد به صورت منظم طبق زمانبندی داده شده هیت خواهد زد', 'wncu' ),
                    'type'              => 'checkbox'
                ),
                array(
                    'name'              => 'wncu_kaf_havale',
                    'label'             => __( 'کف حواله قابل ارسال', 'wncu' ),
                    'desc'              => __( 'اگر این کادر مثلا 1000 باشد مینیموم ارسال حواله 1000 واحد برای تمام ارز هاست.', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_kaf_havale_rial',
                    'label'             => __( 'کف حواله قابل ارسال از تومان', 'wncu' ),
                    'desc'              => __( 'کف مبلغ ریالی که میتوان حواله فرستاد (به تومان)', 'wncu' ),
                    'type'              => 'text'
                )
            ),         
            'currencies' => array(
                array(
                    'name'              => 'wncu_usd_hr',
                    'label'             => __( '<span class="wncu_divi" > USD </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_usd',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'USD', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_usd_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_usd_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_usd_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( '5,10,15,30,hourly,twicedaily,daily', 'wncu' ),
                    'type'              => 'text'
                ),  
                array(
                    'name'              => 'wncu_cad_hr',
                    'label'             => __( '<span class="wncu_divi" > CAD </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_cad',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'CAD', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_cad_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_cad_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_cad_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),                   
                array(
                    'name'              => 'wncu_eur_hr',
                    'label'             => __( '<span class="wncu_divi" > EUR </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_eur',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'EUR', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_eur_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_eur_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_eur_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_gbp_hr',
                    'label'             => __( '<span class="wncu_divi" > GBP </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_gbp',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'GBP', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_gbp_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_gbp_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_gbp_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_aud_hr',
                    'label'             => __( '<span class="wncu_divi" > AUD </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_aud',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'AUD', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_aud_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_aud_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_aud_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_cny_hr',
                    'label'             => __( '<span class="wncu_divi" > CNY </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_cny',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'CNY', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_cny_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_cny_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_cny_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_aed_hr',
                    'label'             => __( '<span class="wncu_divi" > AED </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_aed',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'AED', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_aed_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_aed_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_aed_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_hkd_hr',
                    'label'             => __( '<span class="wncu_divi" > HKD </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_hkd',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'HKD', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_hkd_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_hkd_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_hkd_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_chf_hr',
                    'label'             => __( '<span class="wncu_divi" > CHF </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_chf',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'CHF', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_chf_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_chf_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_chf_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_dkk_hr',
                    'label'             => __( '<span class="wncu_divi" > DKK </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_dkk',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'DKK', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_dkk_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_dkk_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_dkk_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_sek_hr',
                    'label'             => __( '<span class="wncu_divi" > SEK </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_sek',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'SEK', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_sek_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_sek_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_sek_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_sgd_hr',
                    'label'             => __( '<span class="wncu_divi" > SGD </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_sgd',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'SGD', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_sgd_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_sgd_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_sgd_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                                array(
                    'name'              => 'wncu_nzd_hr',
                    'label'             => __( '<span class="wncu_divi" > NZD </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_nzd',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'NZD', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_nzd_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_nzd_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_nzd_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                ),   
                array(
                    'name'              => 'wncu_zar_hr',
                    'label'             => __( '<span class="wncu_divi" > ZAR </span>', 'wncu' ),
                    'desc'              => __( '<hr>', 'wncu' ),
                    'type'              => 'html'
                ),
                array(
                    'name'              => 'wncu_zar',
                    'label'             => __( 'نام ارز', 'wncu' ),
                    'default'              => __( 'ZAR', 'wncu' ),
                    'type'              => 'text'
                ),
                // array(
                //     'name'              => 'wncu_zar_havale',
                //     'label'             => __( 'نرخ حواله بازار', 'wncu' ),
                //     'desc'              => __( '', 'wncu' ),
                //     'type'              => 'text'
                // ),               
                array(
                    'name'              => 'wncu_zar_sood',
                    'label'             => __( 'نرخ درصد سود', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'text'
                ),
                array(
                    'name'              => 'wncu_zar_time',
                    'label'             => __( 'زمان بروز رسانی', 'wncu' ),
                    'desc'              => __( 'hourly,twicedaily,daily,5,10,15,30', 'wncu' ),
                    'type'              => 'text'
                )  

            ),
            'calculation' => array(
                array(
                    'name'              => 'wncu_karmozd',
                    'label'             => __( 'نرخ کارمزد پیش فرض', 'wncu' ),
                    'desc'              => __( 'تومان', 'wncu' ),
                    'type'              => 'text'
                )
                // array(
                //     'name'              => 'wncu_pass',
                //     'label'             => __( 'پسورد', 'wncu' ),
                //     'desc'              => __( 'پسورد XE را وارد نمایید', 'wncu' ),
                //     'type'              => 'password'
                // ),                
                // array(
                //     'name'              => 'wncu_tableone',
                //     'label'             => __( 'تعداد آیتم جدول یک', 'wncu' ),
                //     'desc'              => __( 'چند آیتم در جدول اول نشان داده شود؟ مثال 6', 'wncu' ),
                //     'default'           => __( '6', 'wncu' ),
                //     'type'              => 'number'
                // )               
                // array(
                //     'name'              => 'wncu_tabletow',
                //     'label'             => __( 'تعداد آیتم جدول دوم', 'wncu' ),
                //     'desc'              => __( 'چند آیتم در جدول دوم نشان داده شود؟ مثال 7', 'wncu' ),
                //     'default'           => __( '7', 'wncu' ),
                //     'type'              => 'number'
                // )
            ),
            'emails' => array(
                array(
                    'name'              => 'wncu_admin_email',
                    'label'             => __( 'ایمیل ادمین را وارد نمایید.', 'wncu' ),
                    'default'           => get_option( 'admin_email' ),
                    'type'              => 'text'
                    ),            
                array(
                    'name'              => 'wncu_mail_admin',
                    'label'             => __( 'ایمیل به مدیر', 'wncu' ),
                    'desc'              => __( 'ایمیلی که برای مدیر ارسال میشود', 'wncu' ),
                    'default'           => __( 'ممنون فاکتور شما با موفقیت ثبت شد.', 'wncu' ),
                    'type'              => 'wysiwyg'
                    ),
                array(
                    'name'              => 'wncu_mail_user',
                    'label'             => __( 'ایمیل به مشتری', 'wncu' ),
                    'desc'              => __( 'ایمیلی که برای مشتری ارسال میشود', 'wncu' ),
                    'default'           => __( 'ممنون فاکتور شما با موفقیت ثبت شد.', 'wncu' ),
                    'type'              => 'wysiwyg'
                )
                // array(
                //     'name'              => 'wncu_pass',
                //     'label'             => __( 'پسورد', 'wncu' ),
                //     'desc'              => __( 'پسورد XE را وارد نمایید', 'wncu' ),
                //     'type'              => 'password'
                // ),                
                // array(
                //     'name'              => 'wncu_tableone',
                //     'label'             => __( 'تعداد آیتم جدول یک', 'wncu' ),
                //     'desc'              => __( 'چند آیتم در جدول اول نشان داده شود؟ مثال 6', 'wncu' ),
                //     'default'           => __( '6', 'wncu' ),
                //     'type'              => 'number'
                // )               
                // array(
                //     'name'              => 'wncu_tabletow',
                //     'label'             => __( 'تعداد آیتم جدول دوم', 'wncu' ),
                //     'desc'              => __( 'چند آیتم در جدول دوم نشان داده شود؟ مثال 7', 'wncu' ),
                //     'default'           => __( '7', 'wncu' ),
                //     'type'              => 'number'
                // )
            ), 
            'online_service' => array(
                array(
                    'name'              => 'wncu_oservice_karmozd',
                    'label'             => __( 'کارمزد پرداخت آنلاین', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'number'
                ),
                array(
                    'name'              => 'wncu_ponline_karmozd',
                    'label'             => __( 'کارمزد نقد درآمد ارزی', 'wncu' ),
                    'desc'              => __( '', 'wncu' ),
                    'type'              => 'number'
                )
            ),            
        );
        return $settings_fields;
    }
    function plugin_page() {
        echo '<div class="wrap">';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
    }
    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }
}
endif;