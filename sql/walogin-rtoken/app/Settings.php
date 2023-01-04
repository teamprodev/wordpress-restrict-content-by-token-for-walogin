<?php

namespace BeycanPress\Walogin\RToken;

use BeycanPress\Walogin\PluginHero\Setting;
use BeycanPress\Walogin\PluginHero\Helpers;

class Settings 
{
    use Helpers;

    public function __construct()
    {
        add_filter("Walogin/AddonLoad", '__return_true');
        add_action('Walogin/AddonSettings', function(){

            $chains = [];
            if ($this->setting('chains')) {
                foreach ($this->setting('chains') as $chain) {
                    $chains[$chain['id']] = $chain['name'];
                }
            }
            
            Setting::createSection(array(
                'id'     => 'rtokenSettings', 
                'title'  => esc_html__('Restrict By Token', 'walogin'),
                'icon'   => 'fa fa-cog',
                'fields' => array(
                    array(
                        'id'      => 'predefinedTokens',
                        'title'   => esc_html__('Add predefined Tokens', 'walogin'),
                        'type'    => 'group',
                        'help'    => esc_html__('Add predefined Tokens', 'walogin'),
                        'button_title' => esc_html__('Add new', 'walogin'),
                        'sanitize' => function($val) {
                            if (is_array($val)) {
                                foreach ($val as $key => &$value) {
                                    $value['chain'] = intval($value['chain']);
                                    $value['amount'] = intval($value['amount']);
                                    $value['name'] = sanitize_text_field($value['name']);
                                    $value['contract'] = sanitize_text_field($value['contract']);
                                }
                            }
    
                            return $val;
                        },
                        'fields'    => array(
                            array(
                                'title' => esc_html__('Please give a name', 'walogin'),
                                'id'    => 'name',
                                'type'  => 'text'
                            ),
                            array(
                                'title' => esc_html__('Chain', 'walogin'),
                                'id'    => 'chain',
                                'type'  => 'select',
                                'options' => $chains
                            ),
                            array(
                                'title' => esc_html__('Contract address', 'walogin'),
                                'id'    => 'contract',
                                'type'  => 'text',
                                'desc' => esc_html__('Example: 0x06012c8cf97bead5deae237070f9587f8e7a266d', 'walogin')
                            ),
                            array(
                                'title' => esc_html__('Minimum amunt', 'walogin'),
                                'id'    => 'amount',
                                'type'  => 'number',
                                'desc' => esc_html__('How amount of this Token should it have?', 'walogin')
                            ),
                        ),
                    ),
                ) 
            ));
        }, 9);
    }
}