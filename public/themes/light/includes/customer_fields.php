<div class="transit_inner contact tq-form-fields-container <?php echo $hide_section; ?>" > <!-- your contact section start here -->
    <div class="transit_header">   <!-- Delivery Address section start here -->
        <h2><?php echo self::get_setting('tq_pro_form_options','contact_section_title', 'Your Contact Information'); ?></h2>
    </div>
    <div class="transit_body">
        <div class="full">
            <div class="left half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-name"></i>First Name</span>
                <input type="text" name="first_name" id="first_name" required data-parsley-maxlength="45" placeholder="Enter first name">
                <span class="bt-flabels__error-desc">Required / Invalid First Name</span>
            </div>
            <div class="right half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-name"></i>Last Name</span>
                <input type="text" name="last_name" id="last_name" required  data-parsley-maxlength="45" placeholder="Enter last name">
                <span class="bt-flabels__error-desc">Required / Invalid Last Name </span>
            </div>
        </div>
        <div class="full">
            <div class="left half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-phone-number"></i>Phone Number</span>
                <input type="text" data-parsley-type="number" required name="phone" class="phone" data-parsley-maxlength="45" placeholder="Enter your phone number">
                <span class="bt-flabels__error-desc">Required / Invalid Phone Number </span>
            </div>
            <div class="right half bt-flabels__wrapper">
                <span class="sub_title"><i class="icon icon-icn-email"></i>Email address</span>
                <input type="text"  id="email" data-parsley-type="email" name="email" required data-parsley-maxlength="128" placeholder="Enter your email address">
                <span class="bt-flabels__error-desc">Required / Invalid Email</span>
            </div>
        </div>
        <div class="full bt-flabels__wrapper">
            <span class="sub_title">
                <i class="icon icon-icn-description"></i><?php echo self::get_setting('tq_pro_form_options','job_info_label', 'Delivery Details'); ?>
            </span>
            <textarea tabindex="5" name="description" id="description" placeholder="Describe your additional information.."></textarea>
            <span class="bt-flabels__error-desc">Required / Invalid </span>
        </div>
    </div>
</div> <!-- your contact section end here -->
           