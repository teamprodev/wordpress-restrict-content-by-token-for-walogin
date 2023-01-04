<div class="wl-r-container">

    <h2 class="wl-r-page-title">
        <?php echo esc_html__('Restricted content', 'walogin'); ?>
    </h2>

    <div class="wl-r-row">
        <div class="wl-r-title">
            <?php echo esc_html__('Why can\'t you access this page!', 'walogin'); ?>
        </div>
        <div class="wl-r-desc">
            <?php echo esc_html__('This page is a restricted page. To access this page, you must have the following Tokens and amounts in your wallet address linked to your account.', 'walogin'); ?>
        </div>
        <div class="wl-r-collections">
            <div class="wl-r-collection">
            <?php echo esc_html($amount) ?> <?php echo esc_html__('Piece', 'walogin') ?>: <?php echo esc_html($token->getName()) ?> (<?php echo esc_html($token->getSymbol()) ?>) - <?php echo esc_html($token->getAddress()) ?> - <?php echo esc_html($chainName) ?>
            </div>
        </div>
    </div>
    
    <div class="wl-r-row">
        <div class="wl-r-title">
            <?php echo esc_html__('I have the required Tokens in the required quantities but cannot see the content?', 'walogin'); ?>
        </div>
        <div class="wl-r-desc">
            <?php echo esc_html__('You may not be logged in right now. If the login button below appears, login or register. Or if you are logged in, your account will appear below. Perhaps you have not linked your wallet to your account, or you have linked the wrong wallet address, or you may have logged in with a wrong wallet address.', 'walogin'); ?>
        </div>
    </div>

    <div class="wl-r-login-register">
        <?php echo do_shortcode('[walogin-init]'); ?>
    </div>

    <?php if (isset($this->currentUser->walletAddress)) : ?>
        <span class="connected-address">
            <?php echo esc_html__('Connected address: ', 'walogin'); ?>
            <?php echo esc_html($this->currentUser->walletAddress); ?>
        </span>
    <?php endif; ?>
</div>