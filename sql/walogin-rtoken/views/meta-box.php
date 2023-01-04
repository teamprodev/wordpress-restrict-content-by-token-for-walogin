<p class="post-attributes-label-wrapper page-template-label-wrapper">
    <label class="post-attributes-label">
        <?php echo esc_html__('Restrict with Token', 'walogin'); ?>
    </label>
</p>
<select style="width:100%" name="walogin-rtoken" id="walogin-rtoken">
    <option value="none"><?php echo esc_html__('None'); ?></option>
    <?php if ($predefinedTokens) : ?>
        <?php foreach ($predefinedTokens as $key => $value) : 
            $selected = $selectedToken == $value['name'] ? 'selected' : null;
            ?>
            <option value="<?php echo esc_attr($value['name']); ?>" <?php echo esc_attr($selected) ?>>
                <?php echo esc_attr($value['name']); ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>