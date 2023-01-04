<?php

namespace BeycanPress\Walogin\RToken;

use Beycan\MultiChain\Token;
use Beycan\MultiChain\MultiChain;
use BeycanPress\Walogin\PluginHero\Helpers;

class Restrict
{
    use Helpers;

    public function __construct()
    {
        add_action('init', function() {
            add_shortcode('walogin-rtoken', [$this, 'init']);
        });

        add_filter('the_content', [$this, 'wpPost']);

        add_action('woocommerce_before_single_product', [$this, 'wcProduct']);
    }

    /**
     * @return void
     */
    public function wcProduct() : void
    {
        global $post;
        $selectedToken = get_post_meta($post->ID, 'walogin_rtoken', true);

        if ($selectedToken && $selectedToken != 'none' && is_product()) {
            ob_start();

            $content = $this->restrictControl($this->getSelectedToken($selectedToken));
            if ($content == null) {
                return;
            }

            print($content);

            get_footer();

            echo exit(ob_get_clean());
        } 
    }

    /**
     * @param string $content
     * @return string
     */
    public function wpPost($content) : string
    {
        global $post;
        $selectedToken = get_post_meta($post->ID, 'walogin_rtoken', true);

        if (function_exists('WC')) {
            if (is_checkout() || is_account_page() || is_woocommerce() || is_cart()) return $content;
        }

        if ($selectedToken && $selectedToken != 'none' && is_page() || is_single()) {
            add_filter('pings_open', '__return_false', 20, 2);
            add_filter('comments_open', '__return_false', 20, 2);
            add_filter('comments_array', '__return_empty_array', 10, 2);
            return $this->restrictControl($this->getSelectedToken($selectedToken), $content);
        }

        return $content;
    }

    /**
     * @param string $selectedToken
     * @return null|object
     */
    private function getSelectedToken(string $selectedToken) : ?object
    {
        if (!$predefinedTokens = $this->setting('predefinedTokens')) return null;
        $index = array_search($selectedToken, array_column($predefinedTokens, 'name'));
        return (object) $predefinedTokens[$index];
    }

    /**
     *
     * @param array $atts
     * @param string $content
     * @return string
     */
    public function init($atts, $content) : string
    {
        extract(shortcode_atts([
            'contract' => null,
            'chain' => null,
            'amount' => 1
        ], $atts));
        
        if (!$contract) {
            return esc_html__('The "contract" parameter is mandatory!', 'walogin');
        }

        if (!$chain) {
            return esc_html__('The "chain" parameter is mandatory!', 'walogin');
        }

        if (!$chains = $this->setting('chains')) {
            return esc_html__('Chains not found!', 'walogin');
        }

        $index = array_search($chain, array_column($chains, 'id'));
        if (!$chain = isset($chains[$index]) ? (object) $chains[$index] : null) {
            return esc_html__('Chain not found!', 'walogin');
        }
        
        $predefinedTokens = $this->setting('predefinedTokens');
        $index = array_search($contract, array_column($predefinedTokens, 'contract'));
        $selectedToken = (object) $predefinedTokens[$index];

        return $this->restrictControl($selectedToken, $content);
    }

    /**
     * @param object $selectedToken
     * @param null|string $content
     * @return null|string
     */
    private function restrictControl(object $selectedToken, ?string $content = null) : ?string
    {
        $chains = $this->setting('chains');
        $index = array_search($selectedToken->chain, array_column($chains, 'id'));
        $chain = isset($chains[$index]) ? (object) $chains[$index] : null;

        $walletAddress = isset($this->currentUser->walletAddress) ? $this->currentUser->walletAddress : null;
        $multiChain = new MultiChain($chain->rpcUrl, $chain->nativeCurrency);
        $token = new Token($selectedToken->contract);
        
        if (is_user_logged_in() && $walletAddress && $token->getBalance($walletAddress) >= $selectedToken->amount) {
            return do_shortcode($content);
        }

        $this->addAddonStyle('css/main.css');

        return $this->addonView('restrict', [
            'token' => $token,
            'chainName' => $chain->name,
            'amount' => $selectedToken->amount,
        ]);
    }

}