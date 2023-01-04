<?php

namespace BeycanPress\Walogin\RToken;

use BeycanPress\Walogin\PluginHero\Helpers;

class MetaBox
{
    use Helpers;

    /**
     * Class construct
     * @return void
     */
    public function __construct()
    {
        add_action('post_updated', array( $this, 'saveRestrictByToken' ), 10, 3);

        add_action('add_meta_boxes', function() {
            add_meta_box(
                'walogin_restrict_by_token',
                esc_html__('Restrict by Token', 'walogin'),
                array($this, 'restrictByToken'),
                array('post', 'product', 'page'),
                'side',
                'high'
            );
        });
    }

    /**
     * @param object $post
     * @return void
     */
    public function restrictByToken($post)
    {
        $this->createNewNonceField();
        $predefinedTokens = $this->setting('predefinedTokens');
        $selectedToken = get_post_meta($post->ID, 'walogin_rtoken', true);
        
        $this->addonViewEcho('meta-box', [
            'predefinedTokens' => $predefinedTokens, 
            'selectedToken' => $selectedToken
        ]);
    }

    /**
     * @param integer $postId current post
     * @param object $postAfter post savad after data
     * @return void
     */
    function saveRestrictByToken($postId, $postAfter)
    {
        // Permission control
        $postType = get_post_type_object($postAfter->post_type);
        if (!current_user_can( $postType->cap->edit_post, $postId)) {
            return $postId;
        }

        // Post type control
        if(!in_array($postAfter->post_type, ['post', 'product', 'page'])) {
            return $postId;
        }

        // Autosave control
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || !$this->checkNonceField()) {
            return $postId;
        }
    
        if (isset($_POST['walogin-rtoken'])) {
            $token = isset($_POST['walogin-rtoken']) ? sanitize_text_field($_POST['walogin-rtoken']) : null;

            update_post_meta($postId, 'walogin_rtoken', $token);
        }
        
        return $postId;
    }

}